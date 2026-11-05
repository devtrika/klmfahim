<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site', function (Blueprint $t) {
            $t->string('voice')->nullable();
            $t->string('voice_title')->nullable();
        });

        // The track already on the site becomes the current setting.
        DB::table('site')->update(['voice' => 'brand/voice.mp3', 'voice_title' => 'Call Fahim Official Song']);
    }

    public function down(): void
    {
        Schema::table('site', function (Blueprint $t) {
            $t->dropColumn(['voice', 'voice_title']);
        });
    }
};
