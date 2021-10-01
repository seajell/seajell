<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFontsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fonts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('certificate_type_text_size', 8, 2);
            $table->string('certificate_type_text_color', 15)->default('#000000');
            $table->string('certificate_type_text_font', 30);
            $table->float('first_text_size', 8, 2);
            $table->string('first_text_color', 15)->default('#000000');
            $table->string('first_text_font', 30);
            $table->float('second_text_size', 8, 2);
            $table->string('second_text_color', 15)->default('#000000');
            $table->string('second_text_font', 30);
            $table->float('verifier_text_size', 8, 2);
            $table->string('verifier_text_color', 15)->default('#000000');
            $table->string('verifier_text_font', 30);
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
        Schema::dropIfExists('event_fonts');
    }
}
