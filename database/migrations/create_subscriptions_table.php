<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Retrieve the user model class from config
        $userModel = config('subscription.user_model');
        // Instantiate the model to access its properties
        $userInstance = new $userModel;
        // Get the table name and foreign key dynamically
        $userTable = $userInstance->getTable();
        $userForeignKey = $userInstance->getForeignKey();

        Schema::create(config('subscription.table_names.subscriptions'), function (Blueprint $table) use ($userTable, $userForeignKey) {
            $table->id();
            // Use the dynamically generated foreign key and table name
            $table->foreignId($userForeignKey)
                ->constrained($userTable)
                ->onDelete('cascade');
            $table->foreignId('plan_id')
                ->constrained(config('subscription.table_names.plans'))
                ->onDelete('cascade');
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
