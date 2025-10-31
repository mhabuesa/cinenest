<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MovieModel;
use App\Models\CommentModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\DownLinkModel;
use App\Models\FavoriteModel;
use App\Models\InventoryModel;
use GuzzleHttp\Promise\Create;
use App\Models\ConfigMetaModel;
use App\Models\DownloadContent;
use App\Models\ScreenShortLink;
use App\Models\ScreenshortModel;
use App\Models\ContactMessageModel;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function movie_details(Request $request, $url){

        $movie = MovieModel::where('url',$url)->first();
        $downLinks = DownLinkModel::where('movie_id',$movie->id)->get();
        $mayLikes = MovieModel::where('id', '!=', $movie->id)->where('industry', $movie->industry)->where('status', 1)->latest()->take(6)->get();
        $recentMovie = MovieModel::where('id', '!=', $movie->id)->where('status', 1)->latest()->take(6)->get();


        $download = DownloadContent::where('movie_id', $movie->id)->count();


        $screenShorts = ScreenshortModel::where('movie_id', $movie->id)->get();
        $screenShortLinks = ScreenShortLink::where('movie_id', $movie->id)->get();
        
        return view('frontend.movie_details',[
            'movie'=>$movie,
            'downLinks'=>$downLinks,
            'mayLikes'=>$mayLikes,
            'recentMovie'=>$recentMovie,
            'download'=>$download,
            'screenShortLinks'=>$screenShortLinks,
            'screenShorts'=>$screenShorts,
        ]);
    }

    function category_view(Request $request, $slug){



        $category = CategoryModel::where('slug' , $slug)->first();
        $movies = InventoryModel::where('slug' , $slug)->latest()->get();

        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.category', [
            'movies'=>$movies,
            'category'=>$category,
            'slug'=>$slug,
            'pageMeta'=>$pageMeta,
        ]);
    }

    function oscar(Request $request){

        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.oscarWinning', [
            'pageMeta'=>$pageMeta,
        ]);
    }
    function contact(Request $request){

        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.contact', [
            'pageMeta'=>$pageMeta,
        ]);
    }

    function contact_send(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|max:255|email',
            'subject'=>'required|max:255',
            'message'=>'required|max:1000',
        ]);


        ContactMessageModel::create([
            'name'=>htmlentities($request->name),
            'email'=>htmlentities($request->email),
            'subject'=>htmlentities($request->subject),
            'message'=>htmlentities($request->message),
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('sent', 'Message Sent Successfully!  &nbsp; Thank You.');

    }


    function download(Request $request,$id){
        $movie = DownLinkModel::find($id);
        $ip = $request->ip();
        DownloadContent::Create([
            'ip' => $ip,
            'movie_id'=>$movie->movie_id,
        ]);

        return redirect($movie->link);
    }

    function disclaimer(){
        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.disclaimer', [
            'pageMeta'=>$pageMeta,
        ]);
    }

    function privacyPolicy(){
        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.privacyPolicy',[
            'pageMeta'=>$pageMeta,
        ]);
    }

    function search(){
        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.search', [
            'pageMeta'=>$pageMeta,
        ]);
    }

    function signin(){
        return view("frontend.signin");
    }
    function signup(){
        return view("frontend.signup");
    }
    function forget(){
        return view("frontend.forget");
    }
    function profile(){
        $comments = CommentModel::where("visitor_id",Auth::guard('visitor')->user()->id)->latest()->get();
        $count = CommentModel::where("visitor_id",Auth::guard('visitor')->user()->id)->count();
        $favorites = FavoriteModel::where("visitor_id",Auth::guard('visitor')->user()->id)->latest()->get();
        $pageMeta = ConfigMetaModel::find(1);
        return view("frontend.profile",[
            'comments'=>$comments,
            'count'=>$count,
            'favorites'=>$favorites,
            'pageMeta'=>$pageMeta,
        ]);
    }


    function verification($uniqueId){

        $unique_id = VisitorModel::where("unique_id",$uniqueId)->first();
        if($unique_id){
            return view("frontend.verification",compact("uniqueId"));
        }
        else{
            return redirect()->route("signup");
        }
    }


    function forget_pass($id){
        $pass_reset_id = VisitorModel::where("pass_reset_id",$id)->first();
        if($pass_reset_id){
            return view('frontend.forget_code_check',compact("id"));
        }
        else{
            return redirect()->route("signup");
        }


    }

    function pass_reset($change_pass){
        $change = VisitorModel::where("change_pass",$change_pass)->first();
        if($change){
            return view('frontend.pass_reset',compact("change_pass"));
        }
        else{
            return redirect()->route("signup");
        }


    }





}
