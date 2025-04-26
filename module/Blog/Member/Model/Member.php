<?php

namespace Module\Blog\Member\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Member extends Model
{
    protected $table = 'blog_member';
    
    protected $fillable = [
        'username', 'phone', 'password', 'status'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
