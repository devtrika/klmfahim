<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category', 30)->default('setup')->after('id');
            $table->string('icon', 60)->nullable()->after('category');
            $table->string('ar_short', 255)->nullable()->after('en_title');
            $table->string('en_short', 255)->nullable()->after('ar_short');
            $table->unsignedInteger('sort')->default(0)->after('image');
            $table->string('image')->nullable()->change();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('ar_title');
            $table->string('en_title');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('calculator_items', function (Blueprint $table) {
            $table->id();
            $table->string('group', 30);
            $table->string('ar_title');
            $table->string('en_title');
            $table->string('ar_hint')->nullable();
            $table->string('en_hint')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('cost_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 40);
            $table->string('email')->nullable();
            $table->json('selections');
            $table->unsignedInteger('estimate');
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });

        Schema::table('site', function (Blueprint $table) {
            $table->string('ar_slogan')->nullable()->after('en_title');
            $table->string('en_slogan')->nullable()->after('ar_slogan');
            $table->string('currency', 10)->default('AED')->after('en_slogan');
        });
    }

    public function down(): void
    {
        Schema::table('site', function (Blueprint $table) {
            $table->dropColumn(['ar_slogan', 'en_slogan', 'currency']);
        });
        Schema::dropIfExists('cost_requests');
        Schema::dropIfExists('calculator_items');
        Schema::dropIfExists('features');
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['category', 'icon', 'ar_short', 'en_short', 'sort']);
        });
    }
};
