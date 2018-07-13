<?php

namespace App\Http\Controllers\Admin;

use App\Models\Complaint;
use App\Models\Therapy;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;
use function PHPSTORM_META\type;
use Spatie\Activitylog\Models\Activity;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageC;

/**
 * Class ComplaintController
 * @package App\Http\Controllers\Admin
 */
class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $fdir = [
            'id' => 'asc',
            'name' => 'asc',
            'short_description' => 'asc',
            'complaint_image' => 'asc',
            'updated_at' => 'asc'
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if (isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $complaints = Complaint::query();
        $complaints = $complaints->select('id', 'name', 'short_description', 'complaint_image', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $complaints->where($filter_type, "LIKE", "%$q%");
        }
        $complaints = $complaints->orderBy($column, $dir)->paginate('10', ['*'], 'complaints');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.complaints.index', compact('complaints', 'fdir', 'column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $therapies = Therapy::paginate(12);
        return view('admin.complaints.create',  compact('therapies'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $image_path =  $request->has($request->file($request->complaint_image)) ? 'public/images/avatars/complaints/'.$request->complaint_image_filename : 'public/images/anonymous.png';


        $input = array(
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'complaint_image' => $image_path,
        );

        $complaint = Complaint::create($input);


        foreach ($request->complaint_image as $image => $imagedata) {
            if ($request->hasFile('images.' . $image . '.file')) {
                $file = $request->file('images.' . $image . '.file');
                $filename = str_replace(' ', '_', $input['name']) . "_" . $image;
                $ext = $file->extension();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs('/images/avatars/complaints/', $full_filename);
                $caption = $imagedata['caption'];
                $im = new ImageC();
                $im->path = $path;
                $im->caption = $caption;
                $im = ImageC::where('path', $path)->first();
                $complaint->images()->attach($im);
            }
        }


        return redirect()->route('admin.complaints.show', $complaint->id);
    }



    /**
     * Display the specified resource.
     *
     * @param Complaint $complaint
     *
     * @return void
     */
    public function show(Complaint $complaint)
    {
        return view("admin.complaints.show", compact('complaint'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Complaint $complaint
     *
     * @return void
     */
    public function edit(Complaint $complaint)
    {
        return view("admin.complaints.edit", compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Complaint $complaint
     *
     * @return void
     */
    public function update(Request $request, Complaint $complaint)
    {


        $input = array(
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'complaint_image' => $request->complaint_image,
        );

        $complaint->name = $request->name;
        $complaint->description = $request->description;
        $complaint->short_description = $request->short_description;
        if ($request->complaint_image_filename) {
            $complaint->complaint_image = 'public/images/avatars/complaints/' . $request->complaint_image_filename;
        }
        $complaint->save();

        $complaint->images()->detach();
        foreach ($request->complaint_image as $image => $imagedata) {
            if ($request->hasFile('images.' . $image . '.file')) {
                $file = $request->file('images.' . $image . '.file');
                $filename = str_replace(' ', '_', $input['name']) . "_" . $image;
                $ext = $file->extension();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs('/images/avatars/complaints/images', $full_filename);
                $caption = $imagedata['caption'];
                $im = new ImageC();
                $im->path = $path;
                $im->caption = $caption;
                $im = ImageC::where('path', $path)->first();
                $complaint->images()->attach($im);
            }
        }
        \Session::flash("success", "Klacht: " . $complaint->name . " succesvol bijgewerkt");
        return redirect()->route('admin.complaints.show', $complaint);
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function saveImage(Request $request)
    {
        $cropped_value = $request->input("complaint_image_cropped"); //// Width,height,x,y,rotate for cropping
        $cp_v = explode(",", $cropped_value); /// Explode width,height,x etc
        $file = $request->file('complaint_image');
        $file_name = Controller::quickRandom() . "." . $file->extension();
        if ($request->hasFile('complaint_image')) {
            $file->storeAs("images/avatars/uncropped", $file_name); // Original Image Path
            $img = Image::make($file->getRealPath());
            $path2 = public_path("images/avatars/complaints/$file_name"); ///  Cropped Image Path
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3])->save($path2); // Crop and Save
        } else {
            return false;
        }
        return $file_name;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Complaint $complaint
     *
     * @return void
     */
    public function destroy(Complaint $complaint)
    {
        $name = $complaint->name;
        try {
            $complaint->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        activity('comp-log')
            ->causedBy(auth()->user())
            ->performedOn($complaint)
            ->withProperties(['action' => 'destroyed'])
            ->log('Klacht:  ' . $name . ' verwijderd door: ' . auth()->user()->username);
        \Session::flash("success", "Klacht: " . $name . " succesvol verwijderd");

        return redirect()->route("admin.complaints.index");
    }
}
