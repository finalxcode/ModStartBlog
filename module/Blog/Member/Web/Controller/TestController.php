<?php

namespace Module\Blog\Member\Web\Controller;

use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {
        return view('blog.member::test.index');
    }
}
