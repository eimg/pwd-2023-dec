<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

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
        $article = Article::find($id);

        return view('articles.detail', [
            'article' => $article
        ]);
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if(Gate::allows('delete-article', $article)) {
            $article->delete();
            return redirect("/articles")->with("info", "Article deleted");
        }

        return back()->with('info', 'Unauthorize');
    }

    public function add()
    {
        $categories = Category::all();

        return view('articles.add', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->id();
        $article->save();

        return redirect("/articles");
    }

    public function edit($id)
    {
        $categories = Category::all();
        $article = Article::find($id);

        return view('articles.edit', [
            'categories' => $categories,
            'article' => $article,
        ]);
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();

        return redirect("/articles/detail/$id");
    }
}
