<?php

namespace App\Http\Controllers\admin;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Middleware\Debugbar;
use function MongoDB\BSON\toJSON;
use function PHPSTORM_META\type;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageC;


class RecipeController extends Controller
{


    public function index(){
        $fdir = [
            'id' => 'asc',
            'name' => 'asc',
            'ingredients' => 'asc',
            'preperation' => 'asc',
            'factoid' => 'asc',
            'primary_image' => 'asc',
            'secondary_image' => 'asc',
            'updated_at' => 'asc'
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if (isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $recipes = Recipe::query();
        $recipes = $recipes->select('id', 'name', 'ingredients','preperation', 'factoid', 'primary_image', 'secondary_image', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $recipes->where($filter_type, "LIKE", "%$q%");
        }
        $recipes = $recipes->orderBy($column, $dir)->paginate('10', ['*'], 'recipes');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.recipes.index', compact('recipes', 'fdir', 'column'));;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.recipes.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $image_path =  $request->has($request->file($request->primary_image)) ? 'public/images/avatars/recipes/'.$request->primary_image_filename : 'public/images/anonymous.png';
        $second_image_path =  $request->has($request->file($request->secondary_image)) ? 'public/images/avatars/recipes/'.$request->secondary_image_filename : 'public/images/anonymous.png';


        $input = array(
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'preperation' => $request->preperation,
            'factoid' => $request->factoid,
            'primary_image' => $image_path,
            'secondary_image' => $second_image_path,
        );

        $recipe = Recipe::create($input);


        foreach ($request->primary_image as $image => $imagedata) {
            if ($request->hasFile('images.' . $image . '.file')) {
                $file = $request->file('images.' . $image . '.file');
                $filename = str_replace(' ', '_', $input['name']) . "_" . $image;
                $ext = $file->extension();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs('/images/avatars/recipes/images', $full_filename);
                $caption = $imagedata['caption'];
                $im = new ImageC();
                $im->path = $path;
                $im->caption = $caption;
                $im = ImageC::where('path', $path)->first();
                $recipe->images()->attach($im);

            }
        }

          return redirect()->route('admin.recipes.show', $recipe->id);
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function savePrimaryImage(Request $request) {
        $cropped_value = $request->input("primary_image_cropped"); //// Width,height,x,y,rotate for cropping
        $cp_v = explode("," ,$cropped_value); /// Explode width,height,x etc
        $file = $request->file('primary_image');
        $file_name = Controller::quickRandom().".".$file->extension();
        if ($request->hasFile('primary_image')) {
            $file->storeAs("images/avatars/uncropped", $file_name); // Original Image Path
            $img = Image::make($file->getRealPath());
            $path2 = public_path("images/avatars/recipes/$file_name"); ///  Cropped Image Path
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3])->save($path2); // Crop and Save
        } else {
            return false;
        }
        return $file_name;
    }


    /**
     * Display the specified resource.
     *
     * @param Recipe $recipe
     *
     * @return void
     */
    public function show(Recipe $recipe)
    {
        return view("admin.recipes.show", compact('recipe'));

    }
}
