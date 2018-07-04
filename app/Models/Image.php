<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @package App\Models
 */
class Image extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['path', 'caption'];
}
