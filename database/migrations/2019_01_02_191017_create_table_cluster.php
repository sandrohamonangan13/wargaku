<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCluster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cluster', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_cluster', 20);
            $table->timestamps();
        });

        // Set FK di kolom is_cluster di tabel siswa.
        Schema::table('warga', function (Blueprint $table) {
            $table->foreign('id_cluster')
                  ->references('id')
                  ->on('cluster')
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
        // Drop FK di kolom id_cluster di tabel siswa
        Schema::table('warga', function (Blueprint $table) {
            $table->dropForeign('warga_id_cluster_foreign');
        });

        Schema::dropIfExists('cluster');
    }
}
