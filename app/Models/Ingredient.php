<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Ingredient extends Model
{
    use HasFactory;

	protected $table = "ingredient";
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'price',
		'users_id'
    ];

	public $timestamps = false;

	public function recipes()
	{
    	return $this->belongsToMany(Recipe::class);
	}
}