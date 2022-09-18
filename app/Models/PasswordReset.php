<?php

namespace App\Models;

use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    public static function createToken($email)
    {
        $token = \Str::random(6);
        PasswordReset::where('email', $email)->delete();
        PasswordReset::insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);

        event('sendmail.static', [[
            'type' => 'reset_password',
            'data' => [
                'url' => \VRoute::get('reset-password') . '?email=' . $email . '&token=' . $token,
                'token' => $token,
            ],
            'email' => $email,
            'title' => 'Lấy lại mật khẩu',
        ]]);

        return $token;
    }
}
