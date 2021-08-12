<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstLogoColumnToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('institute_name');
            $table->dropColumn('institute_logo');
            $table->dropColumn('organiser_logo');
            $table->dropColumn('verifier_signature');
            $table->dropColumn('verifier_name');
            $table->dropColumn('verifier_position');
            $table->string('logo_first')->after('visibility')->nullable();
            $table->string('logo_second')->after('logo_first')->nullable();
            $table->string('logo_third')->after('logo_second')->nullable();
            $table->string('signature_first')->after('logo_third')->nullable();
            $table->string('signature_second')->after('signature_first')->nullable();
            $table->string('signature_third')->after('signature_second')->nullable();
            $table->string('signature_first_name')->after('signature_third')->nullable();
            $table->string('signature_second_name')->after('signature_first_name')->nullable();
            $table->string('signature_third_name')->after('signature_second_name')->nullable();
            $table->string('signature_first_position')->after('signature_third_name')->nullable();
            $table->string('signature_second_position')->after('signature_first_position')->nullable();
            $table->string('signature_third_position')->after('signature_second_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('logo_first');
            $table->dropColumn('logo_second');
            $table->dropColumn('logo_second');
            $table->dropColumn('signature_first');
            $table->dropColumn('signature_second');
            $table->dropColumn('signature_second');
        });
    }
}
