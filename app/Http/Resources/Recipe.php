<?php

namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;

class Recipe extends JsonResource
{

	public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
			'cooking_instructions' => $this->cooking_instructions,
            'difficulty_level' => $this->difficulty_level,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}