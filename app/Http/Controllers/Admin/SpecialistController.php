<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\newSpecialistEntry;
use App\Http\Requests\updateSpecialistEntry;
use App\Models\Diverse;
use App\Models\Specialism;
use App\Models\Specialist;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;
use function PHPSTORM_META\type;
use Spatie\Activitylog\Models\Activity;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageC;

/**
 * Class SpecialistController
 * @package App\Http\Controllers\Admin
 */
class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fdir = [
            'id' =>  'asc',
            'name' => 'asc',
            'occupation' => 'asc',
            'city' => 'asc',
            'is_anonymous' => 'asc',
            'email' => 'asc',
            'updated_at' => 'asc',
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if(isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $specialists = Specialist::query();
        $specialists = $specialists->select('id', 'name', 'occupation', 'city', 'is_anonymous', 'profile_image', 'email', 'updated_at', 'deleted_at');
        if(isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q =  $_GET['q'];
            $specialists->where($filter_type, "LIKE", "%$q%");
        }
        $specialists = $specialists->orderBy($column, $dir)->paginate('10', ['*'], 'specialists');
        $dir =  $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key=>$value) {
            if($key == $column) {
                $fdir[ $key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        $deletedSpecialists = Specialist::onlyTrashed()->select('id', 'name', 'address', 'city', 'postal_code AS zip', 'deleted_at')->orderBy('deleted_at', 'desc')->paginate('10',['*'], 'deletedSpecialists');;
        return view('admin.specialists.index', compact('specialists', 'deletedSpecialists' , 'fdir', 'column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialisms = Specialism::all(['name', 'description']);
        return view('admin.specialists.create', compact('specialisms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param newSpecialistEntry $request
     * @return \Illuminate\Http\Response
     */
    public function store(newSpecialistEntry $request)
    {
        //BLIJF VAN DE REGEL HIERONDER AF
        ob_flush(); //Dit leegt de output buffer want op de een of andere manier wordt er wat gebufferd tijdens de validate
        //BLIJF VAN DE REGEL HIERBOVEN AF


        $story = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $request->story);
        $story = preg_replace('/on[.]+=\'|\"[.]+\'|\"/is', "", $story);
        /** @var array $input_data */
        $pf_path =  $request->has($request->profile_image_filename) ? 'public/images/avatars/specialists/'.$request->profile_image_filename : 'public/images/anonymous.png';
        $input_data = [
            'name' => $request->name,
            'adverb' => $request->adverb,
            'sur_name' => $request->sur_name,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'map_lat' => $request->lat,
            'map_lng' => $request->lng,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number,
            'mobile_phone' => $request->mobile_phone,
            'is_anonymous' => $request->is_anonymous,
            'url_name' => $request->url_name,
            'profile_image' => $pf_path,
            'company' => $request->company,
            'story' => $story,
            'mission' => $request->mission,
            'url' => $request->url,
            'email' => $request->email,
            'region' => $request->region,
            'country' => $request->country
        ];
        $spec = Specialist::create($input_data);

        foreach ($request->images as $image => $imagedata) {
            if($request->hasFile('images.'.$image.'.file')) {
                $file = $request->file('images.'.$image.'.file');
                $filename = str_replace(' ', '_', $input_data['name']). "_" . $image;
                $ext = $file->extension();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs('/images/avatars/specialists/images', $full_filename);
                $caption = $imagedata['caption'];
                $im = new ImageC();
                $im->path = $path;
                $im->caption = $caption;
                if($im->save()) {
                    activity('img-log')
                        ->causedBy(auth()->user())
                        ->performedOn($im)
                        ->withProperties(['action' => 'created'])
                        ->log('Afbeelding:  '.$im->id.' aangemaakt door:'.auth()->user()->username);
                }
                $im = ImageC::where('path', $path)->first();
                $spec->images()->attach($im);
                activity('spec-log')
                    ->causedBy(auth()->user())
                    ->performedOn($spec)
                    ->withProperties(['action' => 'img_attached'])
                    ->log('Afbeelding:  '.$im->id.' gekoppeld aan:'.$spec->name.'door:'.auth()->user()->username);
            }
        }

        foreach ($request->diverses as $diverse => $divdata) {
            if($request->hasFile('diverses.'.$diverse.'.target')) {
                $file = $request->file('diverses.'.$diverse.'.target');
                $filename = str_replace(' ', '_', $input_data['name']). "_" . $diverse;
                $ext = $file->extension();
                $type = $file->getMimeType();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs("/diverses", $full_filename);
                $name = $divdata['name'];
                $div = new Diverse();
                $div->name =  $name;
                $div->type = $type;
                $div->target = $path;
                if($div->save()) {
                    activity('div-log')
                        ->causedBy(auth()->user())
                        ->performedOn($div)
                        ->withProperties(['action' => 'created'])
                        ->log('Gebruiker:  '.$div->name.' aangemaakt door:'.auth()->user()->username);
                }
                $div = Diverse::where("target", $path)->first();
                $spec->diverse()->attach($div->id);
                activity('spec-log')
                    ->causedBy(auth()->user())
                    ->performedOn($spec)
                    ->withProperties(['action' => 'div_attached'])
                    ->log('DIverse:  '.$div->name.' gekoppeld aan:'.$spec->name.'door:'.auth()->user()->username);
            }
        }
        foreach ($request->specialisms as $specialism => $specdata) {
            if($specdata["name"] != null){
                $speci = Specialism::where('name', $specdata)->first();
                $spec->specialisms()->attach($speci, ['prio' => $specialism]);
                activity('spec-log')
                    ->causedBy(auth()->user())
                    ->performedOn($spec)
                    ->withProperties(['action' => 'specialism_attached'])
                    ->log('Werrkgebied:  '. $speci['name'].', met prioriteit:'.$specialism.', gekoppeld aan:'.$spec->name.'door:'.auth()->user()->username);
            }
        }
        activity('spec-log')
            ->causedBy(auth()->user())
            ->performedOn($spec)
            ->withProperties(['action' => 'created'])
            ->log('Specialist:  '.$spec->name.' aangemaakt door:'.auth()->user()->username);
        \Session::flash("success", "Specialist: ".$spec->name." succesvol aangemaakt");
        return redirect()->route('admin.specialists.show', $spec->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Specialist $specialist
     *
     * @return void
     */
    public function show(Specialist $specialist)
    {
        $specialist->load(["specialisms", "images", "diverse"]);
        return view("admin.specialists.show", compact('specialist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Specialist $specialist
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialist $specialist)
    {
        $specialist->load(["specialisms", "images", "diverse"]);
        $specialisms = Specialism::all(['name', 'description']);
        return view("admin.specialists.edit", compact('specialist', 'specialisms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Specialist                $specialist
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateSpecialistEntry $request, Specialist $specialist)
    {
            //BLIJF VAN DE REGEL HIERONDER AF
            ob_flush(); //Dit leegt de output buffer want op de een of andere manier wordt er wat gebufferd tijdens de validate
            //BLIJF VAN DE REGEL HIERBOVEN AF


            $story = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $request->story);
            $story = preg_replace('/on[.]+=\'|\"[.]+\'|\"/is', "", $story);
            /** @var array $input_data */
                $specialist->name = $request->name;
                $specialist->occupation = $request->occupation;
                $specialist->map_lat = $request->lat;
                $specialist->map_lng = $request->lng;
                $specialist->address = $request->address;
                $specialist->city = $request->city;
                $specialist->postal_code = $request->postal_code;
                $specialist->phone_number = $request->phone_number;
                $specialist->mobile_phone = $request->mobile_phone;
                $specialist->is_anonymous = $request->is_anonymous;
                $specialist->url_name = $request->url_name;
                if($request->profile_image_filename) {
                    $specialist->profile_image = 'public/images/avatars/specialists/' . $request->profile_image_filename;
                }
                $specialist->company = $request->company;
                $specialist->story = $story;
                $specialist->mission = $request->mission;
                $specialist->url = $request->url;
                $specialist->email = $request->email;
                $specialist->region = $request->region;
                $specialist->country = $request->country;
                $specialist->save();

            $specialist = Specialist::where("url_name", $request->url_name)->firstOrFail();
            $specialist->images()->detach();
            foreach ($request->images as $image => $imagedata) {
                if($request->hasFile('images.'.$image.'.file')) {
                    $file = $request->file('images.'.$image.'.file');
                    $filename = str_replace(' ', '_', $input_data['name']). "_" . $image;
                    $ext = $file->extension();
                    $full_filename = $filename . "." . $ext;
                    $path = $file->storeAs('/images/avatars/specialists/images', $full_filename);
                    $caption = $imagedata['caption'];
                    $im = new ImageC();
                    $im->path = $path;
                    $im->caption = $caption;
                    if($im->save()) {
                        activity('img-log')
                            ->causedBy(auth()->user())
                            ->performedOn($im)
                            ->withProperties(['action' => 'created'])
                            ->log('Afbeelding:  '.$im->id.' aangemaakt door:'.auth()->user()->username);
                    }
                    $im = ImageC::where('path', $path)->first();
                    $specialist->images()->attach($im);
                    activity('spec-log')
                        ->causedBy(auth()->user())
                        ->performedOn($specialist)
                        ->withProperties(['action' => 'img_attached'])
                        ->log('Afbeelding:  '.$im->id.' gekoppeld aan:'.$specialist->name.'door:'.auth()->user()->username);
                }
            }

            $specialist->diverse()->detach();
            foreach ($request->diverses as $diverse => $divdata) {
                if($request->hasFile('diverses.'.$diverse.'.target')) {
                    $file = $request->file('diverses.'.$diverse.'.target');
                    $filename = str_replace(' ', '_', $input_data['name']). "_" . $diverse;
                    $ext = $file->extension();
                    $type = $file->getMimeType();
                    $full_filename = $filename . "." . $ext;
                    $path = $file->storeAs("/diverses", $full_filename);
                    $name = $divdata['name'];
                    $div = new Diverse();
                    $div->name =  $name;
                    $div->type = $type;
                    $div->target = $path;
                    if($div->save()) {
                        activity('div-log')
                            ->causedBy(auth()->user())
                            ->performedOn($div)
                            ->withProperties(['action' => 'created'])
                            ->log('Gebruiker:  '.$div->name.' aangemaakt door:'.auth()->user()->username);
                    }
                    $div = Diverse::where("target", $path)->first();
                    $specialist->diverse()->attach($div->id);
                    activity('spec-log')
                        ->causedBy(auth()->user())
                        ->performedOn($specialist)
                        ->withProperties(['action' => 'div_attached'])
                        ->log('DIverse:  '.$div->name.' gekoppeld aan:'.$specialist->name.'door:'.auth()->user()->username);
                }
            }

            $specialist->specialisms()->detach();
            foreach ($request->specialisms as $specialism => $specdata) {
                if($specdata["name"] != null) {
                    $speci = Specialism::where('name', $specdata)->first();
                    $specialist->specialisms()->attach($speci, ['prio' => $specialism]);
                    activity('spec-log')
                        ->causedBy(auth()->user())
                        ->performedOn($specialist)
                        ->withProperties(['action' => 'specialism_attached'])
                        ->log('Werkgebied:  ' . $speci->name . ', met prioriteit:' . $specialism . ', gekoppeld aan:' . $specialist->name . 'door:' . auth()->user()->username);
                }
            }

            activity('spec-log')
                ->causedBy(auth()->user())
                ->performedOn($specialist)
                ->withProperties(['action' => 'updated'])
                ->log('Specialist:  '.$specialist->name.' bijgewerkt door:'.auth()->user()->username);
            \Session::flash("success", "Specialist: ".$specialist->name." succesvol bijgewerkt");
            return redirect()->route('admin.specialists.show', $specialist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Specialist $specialist
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialist $specialist)
    {
        try {
            $specialist->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        activity('spec-log')
            ->causedBy(auth()->user())
            ->performedOn($specialist)
            ->withProperties(['action' => 'destroyed'])
            ->log('Specialist:  '.$specialist->name.' verwijderd door: '.auth()->user()->username);
        \Session::flash("success", "Specialist: ".$specialist->name." succesvol verwijderd");

        return redirect()->route("admin.specialists.index");
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function saveImage(Request $request) {
        $cropped_value = $request->input("profile_image_cropped"); //// Width,height,x,y,rotate for cropping
        $cp_v = explode("," ,$cropped_value); /// Explode width,height,x etc
        $file = $request->file('profile_image');
        $file_name = Controller::quickRandom().".".$file->extension();
        if ($request->hasFile('profile_image')) {
            $file->storeAs("images/avatars/uncropped", $file_name); // Original Image Path
            $img = Image::make($file->getRealPath());
            $path2 = public_path("images/avatars/specialists/$file_name"); ///  Cropped Image Path
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3])->save($path2); // Crop and Save
        } else {
            return false;
        }
        return $file_name;
    }

    /**
     * @param $id
     * @return string
     */
    public function listSpec($id) {
        $specialist = Specialist::where('id', $id)->get(['name'])->toArray();
        return (string) $specialist[0]['name'];
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id) {
        $specialist = Specialist::withTrashed()->findOrFail($id);
        $specialist->restore();
        activity('spec-log')
            ->causedBy(auth()->user())
            ->performedOn($specialist)
            ->withProperties(['action' => 'restored'])
            ->log('Specialist:  '.$specialist->name.' hersteld door: '.auth()->user()->username);
        \Session::flash('success', 'Specialist: '.$specialist->name.' hersteld');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forget($id) {
        $specialist = Specialist::withTrashed()->firstOrFail($id);
        $specialist->specialisms()->detach();
        $specialist->images()->detach();
        $specialist->diverses()->detach();

        activity('spec-log')
            ->causedBy(auth()->user())
            ->performedOn($specialist)
            ->withProperties(['action' => 'forgotten'])
            ->log('Specialist:  '.$specialist->name.' permanent verwijderd door: '.auth()->user()->username);
        $specialist->forceDelete();
        \Session::flash('success', 'Specialist vergeten');
        return redirect()->route('admin.specialists.index');
    }
}
