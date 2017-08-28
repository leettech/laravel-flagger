<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlaggablesTable extends Migration
{
	public function up()
	{
		Schema::create('flaggables', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('feature_id')->unsigned();
            $table->integer('flaggable_id')->unsigned();
            $table->string('flaggable_type');
			$table->timestamps();
		});
	}

	public function down()
	{
        Schema::dropIfExists('flaggables');
	}
}
