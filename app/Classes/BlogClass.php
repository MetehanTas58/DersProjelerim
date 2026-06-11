<?php

namespace App\Classes;

use App\Models\Blogs;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class BlogClass
{

    public function getData()
    {
        try {
            $status = request()->get('status');
            $type = request()->get('type');

            $query = Blogs::leftJoin('blogs_translate as bt', function ($join) {
                    $join->on('bt.blog_id', '=', 'blogs.id')
                         ->where('bt.lang_code', '=', app()->getLocale());
                })
                ->leftJoin('blogs_translate as bt_fallback', function ($join) {
                    $join->on('bt_fallback.blog_id', '=', 'blogs.id')
                         ->where('bt_fallback.lang_code', '=', 'tr');
                })
                ->select(
                    'blogs.id',
                    'blogs.status',
                    'blogs.type_id',
                    \Illuminate\Support\Facades\DB::raw('COALESCE(bt.title, bt_fallback.title) as title'),
                    \Illuminate\Support\Facades\DB::raw('COALESCE(bt.description, bt_fallback.description) as description'),
                    \Illuminate\Support\Facades\DB::raw('COALESCE(bt.content, bt_fallback.content) as content')
                );

            if ($status !== null && $status !== '') {
                $query->where('blogs.status', $status);
            }

            if ($type !== null && $type !== '' && $type != 0) {
                $query->where('blogs.type_id', $type);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addColumn('type_name', function ($blog) {
                    if ($blog->type_id == 1) {
                        return __('messages.blog');
                    } else {
                        return __('messages.news');
                    }
                })
                ->addColumn('status_name', function ($blog) {
                    if ($blog->status == 1) {
                        return __('messages.active');
                    } else {
                        return __('messages.passive');
                    }
                })
                ->addColumn('action', function ($blog) {
                    $statusBtn = $blog->status == 1 
                        ? '<a href="#" class="btn btn-warning btn-sm me-2 min-btn-table passiveBtn" data_id="' . $blog->id . '" data_status="0">' . __('messages.make_passive') . '</a>'
                        : '<a href="#" class="btn btn-warning btn-sm me-2 min-btn-table activeBtn" data_id="' . $blog->id . '" data_status="1">' . __('messages.make_active') . '</a>';

                    return '<a href="' . route('blog.edit', $blog->id) . '" class="btn btn-primary btn-sm me-2 min-btn-table">' . __('messages.edit') . '</a>'
                        . $statusBtn
                        . '<a href="#" class="btn btn-danger btn-sm min-btn-table delBlogBtn" data_id="' . $blog->id . '">' . __('messages.delete') . '</a>';
                })
                ->rawColumns(['action'])
                ->setRowAttr([
                    'data-id' => function($blog) {
                        return $blog->id;
                    }
                ])               
                ->make(true);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function saveBlog()
    {
        try {
            $data = request()->all();
            $blog_id = $data['blog_id'] ?? null;

            // Validasyon - kaydetmeden önce kontrol et
            if (empty($data['title'])) {
                return ["status" => false, "message" => __('messages.validation_title_required')];
            }
            if (empty($data['description'])) {
                return ["status" => false, "message" => __('messages.validation_description_required')];
            }
            if (empty($data['content'])) {
                return ["status" => false, "message" => __('messages.validation_content_required')];
            }

            if ($blog_id) {
                $blog = Blogs::find($blog_id);
                if (!$blog) {
                    return ["status" => false, "message" => __('messages.not_found')];
                }
            } else {
                $blog = new Blogs();
                $blog->create_user_id = Auth::user()->id;
            }

            $blog->update_user_id = Auth::user()->id;
            $blog->status = $data['status'] ?? $blog->status;
            $blog->type_id = $data['type_id'] ?? $blog->type_id;

            if ($blog->save()) {
                // Çeviri güncelle (aktif dil)
                \Illuminate\Support\Facades\DB::table('blogs_translate')->updateOrInsert(
                    ['blog_id' => $blog->id, 'lang_code' => app()->getLocale()],
                    [
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'content' => $data['content'],
                        'create_user_id' => Auth::user()->id,
                        'update_user_id' => Auth::user()->id,
                        'updated_at' => now(),
                    ]
                );

                // Eğer aktif dil tr değilse ve tr çevirisi henüz yoksa, tr çevirisini de oluştur/güncelle (fallback için)
                if (app()->getLocale() !== 'tr') {
                    $hasTr = \Illuminate\Support\Facades\DB::table('blogs_translate')
                        ->where('blog_id', $blog->id)
                        ->where('lang_code', 'tr')
                        ->exists();
                    if (!$hasTr) {
                        \Illuminate\Support\Facades\DB::table('blogs_translate')->insert([
                            'blog_id' => $blog->id,
                            'lang_code' => 'tr',
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'content' => $data['content'],
                            'create_user_id' => Auth::user()->id,
                            'update_user_id' => Auth::user()->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                return ["status" => true, "message" => __('messages.save_success')];
            } else {
                return ["status" => false, "message" => __('messages.fail_save')];
            }
        } catch (\Throwable $th) {
            return ["status" => false, "message" => "Hata: " . $th->getMessage()];
        }
    }

    public function delBlog()
    {
        try {
            $blog_id = request()->get('blog_id');
            if ($blog_id == null) {
                return ["status" => false, "message" => __('messages.param_missing')];
            }

            $blog = Blogs::find($blog_id);
            if ($blog == null) {
                return ["status" => false, "message" => __('messages.not_found')];
            }

            // Delete translations first
            \Illuminate\Support\Facades\DB::table('blogs_translate')->where('blog_id', $blog_id)->delete();

            // Delete blog
            if ($blog->delete()) {
                return [
                    "status" => true,
                    "message" => __('messages.delete_success')
                ];
            } else {
                return [
                    "status" => false,
                    "message" => __('messages.fail_delete')
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => __('messages.fail_delete') . " Hata: " . $th->getMessage()
            ];
        }
    }

    public function toggleStatus()
    {
        try {
            $blog_id = request()->get('blog_id');
            $status = request()->get('status');

            if ($blog_id === null || $status === null) {
                return ["status" => false, "message" => __('messages.param_missing')];
            }

            $blog = Blogs::find($blog_id);
            if ($blog == null) {
                return ["status" => false, "message" => __('messages.not_found')];
            }

            $blog->status = $status;
            if ($blog->save()) {
                return [
                    "status" => true,
                    "message" => __('messages.save_success')
                ];
            } else {
                return [
                    "status" => false,
                    "message" => __('messages.fail_status')
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => "Hata: " . $th->getMessage()
            ];
        }
    }

        public function passive()
    {
        try {

            $blog_id = request()->get('blog_id');
            if ($blog_id == null) {
                return ["status" => false, "message" => __('messages.param_missing')];
            }

            $mdl = Blogs::find($blog_id);
            if ($mdl == null) {
                return ["status" => false, "message" => __('messages.not_found')];
            }

            $mdl->status = 0;
            $mdl->update_user_id = Auth::user()->id;

            if ($mdl->save()) {
                return ["status" => true, "message" => __('messages.passive_success')];
            } else {
                return ["status" => false, "message" => __('messages.fail_status')];
            }

        } catch (\Throwable $th) {

            return [
                "status" => false,
                "message" => __('messages.fail_status') . " Hata: " . $th->getMessage()
            ];
        }
    }

    public function active()
    {
        try {

            $blog_id = request()->get('blog_id');
            if ($blog_id == null) {
                return ["status" => false, "message" => __('messages.param_missing')];
            }

            $mdl = Blogs::find($blog_id);
            if ($mdl == null) {
                return ["status" => false, "message" => __('messages.not_found')];
            }

            $mdl->status = 1;
            $mdl->update_user_id = Auth::user()->id;

            if ($mdl->save()) {
                return ["status" => true, "message" => __('messages.active_success')];
            } else {
                return ["status" => false, "message" => __('messages.fail_status')];
            }

        } catch (\Throwable $th) {

            return [
                "status" => false,
                "message" => __('messages.fail_status') . " Hata: " . $th->getMessage()
            ];
        }
    }
}
