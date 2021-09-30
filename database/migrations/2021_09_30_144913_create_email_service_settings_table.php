<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailServiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_service_settings', function (Blueprint $table) {
            $table->id();
            $table->string('service_status', 5);
            $table->string('service_host');
            $table->string('service_port', 5)->default('587');
            $table->string('account_username');
            $table->string('account_password');
            $table->string('support_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_service_settings');
    }
}
