<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
    use softDeletes;

    protected $fillable = ['title', 'description', 'type', 'status',   'assigner_id','deadline'];
    protected $dates = ['deadline', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assigner() {
        return $this->belongsTo('App\Models\User', 'assigner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users() {
        return $this->morphedByMany('App\Models\User', 'taskable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups() {
        return $this->morphedByMany('App\Models\Group', 'taskable');
    }
}
