<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @package App\Models
 */
class PasswordReset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'email', 'created_at'
    ];

    /**
     * Determines if model should use Laravel built-in timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set primary key for model
     *
     * @var string
     */
    protected $primaryKey = 'email'; // or null

    public $incrementing = false;

}
