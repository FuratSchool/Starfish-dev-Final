<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Message
 * @package App\Models
 */
class Message extends Model {

    use SoftDeletes;

    protected $fillable = ['subject', 'body', 'read', 'sender_id'];

    protected $dates = ['created_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users() {
        return $this->morphedByMany('App\Models\User', 'messageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups() {
        return $this->morphedByMany('App\Models\Group', 'messageable');
    }
}
