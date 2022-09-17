<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserType extends BaseModel
{
    use HasFactory;
    const NORMAL_ACCOUNT = 1;
    const TEACHER_ACCOUNT = 2;
    const ADMIN_ACCOUNT = 3;
}