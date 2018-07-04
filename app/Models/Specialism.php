<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Specialism
 * @package App\Models
 */
class Specialism extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'description', 'short_description'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specialists() {
        return $this->belongsToMany('App\Models\Specialist', 'specialists_specialisms', 'specialism_id', 'specialist_id')->withPivot('prio')->orderBy('prio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks() {
        return $this->morphMany('specialisms', 'subject');
    }
}
