<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Recipe extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table = "recipe";

    protected $fillable = [
        'title',
		'description',
		'cooking_instructions',
		'difficulty_level',
		'users_id'
    ];

	public function ingredients()
	{
    	return $this->belongsToMany(Ingredient::class);
	}
}