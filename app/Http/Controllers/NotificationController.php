<?php
namespace App\Http\Controllers;
class NotificationController extends Controller
{
    public function sendForgetPasswordSuccess()
    {
        return view('notifications.send_forget_password_success');
    }
}
