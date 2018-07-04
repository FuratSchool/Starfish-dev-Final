<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Therapy
 * @package App\Models
 */
class Therapy extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'description', 'short_description'];

    /**
     * @param $query
     * @param $keyword
     * @return mixed
     */
    public function  scopeSearchByKeyword($query, $keyword) {
        $query->where(function($query) use ($keyword){
            $query->where("name", "LIKE", "%$keyword%");
        });
        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks() {
        return $this->morphMany('therapies', 'subject');
    }
}
