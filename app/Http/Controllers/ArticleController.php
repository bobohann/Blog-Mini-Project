<?php

namespace App\Http\Controllers;

use App\Models\Article;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }


    public function index()
    {
        $data = Article::latest()->paginate(5);
        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);

        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "News"],
            ["id" => 2, "name" => "Tech"],
        ];
        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $image = request()->file('file');
        $image_name = time() . '.' . $image->extension();
        $image->move(public_path('images'), $image_name);

        $article = new Article();
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->profile_image = $image_name;
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if (Gate::allows('article-delete', $article)) {

            $article->delete();
            return redirect('/articles')->with('info', 'Article Deleted');
        } else {
            return back()->with('error', "Unauthorize");
        }
    }

    public function edit($id)
    {

        $data = [
            ["id" => 1, "name" => "News"],
            ["id" => 2, "name" => "Tech"],
        ];

        $article = Article::find($id);
        return view('articles.edit', [
            'article' => $article,
            'categories' => $data
        ]);


        // $article = Article::find($id);
        // $article->title = request()->title;
        // $article->body = request()->body;
        // $article->category_id = request()->category_id;

        // $article->save();
        // return redirect('/articles')->with('info', 'Article Updated');
    }
}