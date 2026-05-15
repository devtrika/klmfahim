<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOthersTable extends Migration {

    public function down() {
        Schema::drop('experts'); //الخبراء وامناء السر 
    }

    public function up() {
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname_id', 250)->nullable();
            $table->string('first', 250)->nullable();
            $table->string('second', 250)->nullable();
            $table->string('third', 250)->nullable();
            $table->string('four', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->string('id_type', 250)->nullable();
            $table->string('id_number', 250)->nullable();
            $table->string('other_id', 250)->nullable();
            $table->string('birthdate', 250)->nullable();
            $table->string('isagent', 250)->nullable();
            $table->string('isuser', 250)->nullable();
            $table->longText('notes')->nullable();
            $table->string('status', 250)->nullable();
            $table->string('type', 250)->nullable();
            $table->string('attach', 250)->nullable();
            $table->string('isthere', 250)->nullable();
            
            $table->string('typeof', 250)->nullable();
            ////expert خبير  OR .. // admin امين السر
            //imposeter  //arbitration //against
            $table->integer('rquest_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->timestamps();
            $table->softDeletes();

            $table->string('', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
        });
    }
}
