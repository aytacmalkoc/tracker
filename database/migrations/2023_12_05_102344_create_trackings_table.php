<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('identifier')->unique();
            $table->ipAddress();
            $table->text('referrer_url')->nullable();
            $table->text('landing_url');
            $table->text('query')->nullable();
            $table->string('ad_group')->nullable();
            $table->string('ads_group')->nullable();
            $table->string('campaign')->nullable();
            $table->string('clid')->nullable();
            $table->string('continent')->nullable();
            $table->string('continent_code')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('region_name')->nullable();
            $table->string('district')->nullable();
            $table->string('zip')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();
            $table->string('language')->nullable();
            $table->json('languages')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('version')->nullable();
            $table->string('device')->nullable();
            $table->string('os')->nullable();
            $table->timestamp('conversion_date')->nullable();
            $table->boolean('conversion')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
