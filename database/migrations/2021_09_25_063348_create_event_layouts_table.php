<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('logo_first_input_width', 50)->nullable();
            $table->string('logo_first_input_height', 50)->nullable();
            $table->string('logo_first_input_translate', 50)->nullable();
            $table->string('logo_second_input_width', 50)->nullable();
            $table->string('logo_second_input_height', 50)->nullable();
            $table->string('logo_second_input_translate', 50)->nullable();
            $table->string('logo_third_input_width', 50)->nullable();
            $table->string('logo_third_input_height', 50)->nullable();
            $table->string('logo_third_input_translate', 50)->nullable();
            $table->string('details_input_width', 50)->nullable();
            $table->string('details_input_height', 50)->nullable();
            $table->string('details_input_translate', 50)->nullable();
            $table->string('signature_first_input_width', 50)->nullable();
            $table->string('signature_first_input_height', 50)->nullable();
            $table->string('signature_first_input_translate', 50)->nullable();
            $table->string('signature_second_input_width', 50)->nullable();
            $table->string('signature_second_input_height', 50)->nullable();
            $table->string('signature_second_input_translate', 50)->nullable();
            $table->string('signature_third_input_width', 50)->nullable();
            $table->string('signature_third_input_height', 50)->nullable();
            $table->string('signature_third_input_translate', 50)->nullable();
            $table->string('qr_code_input_translate', 50)->nullable();
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
        Schema::dropIfExists('event_layouts');
    }
}
