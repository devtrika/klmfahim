<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMyissueTable extends Migration {

    public function down() {
        Schema::dropIfExists('issue_attendance');
        Schema::dropIfExists('issue_notes');
        Schema::dropIfExists('issue_reports');
        Schema::dropIfExists('issue_reports_users');
    }

    public function up() {

        Schema::create('issue_reports_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('report_id', 250)->nullable(); //رقم المذكره
            $table->string('user_id', 250)->nullable();
            $table->string('type', 250)->nullable(); // المذكره
            $table->string('name', 250)->nullable(); // المذكر
            $table->string('issue_id', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('issue_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('report_number', 250)->nullable(); //رقم المذكره
            $table->string('report_type', 250)->nullable();
            $table->string('report_time', 250)->nullable(); // المذكره
            $table->string('report_date', 250)->nullable(); // المذكر
            $table->longText('report_describtion')->nullable();
            $table->longText('report_time_describtion')->nullable();
            $table->string('issue_id', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
        });
        Schema::create('issue_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('note_number', 250)->nullable(); //رقم المذكره
            $table->string('note_type', 250)->nullable();
            $table->string('note_date', 250)->nullable(); // المذكره
            $table->string('note_time', 250)->nullable(); // المذكره
            $table->string('note_pages_number', 250)->nullable(); // عدد صفحات المذكرة
            $table->string('note_report', 250)->nullable(); // مقدم المذكره
            $table->string('note_attach_number', 250)->nullable(); // عدد المرفقات
            $table->string('note_attach_pages_number', 250)->nullable(); // عدد صفحات المرفقات
            $table->longText('note_describtion')->nullable();
            $table->string('issue_id', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('number', 250)->nullable();
            $table->string('letter_id', 250)->nullable(); // 
            $table->string('letter_date', 250)->nullable(); //تاريخ
            $table->string('letter_time', 250)->nullable(); //وقت الخطاب
            $table->string('type', 250)->nullable();
            $table->string('name', 250)->nullable();
            $table->longText('describtion')->nullable();
            $table->string('image', 250)->nullable();
            $table->enum('status', array('signed', 'notsigned'))->default('notsigned');
            $table->string('is_letter', 250)->nullable();
            $table->string('session_id', 250)->nullable();
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
          //  $table->string('status', 250)->nullable();
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
        });

        Schema::create('issue_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('status', 250)->nullable();
            $table->string('attendance', 250)->nullable(); // 
            $table->string('issue_id', 250)->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('is_session', 250)->nullable(); // 
        });
    }
}
