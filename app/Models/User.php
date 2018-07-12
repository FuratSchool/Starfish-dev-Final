<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','password', 'first_name', 'adverb', 'sur_name', 'email', 'is_active', 'is_admin', 'notice'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The date attributes that are usable by Carbon
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'last_login', 'deleted_at'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function access() {
        return $this->belongsToMany('App\Models\Access', 'users_accesses');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany('App\Models\Group', 'groups_users');
    }

    /**
     *
     */
    public function attachDefaults(){
        $LOA = $this->is_admin;
        $defaults = ['Access' => 'access', 'Group' => 'groups'];
        foreach ($defaults as $model => $function) {
            $path = app_path("\\Http\\Controllers\\Admin\\defaults\\{$model}.csv");
            $lines = explode("\n", file_get_contents($path));
            $headers = str_getcsv(array_shift($lines));
            $data = array();
            foreach ($lines as $line) {
                $row = array();
                foreach (str_getcsv($line) as $key => $field)
                    $row[$headers[$key]] = $field;
                $row = array_filter($row);
                $data[] = $row;
            }
            foreach ($data as $item) {
                if($LOA >= $item['minLOA']) {
                    $this->$function()->attach($item['id']);
                }
            }
        }

        return true;
    }

    /**
     * @param $key
     * @param null $userid
     * @return bool
     *
     */
    public function hasAccess($route, $id=null) {
        if($id) {
            $user =  User::find($id);
            $user->load('access');
            foreach ($user->access as $access) {
                if($route == $access->route) {
                    return true;
                }
            }
        } else {
            $uaccesses = \Session::get('user.access');
            foreach ($uaccesses as $uaccess) {
                if ($uaccess == $route) {
                    return true;
                }
            }
        }
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function inGroup(Group $group) {
       $id = $group->id;
       $ugroups = \Session::get('user.groups');
       foreach ($ugroups as $ugroup) {
           if($ugroup == $id) {
               return true;
           }
       }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent() {
        return $this->hasMany('App\Models\Message', 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assigned() {
        return $this->hasMany('App\Models\Task', 'assigner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function messages() {
        return $this->morphToMany('App\Models\Message', 'messageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tasks() {
        return $this->morphToMany('App\Models\Task', 'taskable');
    }
}
