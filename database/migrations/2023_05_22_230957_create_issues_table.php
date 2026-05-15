<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesTable extends Migration {

    public function down() {
        Schema::drop('issues'); //القضايا
        Schema::drop('rquests'); //طلبات القضايا
        Schema::drop('allfiles');    //مرفقات القضايا
        Schema::drop('agreements');    //اتفاقية تحكيم
        Schema::drop('reminders'); //التذكيرات
        Schema::drop('issues_users'); //التحويل بين الموظفين
    }

    public function up() {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('next_date', 250)->nullable();
            $table->string('next_time', 250)->nullable();
            $table->longText('notes')->nullable();
            $table->string('responsible', 250)->nullable();
            $table->string('status')->nullable();
            $table->integer('rquest_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->string('slug', 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issues_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rquest_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
            $table->enum('archive', array('0', '1'))->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rquests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('who_enter_issue')->nullable(); //صفه مقدم الطلب
            $table->string('name', 250)->nullable();
            $table->integer('type_id')->nullable();
            $table->string('request_number', 250)->nullable();
            $table->string('issue_number', 250)->nullable();
            $table->integer('impostors_numbers')->nullable();
            $table->integer('againsts_numbers')->nullable();
            $table->integer('arbitration_numbers')->nullable();
            $table->string('who_enter_rquest')->nullable(); //صفه مقدم الطلب
            $table->string('startdate', 250)->nullable();
            $table->string('enddate', 250)->nullable();
            $table->integer('isarchive')->nullable();

            $table->string('slug', 250)->default(uniqid());
            $table->string('status')->default('active');
            $table->integer('steps')->nullable();
            $table->integer('impostor')->nullable();
            $table->string('impostor_type')->nullable();
            $table->integer('against')->nullable();
            $table->integer('user_reponse')->nullable();

            $table->string('against_type')->nullable();
            $table->enum('is_jury', array('yes', 'no'))->nullable();
            $table->enum('jury_type', array('onlyone', 'multi'))->nullable();
            $table->enum('declared_arbitrator', array('onlyone', 'multi'))->nullable();
            $table->integer('arbitrators_numbers')->nullable();
            $table->integer('declared_or_appointed_arbitrator')->nullable();
            $table->string('is_there_letter')->nullable();
            $table->string('letter_type')->nullable();
            $table->integer('istheremain')->nullable(); //هل يوجد رئيس هيئه تحكيمپ
            //من قبل الأطراف
//من قبل محكمة الأستئناف
            $table->string('from_individual_type')->nullable();
            $table->string('from_individual_type_other')->nullable();

            $table->string('from_individual_file')->nullable();
            $table->string('from_individual_src')->nullable();
            $table->string('from_individual_number')->nullable();
            $table->string('from_individual_date')->nullable();
//هل يوجد خطاب افصاح
            $table->string('disclosure_letter_type')->nullable();
            $table->string('disclosure_letter_file')->nullable();
            $table->string('disclosure_letter_src')->nullable();
            $table->string('disclosure_letter_number')->nullable();
            $table->string('disclosure_letter_date')->nullable();
            $table->string('sk_id')->nullable();
            $table->string('sk_date')->nullable();

            //خيار التحكيم
            $table->enum('arbitration_option', array('condition', 'not_condition'))->default('condition');
            $table->string('contract_provider')->nullable(); //مقدم العقد
            $table->string('contract_attached')->nullable(); //مرفق العقد
            $table->string('contract_date')->nullable(); //تاريخ العقد
            $table->string('contract_number')->nullable(); //رقم العقد 
            $table->string('document_attached')->nullable(); //مرفق الوثيقة
            $table->string('document_date')->nullable(); //تاريخ الوثيقة
            $table->string('subject_number')->nullable(); //رقم الماده
            $table->string('subject_txt')->nullable(); //نص الماده

            $table->enum('operations', array('no', 'yes'))->default('no'); //0 rquest //1  issue
            $table->string('operation_attached')->nullable(); //مرفق 
            $table->string('operation_date')->nullable(); //تاريخ 
            $table->string('operation_number')->nullable(); //رقم 
            $table->longText('operation_txt')->nullable(); //نص 

            $table->enum('type', array('issue', 'rquest'))->default('rquest'); //0 rquest //1  issue

            $table->enum('src', array('iphone', 'android', 'website', 'admin'))->default('admin');
            $table->enum('archive', array('0', '1'))->default('0');
            $table->longText('notes')->nullable();
            $table->longText('note1')->nullable();
            $table->longText('note2')->nullable();
            $table->longText('note3')->nullable();
            $table->longText('note4')->nullable();
            $table->longText('note5')->nullable();
            $table->string('note1_check')->nullable();
            $table->string('note2_check')->nullable();
            $table->string('note3_check')->nullable();
            $table->string('note4_check')->nullable();
            $table->string('note5_check')->nullable();
            $table->longText('applicable_law')->nullable();
            $table->integer('law_id')->nullable();
            $table->integer('rquest_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->integer('type_id')->nullable();
            $table->string('request_number', 250)->nullable();
            $table->string('who_enter_issue')->nullable(); //صفه مقدم الطلب
            $table->integer('isarchive')->nullable();

            $table->integer('impostors_numbers')->nullable();
            $table->integer('againsts_numbers')->nullable();
            $table->integer('arbitration_numbers')->nullable();

            $table->string('issue_all_time', 250)->nullable(); //مده التحكيم
            $table->string('issue_start_date', 250)->nullable(); //بذايه التحكيم  
            $table->string('issue_end_date', 250)->nullable(); //انتهاء التحكيم  

            $table->integer('rquest_id')->nullable(); //مكرر
            $table->integer('issue_id')->nullable(); //مكرر
            $table->integer('user_id')->nullable();
            $table->string('slug', 250)->default(uniqid());
            $table->string('status')->default('active');
            $table->integer('steps')->nullable();
            $table->integer('impostor')->nullable();
            $table->string('impostor_type')->nullable();
            $table->integer('against')->nullable();
            $table->integer('user_reponse')->nullable();
            $table->string('is_there_letter')->nullable();
            $table->string('letter_type')->nullable();
            $table->string('against_type')->nullable();
            $table->enum('is_jury', array('yes', 'no'))->nullable();
            $table->enum('jury_type', array('onlyone', 'multi'))->nullable();
            $table->enum('declared_arbitrator', array('onlyone', 'multi'))->nullable();
            $table->integer('arbitrators_numbers')->nullable();
            $table->integer('declared_or_appointed_arbitrator')->nullable();
            //من قبل الأطراف
//من قبل محكمة الأستئناف
            $table->string('from_individual_type')->nullable();
            $table->string('from_individual_file')->nullable();
            $table->string('from_individual_src')->nullable();
            $table->string('from_individual_number')->nullable();
            $table->string('from_individual_date')->nullable();
//هل يوجد خطاب افصاح
            $table->string('disclosure_letter_type')->nullable();
            $table->string('disclosure_letter_file')->nullable();
            $table->string('disclosure_letter_src')->nullable();
            $table->string('disclosure_letter_number')->nullable();
            $table->string('disclosure_letter_date')->nullable();
            $table->string('sk_id')->nullable();
            $table->string('sk_date')->nullable();

            //خيار التحكيم
            $table->enum('arbitration_option', array('condition', 'not_condition'))->default('condition');
            $table->string('contract_provider')->nullable(); //مقدم العقد
            $table->string('contract_attached')->nullable(); //مرفق العقد
            $table->string('contract_date')->nullable(); //تاريخ العقد
            $table->string('contract_number')->nullable(); //رقم العقد 
            $table->string('document_attached')->nullable(); //مرفق الوثيقة
            $table->string('document_date')->nullable(); //تاريخ الوثيقة
            $table->string('subject_number')->nullable(); //رقم الماده
            $table->string('subject_txt')->nullable(); //نص الماده

            $table->enum('type', array('0', '1'))->default('0'); //0 request //1  issue
            $table->enum('src', array('iphone', 'android', 'website', 'admin'))->default('admin');
            $table->enum('archive', array('0', '1'))->default('0');
            $table->longText('notes')->nullable();
            $table->longText('note1')->nullable();
            $table->longText('note2')->nullable();
            $table->longText('note3')->nullable();
            $table->longText('note4')->nullable();
            $table->longText('note5')->nullable();
            $table->longText('applicable_law')->nullable();

            $table->string('note1_check')->nullable();
            $table->string('note2_check')->nullable();
            $table->string('note3_check')->nullable();
            $table->string('note4_check')->nullable();
            $table->string('note5_check')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('allfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arbitration_option')->nullable(); //خيار التحكيم
            $table->string('contract_provider')->nullable(); //مقدم العقد
            $table->string('contract_attach')->nullable(); //مرفق العقد
            $table->string('contract_date')->nullable(); //تاريخ العقد
            $table->string('document_attach')->nullable(); //مرفق الوثيقة
            $table->string('document_date')->nullable(); //تاريخ الوئيقة
            $table->string('contract_number')->nullable(); //رقم العقد
            $table->string('subject_number')->nullable(); //رقم المادة
            $table->longText('subject_txt')->nullable(); //نص المادة
            $table->integer('user_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('agreements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attach')->nullable(); //المرفق 
            $table->string('attach_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
