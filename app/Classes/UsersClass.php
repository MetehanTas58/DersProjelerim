<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersClass
{

    public function getData()
    {
        try {
            $data = User::all();

            return DataTables::of($data)
                ->addColumn('status_name', function ($user) {
                    if ($user->status == 1) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>';
                    } else {
                        return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle-fill me-1"></i>Pasif</span>';
                    }
                })
                ->addColumn('action', function ($user) {
                    return '<a href="' . route('users/edit', $user->id) . '" class="btn btn-sm btn-light text-primary border me-1 min-btn-table px-2" title="Düzenle"><i class="bi bi-pencil-square"></i></a>'
                        . '<a href="#" class="btn btn-sm btn-light text-danger border min-btn-table px-2 rowDelUserBtn" data_id="' . $user->id . '" title="Sil"><i class="bi bi-trash-fill"></i></a>';
                })
                ->setRowAttr([
                    'data-id' => function($user) {
                        return $user->id;
                    }
                ])
                ->rawColumns(['status_name', 'action'])               
                ->make(true);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function delUser()
    {
        try {

            $user_id = request()->get('user_id');
            if ($user_id == null) {
                return ["status" => false, "message" => "Paremetre Bilgileri Alınmadı."];
            }

            $user = User::find($user_id);
            if ($user == null) {
                return ["status" => false, "message" => "Kullanıcı Bulunamadı."];
            }

            if (FacadesAuth::user()->id == $user_id) {
                return ["status" => false, "message" => "Kendi Bilgilerinizi Silemezsiniz."];
            }

            if (DB::table('users')->where('id', $user_id)->delete()) {

                return [
                    "status" => true,
                    "message" => "Kullanıcı kaydı başarıyla silindi."
                ];

            } else {

                return [
                    "status" => false,
                    "message" => "Kullanıcı kaydı silinirken bir hata oluştu."
                ];
            }

        } catch (\Throwable $th) {

            return [
                "status" => false,
                "message" => "Kullanıcı silinmesi başarısız. Hata: " . $th->getMessage()
            ];
        }
    }

    public function saveUser()
    {
        return $this->save();
    }

    public function save()
    {
        try {
            $data = request()->all();
            $user_id = $data['user_id'] ?? null;

            if ($user_id) {
                $user = User::find($user_id);


                if (!$user) {
                    return ["status" => false, "message" => "Kullanıcı bulunamadı."];
                }
            } else {
                $user = new User();
            }

            $user->name = $data['name_surname'] ?? $user->name;
            $user->email = $data['email'] ?? $user->email;
            $user->phone = $data['phone'] ?? $user->phone;
            $user->status = $data['status'] ?? $user->status;

            if (!empty($data['password'])) {
                if ($data['password'] !== $data['password_rep']) {
                    return ["status" => false, "message" => "Şifreler eşleşmiyor."];
                }
                $user->password = Hash::make($data['password']);
            }

            if ($user->save()) {
                return ["status" => true, "message" => "Kullanıcı başarıyla kaydedildi."];
            } else {
                return ["status" => false, "message" => "Kaydedilirken hata oluştu."];
            }
        } catch (\Throwable $th) {
            return ["status" => false, "message" => "Hata: " . $th->getMessage()];
        }
    }

    public function createAdmin()
    {
        try {
            $user = User::where('email', 'admin@outlook.com')->first();
            if ($user) {
                return ["status" => false, "message" => "Admin kullanıcısı zaten mevcut."];
            }

            User::create([
                'name' => 'admin',
                'email' => 'admin@outlook.com',
                'password' => Hash::make('1234'),
                'status' => 1,
            ]);

            return ["status" => true, "message" => "Admin kullanıcısı başarıyla oluşturuldu."];
        } catch (\Throwable $th) {
            return ["status" => false, "message" => "Hata: " . $th->getMessage()];
        }
    }
}