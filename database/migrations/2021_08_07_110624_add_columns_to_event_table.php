<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('verifier_signature')->after('organiser_logo');
            $table->string('verifier_name')->after('verifier_signature');
            $table->string('verifier_position')->after('verifier_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function (Blueprint $table) {
            $table->dropColumn('verifier_signature');
            $table->dropColumn('verifier_name');
            $table->dropColumn('verifier_position');
        });
    }
}
