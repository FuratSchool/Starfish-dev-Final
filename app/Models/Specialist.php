<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Specialist
 * @package App\Models
 */
class Specialist extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'adverb', 'sur_name', 'gender', 'occupation', 'map_lat', 'map_lng', 'address', 'city', 'postal_code', 'is_anonymous', 'url_name', 'profile_image', 'company', 'story', 'mission', 'phone_number', 'mobile_phone', 'url', 'email', 'region', 'country'];
    /**
     * @var array
     */
    protected $visible = ['id', 'name', 'adverb', 'sur_name', 'gender', 'profile_image','address', 'city', 'postal_code', 'company', ' story', ' mission'   ,'occupation', 'url_name', 'map_lng', 'map_lat', 'is_anonymous', 'region', 'country'];

    /**
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany('App\Models\Category' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specialisms() {
        return $this->belongsToMany('App\Models\Specialism', 'specialists_specialisms', 'specialist_id', 'specialism_id')->withPivot('prio')->orderBy('prio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images() {
        return $this->belongsToMany('App\Models\Image', 'specialists_images', 'specialist_id', 'image_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public  function diverse() {
        return $this->belongsToMany('App\Models\Diverse', 'specialists_diverses', 'specialist_id', 'diverse_id');
    }

    /**
     * @param $query
     * @param $keyword
     * @return mixed
     */
    public function  scopeSearchByKeyword($query, $keyword) {
        $query->whereHas('specialisms', function($q) use ($keyword) { $q->where('name', "%$keyword%"); });
        return $query;
    }

    /**
     * @param $query
     * @param $keyword
     * @param $lat
     * @param $lng
     * @param $radius
     * @return mixed
     */
    public function scopeFilterByLocation($query, $keyword,$lat, $lng, $radius) {
        $lat = (double) $lat;
        $lng = (double) $lng;
        $kmDeg = 2 * M_PI * 6371 / 360;
        $lngMargin = $radius / abs(cos(deg2rad($lat)) * $kmDeg);
        $limLng1 = $lng - $lngMargin;
        $limLng2 = $lng + $lngMargin;
        $latMargin = $radius / $kmDeg;
        $limLat1 = $lat - $latMargin;
        $limLat2 = $lat + $latMargin;
        $query->whereHas('specialisms', function($q) use ($keyword) { $q->whereLike('name', $keyword); })->
        whereBetween('map_lat', [$limLat1, $limLat2])->
        whereBetween('map_lng', [$limLng1, $limLng2]);
        $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(specialists.map_lat)) * cos(radians(specialists.map_lng) - radians($lng)) + sin(radians($lat)) * sin(radians(specialists.map_lat))))";
        $query->selectRaw("*, {$haversine} AS distance")
            ->orderBy('distance', 'asc')
            ->whereRaw("{$haversine} < ?", [$radius]);

        $query->orderBy('distance', 'ASC');
        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks() {
        return $this->morphMany('specialists', 'subject');
    }
}
