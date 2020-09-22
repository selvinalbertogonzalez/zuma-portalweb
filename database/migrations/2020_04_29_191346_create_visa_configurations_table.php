<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaConfigurationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('visa_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('payments');
            $table->boolean('open_tip');
            $table->boolean('closed_tip');
            $table->boolean('automatic_closure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('visa_configurations');
    }
}
