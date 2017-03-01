<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('link_id');
            $table->string('link_name')->default('')->nullable()->comment('links name');
            $table->string('link_description')->default('')->nullable()->comment('links description');
            $table->string('link_url')->default('')->nullable()->comment('links url');
            $table->integer('link_order')->default(0)->nullable()->comment('links sort');
        });
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
}
