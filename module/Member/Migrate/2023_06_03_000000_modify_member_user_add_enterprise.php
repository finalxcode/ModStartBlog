<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ModifyMemberUserAddEnterprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_user', function (Blueprint $table) {
            $table->string('company_type', 50)->nullable()->comment('企业类型');
            $table->string('company_name', 100)->nullable()->comment('企业名称');
            $table->string('company_size', 50)->nullable()->comment('企业规模');
            $table->string('revenue', 50)->nullable()->comment('营收规模');
            $table->text('company_description')->nullable()->comment('企业简介');
            $table->string('contact_position', 50)->nullable()->comment('联系人职位');
            $table->string('telephone', 20)->nullable()->comment('固定电话');
            $table->string('zip_code', 10)->nullable()->comment('邮政编码');
            $table->string('address', 200)->nullable()->comment('通讯地址');
            $table->string('website', 255)->nullable()->comment('网站地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_user', function (Blueprint $table) {
            $table->dropColumn([
                'company_type',
                'company_name',
                'company_size',
                'revenue',
                'company_description',
                'contact_position',
                'telephone',
                'zip_code',
                'address',
                'website'
            ]);
        });
    }
}