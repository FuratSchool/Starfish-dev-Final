<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description','short_description', 'article_image'];

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
        return $this->belongsToMany('App\Models\Image', 'articles_images', 'article_id', 'image_id');
    }
}
