<?php

namespace App\Http\Controllers\admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Image as ImageC;

class ArticleController extends Controller
{

    public function index(){
        $fdir = [
            'id' => 'asc',
            'name' => 'asc',
            'short_description' => 'asc',
            'article_image' => 'asc',
            'updated_at' => 'asc'
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if (isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $articles = Article::query();
        $articles = $articles->select('id', 'name', 'short_description', 'article_image', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $articles->where($filter_type, "LIKE", "%$q%");
        }
        $articles = $articles->orderBy($column, $dir)->paginate('10', ['*'], 'articles');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.articles.index', compact('articles', 'fdir', 'column'));;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.articles.create');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $image_path =  $request->has($request->file($request->article_image)) ? 'public/images/avatars/articles/'.$request->article_image_filename : 'public/images/anonymous.png';


        $input = array(
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'article_image' => $image_path,
        );

        $article = Article::create($input);


        foreach ($request->article_image as $image => $imagedata) {
            if ($request->hasFile('images.' . $image . '.file')) {
                $file = $request->file('images.' . $image . '.file');
                $filename = str_replace(' ', '_', $input['name']) . "_" . $image;
                $ext = $file->extension();
                $full_filename = $filename . "." . $ext;
                $path = $file->storeAs('/images/avatars/articles/images', $full_filename);
                $caption = $imagedata['caption'];
                $im = new ImageC();
                $im->path = $path;
                $im->caption = $caption;
                $im = ImageC::where('path', $path)->first();
                $article->images()->attach($im);

            }
        }


        return redirect()->route('admin.articles.show', $article->id);
    }
    /**
     * @param Request $request
     * @return bool|string
     */
    public function saveImage(Request $request) {
        $cropped_value = $request->input("article_image_cropped"); //// Width,height,x,y,rotate for cropping
        $cp_v = explode("," ,$cropped_value); /// Explode width,height,x etc
        $file = $request->file('article_image');
        $file_name = Controller::quickRandom().".".$file->extension();
        if ($request->hasFile('article_image')) {
            $file->storeAs("images/avatars/uncropped", $file_name); // Original Image Path
            $img = Image::make($file->getRealPath());
            $path2 = public_path("images/avatars/articles/$file_name"); ///  Cropped Image Path
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3])->save($path2); // Crop and Save
        } else {
            return false;
        }
        return $file_name;
    }


    /**
     * Display the specified resource.
     *
     * @param Article $Article
     *
     * @return void
     */
    public function show(Article $article)
    {
        return view("admin.articles.show", compact('article'));

    }
}
