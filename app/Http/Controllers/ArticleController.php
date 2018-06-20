<?php

namespace Prebaby\Http\Controllers;

use Prebaby\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * The Logic to create a article.
     *
     * @param Request $request
     * @return void
     */
    public function articleCreateArticle(Request $request){
        $request->validate([
    		'body' 		=>	'required',
    		'title'		=>	'required',
    		'trimester'	=>	'digits_between:0,1|numeric|in:1,2,3'
        ]);
        
        $article = new Article();

        $article->body = $request['body']; # Get the body from the form and save it.
        $article->title = $request['title'];
        $article->trimester = $request['trimester'];

        $article->save();
        return Redirect()->back()->with('success', 'Article Created');
    }

    /**
     * Logic to Read all articles,
     * load each article to its location.
     */

    public function index1(){
        $articles = Article::where('trimester',1)->get();
        return view('firstArticles', ['articles' => $articles]);
    }

    public function index2(){
        $articles = Article::where('trimester',2)->get();
        return view('firstArticles', ['articles' => $articles]);
    }

    public function index3(){
        $articles = Article::where('trimester',3)->get();
        return view('firstArticles', ['articles' => $articles]);
    }

    /**
     * Logic to Get rid of articles.
     * and Delete them.
     */
    public function deleteArticle($article_id){
        
        $article = Article::where('id', $article_id)->first();
        $article->delete();
        return Redirect()->back()->with('success', 'Deleted');

    }


    /**
     * Logic to edit articles,
     * using the old branch.
     */
    public function editArticle($article_id, Request $request, Article $req_article){

        $articles = Article::where('id', $article_id)->first();
        return view('layouts.editArticle', ['articles' => $articles]);
       
    }

    /**
     * the Update is being done over 2 methods,
     * [first] to get the old view,
     * [second] to edit it and save to database.
     *
     * @param [integer] $article_id
     * @param Request $request
     * @param Article $article
     * @return void
     */
    public function save($article_id, Request $request, Article $article){

        $request->validate([
            'body' 		=>	'required',
            'title'		=>	'required',
            'trimester'	=>	'digits_between:0,1|numeric|in:1,2,3'
        ]);
        
        // get the old id.
        $article = Article::where('id', $article_id)->first();
        
        // update its data.
        $article->title = $request['title'];
        $article->body = $request['body'];
        $article->trimester = $request['trimester'];
        
        // save it to database.
        $article->save();
       
        return Redirect()->back()->with('success', 'Article Updated');

    }

}
