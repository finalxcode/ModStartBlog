<?php

namespace Module\Blog\Member\Auth;

use Illuminate\Support\Facades\Session;
use Module\Blog\Member\Model\Member;

class MemberUser
{
    const SESSION_KEY = 'blog_member_user';

    public static function login($member)
    {
        Session::put(self::SESSION_KEY, [
            'id' => $member->id,
            'username' => $member->username,
            'phone' => $member->phone,
        ]);
    }

    public static function logout()
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function isLogin()
    {
        return Session::has(self::SESSION_KEY);
    }

    public static function id()
    {
        return self::isLogin() ? Session::get(self::SESSION_KEY)['id'] : 0;
    }

    public static function get($key = null)
    {
        if (!self::isLogin()) {
            return null;
        }
        if (is_null($key)) {
            return Session::get(self::SESSION_KEY);
        }
        return Session::get(self::SESSION_KEY)[$key] ?? null;
    }
}
