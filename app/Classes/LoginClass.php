<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginClass
{
    public function login()
    {
        try {
            $email = request()->get('email');
            $password = request()->get('password');

            if ($email == null) {
                return ["status" => false, "message" => "Email Adresi Boş Olamaz."];
            }
            if ($password == null) {
                return ["status" => false, "message" => "Şifre Boş Olamaz."];
            }

            $user = User::where('email', $email)->first();
            
            // HATA 1: = ataması yerine == karşılaştırması olması gerekiyor
            if ($user == null) {
                return ["status" => false, "message" => "Kullanıcı bulunamadı"];
            }

            // HATA 2: Şifreler uyuşmuyorsa hata vermeli, uyuşuyorsa değil. (!) işareti eksikti
            if (!Hash::check($password, $user->password)) {
                return ["status" => false, "message" => "Şifre Hatalı"];
            }

            // HATA 3: Auth kullanımı
            Auth::login($user);
            if (Auth::check()) {
                return ["status" => true, "message" => "Giriş İşlemi Başarılı."];
            }
            
            return ["status" => false, "message" => "Bilinmeyen bir hata oluştu."];

        } catch (\Throwable $th) {
            // Geliştirme aşamasında sorunu net görmek için $th->getMessage() bastırılabilir
            // return ["status"=>false, "message" => $th->getMessage()]; 
            return ["status" => false, "message" => "Giriş İşlemi Başarısız."];
        }
    }
}
