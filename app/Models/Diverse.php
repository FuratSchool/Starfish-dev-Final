<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Diverse
 * @package App\Models
 */
class Diverse extends Model
{

    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'target'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks() {
        return $this->morphMany('diverses', 'subject');
    }
}
