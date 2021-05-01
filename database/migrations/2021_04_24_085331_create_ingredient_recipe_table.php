<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('ingredient_id')->unsigned()->nullable(false);
			$table->bigInteger('recipe_id')->unsigned()->nullable(false);
			$table->foreign('ingredient_id')->references('id')->on('ingredient')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('recipe_id')->references('id')->on('recipe')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_recipe');
    }
}
