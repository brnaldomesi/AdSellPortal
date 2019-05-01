<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->string('server')->index('sync_server_index');
            $table->string('remote_id')->nullable();
            $table->boolean('add')->default(0)->index('sync_add_index');
            $table->boolean('edit')->default(0)->index('sync_edit_index');
            $table->boolean('delete')->default(0)->index('sync_delete_index');
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
        Schema::dropIfExists('sync');
    }
}
