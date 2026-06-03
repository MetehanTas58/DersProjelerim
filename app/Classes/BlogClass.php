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

            $query = Blogs::join('blogs_translate as bt', 'bt.blog_id', '=', 'blogs.id')
                ->select('blogs.id', 'blogs.status', 'blogs.type_id', 'bt.title', 'bt.description', 'bt.content')
                ->where('bt.lang_code', 'tr');

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
                        return 'Blog';
                    } else {
                        return 'Haber';
                    }
                })
                ->addColumn('status_name', function ($blog) {
                    if ($blog->status == 1) {
                        return 'Aktif';
                    } else {
                        return 'Pasif';
                    }
                })
                ->addColumn('action', function ($blog) {
                    $statusBtn = $blog->status == 1 
                        ? '<a href="#" class="btn btn-warning btn-sm me-2 min-btn-table toggleStatusBtn" data_id="' . $blog->id . '" data_status="0">Pasif Yap</a>'
                        : '<a href="#" class="btn btn-warning btn-sm me-2 min-btn-table toggleStatusBtn" data_id="' . $blog->id . '" data_status="1">Aktif Yap</a>';

                    return '<a href="' . route('blog.edit', $blog->id) . '" class="btn btn-primary btn-sm me-2 min-btn-table">Düzenle</a>'
                        . $statusBtn
                        . '<a href="#" class="btn btn-danger btn-sm min-btn-table delBlogBtn" data_id="' . $blog->id . '">Sil</a>';
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

            if ($blog_id) {
                $blog = Blogs::find($blog_id);
                if (!$blog) {
                    return ["status" => false, "message" => "Blog bulunamadı."];
                }
            } else {
                $blog = new Blogs();
                $blog->create_user_id = Auth::user()->id;
            }

            $blog->update_user_id = Auth::user()->id;
            $blog->status = $data['status'] ?? $blog->status;
            $blog->type_id = $data['type_id'] ?? $blog->type_id;

            if ($blog->save()) {
                // Update translations (default lang 'tr')
                \Illuminate\Support\Facades\DB::table('blogs_translate')->updateOrInsert(
                    ['blog_id' => $blog->id, 'lang_code' => 'tr'],
                    [
                        'title' => $data['title'] ?? '',
                        'description' => $data['description'] ?? '',
                        'content' => $data['content'] ?? '',
                        'create_user_id' => Auth::user()->id,
                        'update_user_id' => Auth::user()->id,
                        'updated_at' => now(),
                    ]
                );

                return ["status" => true, "message" => "Blog/Haber başarıyla kaydedildi."];
            } else {
                return ["status" => false, "message" => "Kaydedilirken hata oluştu."];
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
                return ["status" => false, "message" => "Parametre Bilgileri Alınmadı."];
            }

            $blog = Blogs::find($blog_id);
            if ($blog == null) {
                return ["status" => false, "message" => "Blog/Haber Bulunamadı."];
            }

            // Delete translations first
            \Illuminate\Support\Facades\DB::table('blogs_translate')->where('blog_id', $blog_id)->delete();

            // Delete blog
            if ($blog->delete()) {
                return [
                    "status" => true,
                    "message" => "Blog/Haber kaydı başarıyla silindi."
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "Blog/Haber kaydı silinirken bir hata oluştu."
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => "Blog/Haber kaydı silinmesi başarısız. Hata: " . $th->getMessage()
            ];
        }
    }

    public function toggleStatus()
    {
        try {
            $blog_id = request()->get('blog_id');
            $status = request()->get('status');

            if ($blog_id === null || $status === null) {
                return ["status" => false, "message" => "Parametre Bilgileri Alınmadı."];
            }

            $blog = Blogs::find($blog_id);
            if ($blog == null) {
                return ["status" => false, "message" => "Blog/Haber Bulunamadı."];
            }

            $blog->status = $status;
            if ($blog->save()) {
                $statusText = $status == 1 ? 'Aktif' : 'Pasif';
                return [
                    "status" => true,
                    "message" => "Blog/Haber durumu başarıyla " . $statusText . " yapıldı."
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "Durum güncellenirken bir hata oluştu."
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => "Hata: " . $th->getMessage()
            ];
        }
    }

}
