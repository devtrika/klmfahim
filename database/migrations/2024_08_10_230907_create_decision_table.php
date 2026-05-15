<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDecisionTable extends Migration {

    public function down() {
        Schema::dropIfExists('decision_setting');
        Schema::dropIfExists('decision_attendance');
        Schema::dropIfExists('decision_decisions');
        Schema::dropIfExists('issue_decisions');
    }

    public function up() {
        Schema::create('issue_decisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('decision_id', 250)->nullable();
            $table->string('decision_date', 250)->nullable(); // 
            $table->string('decision_time', 250)->nullable(); // 
            $table->string('responsible', 250)->nullable(); //الأطراف المعنية
            $table->longText('decision_describtion')->nullable();
            $table->string('issue_id', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('decision_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->string('type', 250)->nullable();
            $table->integer('body_sample_id')->nullable();
            $table->integer('setting_sample_id')->nullable();
            $table->string('main_money', 250)->nullable();
            $table->string('bonus_money', 250)->nullable();
            $table->string('another_money', 250)->nullable();
            $table->string('candidates', 250)->nullable();
            $table->string('issue_start_date', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
        });

        Schema::create('decision_decisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('issue_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('decision_id')->nullable();
            $table->string('start_date', 250)->nullable();
            $table->string('start_time', 250)->nullable();
            $table->string('for_who', 250)->nullable(); //الأطراف المعنية
            $table->longText('describtion')->nullable();
            $table->string('type')->nullable();
            $table->string('decisions_start_date')->nullable();
            $table->string('decisions_end_date')->nullable();
            $table->string('decisions_type')->nullable();
            $table->string('is_session', 250)->nullable(); // 

            $table->string('days')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
        });

        Schema::create('decision_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('decision_st_id')->nullable();
            $table->string('attendance', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
        });
    }
}
