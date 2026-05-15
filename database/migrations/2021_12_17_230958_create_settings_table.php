<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->text('describtion')->nullable();
            $table->text('tags')->nullable();
            $table->string('iphone', 250)->nullable();
            $table->string('android', 250)->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('snapchat', 250)->nullable();
            $table->string('facebook', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('phone', 250)->nullable();
            $table->longText('address')->nullable();
            $table->string('fax', 250)->nullable();
            $table->string('logo', 250)->default('logo.png');
            $table->string('footer_logo', 250)->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
        });
    }

    public function down() {
        Schema::drop('settings');
    }
}
