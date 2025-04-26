<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_member', function (Blueprint $table) {
            $table->id();
            $table->string('username')->comment('用户名');
            $table->string('phone')->unique()->comment('手机号');
            $table->string('password')->comment('密码');
            $table->tinyInteger('status')->default(1)->comment('状态：1-正常，0-禁用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_member');
    }
}
