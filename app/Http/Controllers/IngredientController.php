<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Resources\Ingredient as IngredientResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class IngredientController extends BaseController
{

	public function index($id) {
		$idUser = Auth::id();
		$recipe = Recipe::find($id);
		$ingredients = $recipe->ingredients->where('users_id', $idUser)->all();

		return $this->sendResponse(IngredientResource::collection($ingredients), 'Ingredients retrieved successfully.');
	}

	public function store(Request $request, $id) {

		$input = $request->all();
		$recipe = Recipe::find($id);

		$validator = Validator::make($input, [ 
			'name' => 'required',
			'price' => 'required'
		]);

		if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		$input["users_id"] = Auth::id();
		$ingredient = Ingredient::create($input);
		$ingredient->recipes()->attach($recipe); 
		return $this->sendResponse(new IngredientResource($ingredient), 'Ingredient created successfully.');
	}

	public function show($id, $r_id) {
		$ingredient = Recipe::find($id)->ingredients->find($r_id);
  
        if (is_null($ingredient)) {
            return $this->sendError('Ingredient not found.');
        }
   
        return $this->sendResponse(new IngredientResource($ingredient), 'Ingredient retrieved successfully.'); 
	}

	public function update(Request $request, $id, $r_id) {

		$input = $request->all();
		$validator = Validator::make($input, [ 
			'name' => 'required',
			'price' => 'required',
		]);
		if ($validator->fails()) { 
			return $this->sendError('Validation Error.', $validator->errors());
		}

		$ingredient = Recipe::find($id)->ingredients->find($r_id);

		if (is_null($ingredient)) {
            return $this->sendError('Ingredient not found.');
        }
		$ingredient->name = $input["name"];
		$ingredient->price = $input["price"];
		$ingredient->save();

		return $this->sendResponse(new IngredientResource($ingredient), 'Ingredient updated successfully.');
	}

	public function destroy($id, $r_id) {
		$ingredient = Recipe::find($id)->ingredients->find($r_id);

		if (is_null($ingredient)) {
            return $this->sendError('Ingredient not found.');
        }
		$ingredient->delete();
   
		return $this->sendResponse([], 'Ingredient deleted successfully.');
	}

}