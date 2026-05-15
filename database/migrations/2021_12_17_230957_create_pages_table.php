<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

    public function down() {
        Schema::dropIfExists('agents'); //الوكلاء
        Schema::dropIfExists('audiences'); //الحضور
        Schema::dropIfExists('letters');
        Schema::dropIfExists('sittings');
        Schema::dropIfExists('sitting_attendance');
        Schema::dropIfExists('sittings_decisions');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('laws');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('academic');
        Schema::dropIfExists('nicknames');
        Schema::dropIfExists('decisions');
        Schema::dropIfExists('types');
        Schema::dropIfExists('decision_type');
        Schema::dropIfExists('slides');
        Schema::dropIfExists('smaples');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('histories');
        chema::dropIfExists('certificates');
        chema::dropIfExists('usercontacts');
    }

    public function up() {
        Schema::create('sitting_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('sitting_id')->nullable();
            $table->string('attendance', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('first', 250)->nullable();
            $table->string('second', 250)->nullable();
            $table->string('third', 250)->nullable();
            $table->string('four', 250)->nullable();
            $table->string('birthdate')->nullable();
            $table->string('another_id', 250)->nullable();
            $table->string('rquest_id', 250)->nullable();
            $table->string('issue_id', 250)->nullable();
            $table->string('id_number', 250)->nullable();
            $table->string('other_id', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('type', 250)->nullable();
            $table->string('typeof', 250)->nullable(); //الوكيل ده لايه
            $table->longText('notes', 250)->nullable();
            $table->string('nickname_id', 250)->nullable();
            $table->longText('address', 250)->nullable();
            $table->string('agent_number', 250)->nullable();
            $table->string('agent_date', 250)->nullable();
            $table->string('agent_attach', 250)->nullable();
            $table->longText('agent_txt', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('sittings_decisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('sitting_id')->nullable();
            $table->integer('decision_id')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->enum('status', array('active', 'notactive'))->default('active');
        });
        Schema::create('audiences', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('type', 250)->nullable();
            $table->integer('other_id')->nullable();
            $table->integer('other')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->enum('status', array('active', 'notactive'))->default('active');
        });
        Schema::create('sittings', function (Blueprint $table) {
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
        Schema::create('letters', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('type', 250)->nullable();
            $table->string('name', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('keys', 250)->nullable(); //key للنماذج
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->longText('link', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->longText('notes')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('usercontacts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('email', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('phone', 250)->nullable();
            $table->string('fax', 250)->nullable();
            $table->string('address_type', 250)->nullable();
            $table->string('post', 250)->nullable();
            $table->string('building', 250)->nullable();
            $table->string('add', 250)->nullable();
            $table->string('unit', 250)->nullable();
            $table->string('street', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('address_attach', 250)->nullable();
            $table->longText('notes')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('special', 250)->nullable();
            $table->string('certificate_attach', 250)->nullable();
            $table->string('Release_date', 250)->nullable();
            $table->string('country_id', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('other_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('action')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('laws', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('academic', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->string('link', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
        });
        Schema::create('nicknames', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->string('link', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
        });
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->string('link', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('smaples', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->integer('sitting_id')->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('keys', 250)->nullable(); //key للنماذج
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
        });
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('name');
            $table->enum('type', array('in', 'out'))->default('in'); //بنك داخلي او خارجي
            $table->timestamps();
            $table->softDeletes();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->default(uniqid());
        });
        Schema::create('decisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
                        $table->string('type', 250)->nullable();
            $table->string('date_tilte', 250)->nullable();
            $table->enum('decision_add_date', array('yes', 'no'))->default('no');
            $table->string('add_issue_extend_date')->nullable();
            $table->string('stop_issue')->nullable();
            $table->string('resume_issue')->nullable();
            $table->string('issue_start_date')->nullable();
            $table->string('link', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('decisiontypes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable();
            $table->integer('decision_id')->nullable();
            $table->enum('status', array('active', 'notactive'))->default('active');
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('decision_type', function (Blueprint $table) {
            $table->integer('decision_id')->unsigned();
            $table->integer('decisiontype_id')->unsigned();
            $table->foreign('decision_id')->references('id')->on('decisions')
                    ->onDelete('cascade');
            $table->foreign('decisiontype_id')->references('id')->on('decisiontypes')
                    ->onDelete('cascade');
        });
    }
}
