<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Specialist;
use App\Models\Complaint;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function searchDirector(Request $request) {
        if($request->list == 'complaints') {
            return redirect()->route('searchComplaint', ['q' => $request->q]);
        } else {
            return redirect()->route('searchSpecialism', ['q' => $request->q]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchSpecialism(Request $request){
        $this->validate($request, [
            'q' => array(
                'required',
                'regex:/(^[A-Za-z0-9 ]+$)+/'
            )
        ], [
            'q.required' => 'U moet een zoekterm invullen',
            'q.regex' => 'De zoekterm mag alleen letters, cijfers en hoofdletters bevatten'
        ]);
        $q = $request->q;
        $keyword = $q;
        $filter_zip = Input::get('filter_zip');
        $filter_city = Input::get('filter_city');
        $filter_lat = Input::get('geolat');
        $filter_lat = $filter_lat ?: 52.0893191;
        $filter_lng = Input::get('geolng');
        $filter_lng = $filter_lng ?: 5.1101691;
        $radius = Input::get('radius');
        $radius = $radius  ?: 150;
        $builder = Specialist::query();
        if($_SERVER['HTTP_REFERER'] != "http://starfish.dev/") {
            $specs = $builder->filterByLocation($keyword, $filter_lat, $filter_lng, $radius)->orderBy('is_anonymous', 'asc')->paginate(12);
        } else {
            $specs = $builder->SearchByKeyword($keyword)->orderBy('is_anonymous', 'asc')->paginate(12);
        }
        return view('search.specialismResult', compact('specs', 'filter_lat', 'filter_lng', 'keyword', 'filter_zip', 'filter_city', 'radius'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function searchComplaint(Request $request) {
        $this->validate($request, [
            'q' => array(
                'required',
                'regex:/(^[A-Za-z0-9 ]+$)+/'
            )
        ], [
            'q.required' => 'U moet een zoekterm invullen',
            'q.regex' => 'De zoekterm mag alleen letters, cijfers en hoofdletters bevatten'
        ]);
        $q = $request->q;
        if($q == 'alle' || $q == '%' || $q == "%25") {
            return redirect()->route('listComplaint');
        }
        $keyword = $q;
        $builder = Complaint::query();
        $complaints = $builder->SearchByKeyword($keyword)->orderBy('name', 'asc')->paginate(12);
        if($complaints->count() == 1 && $complaints->first()->name == $keyword) {
            return redirect()->route('complaint', ['name' => $complaints->first()->name]);
        } else {
            return view('search.complaintResult', compact('complaints','keyword'));
        }
    }
}
