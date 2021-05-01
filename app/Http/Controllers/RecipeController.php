<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Resources\Recipe as RecipeResource;
use App\Models\Recipe;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class RecipeController extends BaseController
{

	public function index() {
		$idUser = Auth::id();
		$recipes = Recipe::where('users_id', $idUser)->get();

		return $this->sendResponse(RecipeResource::collection($recipes), 'Recipes retrieved successfully.');
	}

	public function store(Request $request) {

		$input = $request->all();

		$validator = Validator::make($input, [ 
			'title' => 'required',
			'description' => 'required',
			'cooking_instructions' => 'required',
			'difficulty_level' => 'required'
		]);

		if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		$input["users_id"] = Auth::id();
		$recipe = Recipe::create($input);
		return $this->sendResponse(new RecipeResource($recipe), 'Recipe created successfully.');
	}

	public function show($id) {
		$recipe = Recipe::find($id);
  
        if (is_null($recipe)) {
            return $this->sendError('Recipe not found.');
        }
   
        return $this->sendResponse(new RecipeResource($recipe), 'Recipe retrieved successfully.'); 
	}

	public function update(Request $request, $id) {

		$input = $request->all();
		$validator = Validator::make($input, [ 
			'title' => 'required',
			'description' => 'required',
			'cooking_instructions' => 'required',
			'difficulty_level' => 'required'
		]);
		if ($validator->fails()) { 
			return $this->sendError('Validation Error.', $validator->errors());
		}

		$recipe = Recipe::find($id);
		if(is_null($recipe)) {
			return $this->sendError('Recipe not found.');
		}
		$recipe->title = $input["title"];
		$recipe->description = $input["description"];
		$recipe->cooking_instructions = $input["cooking_instructions"];
		$recipe->difficulty_level = $input["difficulty_level"];
		$recipe->save();

		return $this->sendResponse(new RecipeResource($recipe), 'Recipe updated successfully.');
	}

	public function destroy($id) {
		$recipe = Recipe::find($id);
		$recipe->delete();
   
		return $this->sendResponse([], 'Recipe deleted successfully.');
	}

}