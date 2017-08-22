<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureUserTable extends Migration
{
	public function up()
	{
		Schema::create('feature_user', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('feature_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
        Schema::dropIfExists('feature_user');
	}
}
