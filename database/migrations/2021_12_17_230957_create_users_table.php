<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->integer('group_id')->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('username', 250)->nullable();
            $table->string('password');
            $table->char('verified_code', 8)->nullable();
            $table->char('reset_code', 8)->nullable();
            $table->string('image', 250)->nullable();
            $table->string('avatar', 250)->nullable();
            $table->string('status')->default('active');
            $table->enum('type', array('admin', 'user'))->nullable();
            $table->enum('seen', array('yes', 'no'))->nullable();
            $table->string('token', 250)->nullable();
            $table->string('remember_token', 250)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('isuser', array('yes', 'no'))->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('first', 250)->nullable();
            $table->string('second', 250)->nullable();
            $table->string('third', 250)->nullable();
            $table->string('four', 250)->nullable();
            $table->string('nationlaity')->nullable();
            $table->string('id_type', 250)->nullable();
            $table->string('id_number', 250)->nullable();
            $table->string('uni_number', 250)->nullable();
            $table->string('id_pic', 250)->nullable();
            $table->string('cv', 250)->nullable();
            $table->string('fax', 250)->nullable();
            $table->string('address_type', 250)->nullable();
            $table->string('post', 250)->nullable();
            $table->string('building', 250)->nullable();
            $table->string('add', 250)->nullable();
            $table->string('unit', 250)->nullable();
            $table->string('street', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('address_attach', 250)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::drop('users');
    }

}
