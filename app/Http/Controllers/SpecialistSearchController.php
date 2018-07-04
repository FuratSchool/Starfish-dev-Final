<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class SpecialistSearchController
 * @package App\Http\Controllers
 */
class SpecialistSearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        $builder = Specialist::query();

        // We first order on anonymity, so that anonymity is more imporant than distance
        $builder->orderBy('is_anonymous', 'ASC');

        // Normal search
        if(!empty($request->input('search'))){
            $search = $request->input('search');
            $search = '%' . $search . '%'; // Add %'s for searching
            $builder->where(function ($query) use($search){
                $query->orWhere('name', 'LIKE', $search);
                $query->orWhere('occupation', 'LIKE', $search);
                $query->orWhere('specialization', 'LIKE', $search);
                $query->orWhere('story', 'LIKE', $search);
            });
        }

        // Haversin
        $radius = @intval($request->input('radius', -1));
        $radius = $radius < 150 ? $radius : 150;
        if($radius > 0){
            $radius /= 2;
            $lat = $request->request->get('mapLat', 0.0);
            $lng = $request->request->get('mapLng', 0.0);

            $builder->filterByDistance($lat, $lng, $radius);
        }


        // Ordering
        $builder->orderBy('name', 'ASC');

        $specialists = $builder->paginate(20, ['*'], 'page', 0);

        return response()->json($specialists);
    }
}
