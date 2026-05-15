<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string('nationlaity', 250)->nullable();
            $table->string('code', 250)->nullable();
            $table->string('flag', 250)->nullable();
            $table->string('currency', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
             $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('countries');
    }
};
