<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('type', 250)->nullable(); //('شكوي','مقترح','طلب','اخري')
            $table->string('name', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->text('msg')->nullable();
            $table->text('replay')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('seen', array('yes', 'no'))->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
             $table->string('slug', 250)->default(uniqid());
        });
    }

    public function down() {
        Schema::drop('contacts');
    }

}
