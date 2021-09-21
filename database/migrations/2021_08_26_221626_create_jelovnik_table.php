<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJelovnikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jelovnik', function (Blueprint $table) {
            $table->id();
            $table->string('ime',255)->default('');
            $table->text('opis')->default('');
            $table->decimal('cena',8,2,true)->default(0.0);
            $table->string('slika',255)->default('');
            $table->foreignId('potkategorija_id')
                    ->constrained('potkategorije','id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('jelovnik');
    }
}
