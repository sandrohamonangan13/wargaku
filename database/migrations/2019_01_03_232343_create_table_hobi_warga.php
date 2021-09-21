<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHobiWarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobi_warga', function (Blueprint $table) {
            // Create tabel hobi_warga
            $table->integer('id_warga')->unsigned()->index();
            $table->integer('id_hobi')->unsigned()->index();
            $table->timestamps();

            // Set PK
            $table->primary(['id_warga', 'id_hobi']);

            // Set FK hobi_warga --- warga
            $table->foreign('id_warga')
                  ->references('id')
                  ->on('warga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Set FK hobi_warga --- hobi
            $table->foreign('id_hobi')
                  ->references('id')
                  ->on('hobi')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobi_warga');
    }
}
