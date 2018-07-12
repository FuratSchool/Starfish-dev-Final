<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Complaint
 * @package App\Models
 */
class Complaint extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description','short_description', 'complaint_image'];

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks() {
        return $this->morphMany('complaints', 'subject');
    }

}
