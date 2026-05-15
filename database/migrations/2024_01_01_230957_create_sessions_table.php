<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSessionsTable extends Migration {

    public function down() {
        Schema::dropIfExists('issue_session');
        Schema::dropIfExists('session_money');
        Schema::dropIfExists('money_pay');
        Schema::dropIfExists('session_attendace');
        Schema::dropIfExists('session_decisions');
    }

    public function up() {
        Schema::create('session_decisions', function (Blueprint $table) {
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
        Schema::create('session_attendace', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('session_id')->nullable();
            $table->string('issue_id')->nullable();
            $table->string('attendance', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->string('type', 250)->default(uniqid());
            $table->string('status', 250)->nullable();
            $table->string('is_session', 250)->nullable(); // 
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('issue_session', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('sitting_id', 250)->nullable();
            $table->string('sitting_type', 250)->nullable(); //مقر انعقاد الجلسة
            $table->string('sitting_link', 250)->nullable(); //رابط الجلسه
            $table->string('sitting_location', 250)->nullable(); //عنوان الجلسه
            $table->string('sitting_date', 250)->nullable(); // تاريخ الجلسة
            $table->string('sitting_starttime', 250)->nullable(); // وقت بداية الجلسه
            $table->string('sitting_endtime', 250)->nullable(); // وقت نهاية الجلسة
            $table->longText('sitting_report', 250)->nullable(); // محضر الجلسة
            $table->longText('sitting_setting', 250)->nullable(); // االظبط الجلسة
            $table->string('attach', 250)->nullable(); // ارفاق الخطاب
            $table->string('status', 250)->nullable();
            $table->string('attendance', 250)->nullable(); // 
            $table->string('user_id', 250)->nullable(); // 
            $table->string('issue_id', 250)->nullable();
            $table->string('signature', 250)->nullable()->default('notsigned'); // 
            $table->string('is_session', 250)->nullable(); // 
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('session_money', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 250)->nullable(); //رقم المذكره
            $table->string('percentage', 250)->nullable();
            $table->string('money', 250)->nullable(); // المذكره
            $table->string('select_date', 250)->nullable(); // المذكر
            $table->string('due_date', 250)->nullable(); // المذكر
            $table->string('issue_id', 250)->nullable();
            $table->string('session_id', 250)->nullable();
            $table->string('user_id', 250)->nullable();
            $table->string('user_type', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('type', 250)->nullable(); //main or plus اصلي او اضافي
            $table->string('slug', 250)->default(uniqid());
            $table->longText('describtion')->nullable();
            $table->string('is_session', 250)->nullable(); // 
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('money_pay', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('trans_number', 250)->nullable(); //رقم الحواله
            $table->string('trans_from', 250)->nullable(); //صاحب الحوالة *
            $table->string('trans_to', 250)->nullable(); //المستفيد الحوالة *
            $table->string('trans_money', 250)->nullable(); //مبلغ الحوالة
            $table->string('trans_type', 250)->nullable(); //نوع الحوالة
            $table->string('bank_id', 250)->nullable(); //اسم البنك 
            $table->string('account_own', 250)->nullable(); //صاحب الحساب
            $table->string('trans_date', 250)->nullable(); //تاريخ الحواله
            $table->string('take_date', 250)->nullable(); //تاريخ الاستلام
            $table->string('attach', 250)->nullable(); //صورة الحوالة
            $table->string('chick_date', 250)->nullable(); //تاريخ الشيك
            $table->string('name', 250)->nullable(); //اسم مقدم الشيك
            $table->string('id_attach', 250)->nullable(); //صورة الهوية
            $table->string('session_money_id', 250)->nullable();
            $table->string('issue_id', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('slug', 250)->nullable();
            $table->longText('notes')->nullable();
            $table->string('session_id', 250)->nullable();
            $table->string('money_type', 250)->nullable();
//اضافيه
            //اصليه
            //اخري
            $table->string('type', 250)->nullable();
            //حواله  trans
            //ايصال document
            //chick شيك
            //another

            $table->enum('archive', array('0', '1'))->default('0');
        });
    }
}
