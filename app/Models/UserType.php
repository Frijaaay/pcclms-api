<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'user_type'
    // ];
    public $timestamps = false;

    // ORM Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
