<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('subscription.table_names.subscriptions'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained(config('subscription.table_names.plans'))->onDelete('cascade');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->boolean('is_active')->default(true);
            $table->integer('duration');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('subscription.table_names.subscriptions'));
    }
};
