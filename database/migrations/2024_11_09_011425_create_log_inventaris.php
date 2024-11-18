<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_inventaris', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barang');
            $table->string('nama_peminjam', 255);
            $table->string('status', 255);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->date('tanggal_kembali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_inventaris');
    }
};
