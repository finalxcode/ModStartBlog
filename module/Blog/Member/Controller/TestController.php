<?php

namespace Module\Blog\Member\Controller;

use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {
        return view('blog.member::test.index');
    }
}
