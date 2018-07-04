<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Access
 * @package App\Models
 */
class Access extends Model
{
    protected $fillable = ['key', 'entry', 'minLOA'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
