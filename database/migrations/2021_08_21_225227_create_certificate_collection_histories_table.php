<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateCollectionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_collection_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade'); // The user that requested the collection
            $table->dateTime('requested_on');
            $table->dateTime('next_available_download');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade'); // If the collection requested is for a user
            $table->foreignId('event_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade'); // If the collection requested is for an event
            $table->bigInteger('certificates_total');
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
        Schema::dropIfExists('certificate_collection_histories');
    }
}
