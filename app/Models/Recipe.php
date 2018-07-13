<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'ingredients','preperation','factoid', 'primary_image', 'secondary_image'];

    /**
     * @param $query
     * @param $keyword
     * @return mixed
     */
    public function  scopeSearchByKeyword($query, $keyword) {
        $query->where("name", "LIKE", "%$keyword%");
        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany('App\Models\Image', 'recipes_images', 'recipe_id', 'image_id');
    }
}
