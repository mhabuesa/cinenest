<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\DownLinkModel;
use App\Models\DownloadContent;
use App\Models\InventoryModel;
use App\Models\MovieModel;
use App\Models\ScreenshortModel;
use App\Models\TotalContentVisitor;
use App\Models\TotalWebVisitor;
use App\Models\FavoriteModel;
use App\Models\PaymentInfoModel;
use App\Models\UniqueContentVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class MovieController extends Controller
{
    function movie_add(){


        if(Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator'){
            $categories = CategoryModel::all();
            return view('backend.movie.movie_add', [
                'categories'=>$categories,
            ]);
           }
           else{
            return redirect()->route('dashboard');
           }
    }

    function movie_list(){

        $movies = MovieModel::all();
        return view('backend.movie.movies_list', [
            'movies'=>$movies,
        ]);
    }

    function movie_delete($id){

        foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
            unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
        }
        $movie = MovieModel::find( $id );
        unlink(public_path('uploads/cover/'.$movie->cover));
        ScreenshortModel::where('movie_id', $id)->delete();
        InventoryModel::where('movie_id', $id)->delete();
        DownLinkModel::where('movie_id', $id)->delete();
        TotalContentVisitor::where('movie_id',$id)->delete();
        UniqueContentVisitor::where('movie_id',$id)->delete();
        DownloadContent::where('movie_id',$id)->delete();

        CommentModel::where('movie_id',$id)->delete();
        FavoriteModel::where('movie_id',$id)->delete();
        ActivityLog::where('movie_id',$id)->delete();

        if($movie->user_id != null){
            PaymentInfoModel::where('user_id', $movie->user_id)->decrement('point', 1);
        }

        $movie->delete();


        return back()->with('delete', 'Movie Delete Successfully');
    }

    function movie_store(Request $request){
        $request->validate([
            'cover'=>'required',
            'category'=>'required',
            'screen_short'=>'required',
        ]);


        $replace = str_replace(array('(', ')', '!', '@'), '',$request->url );
        $lower = strtolower($replace);
        $url = str_replace(' ', '_', $lower).'_'. random_int(000, 999);
        $explode = explode(' ', $request->title);
        $extension = $request->cover->extension();
        $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
        $cover = ImageProcess($request->cover);
        $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name, 60));

        $movie = MovieModel::create([
            'cover'=>$cover_name,
            'title'=>$request->title,
            'desp'=>$request->desp,
            'story_line'=>$request->story_line,
            'director'=>$request->director,
            'release_year'=>$request->release_year,
            'running_time'=>$request->running_time,
            'industry'=>$request->industry,
            'country'=>$request->country,
            'language'=>$request->language,
            'rating'=>$request->rating,
            'version'=>$request->version,
            'url'=>$url,
            'keyword'=>$request->keyword,
            'user_id'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);


        $captions = $request->caption;
        $downLinks = $request->down_link;

        foreach ($captions as $key => $caption) {
            DownLinkModel::create([
                'movie_id' => $movie->id,
                'caption' => $captions[$key],
                'link' => $downLinks[$key],
            ]);
        }



        foreach($request->category as $category){
            $after_lower = strtolower($category);
            $slug = str_replace(' ', '',$after_lower);
            InventoryModel::create([
                'movie_id'=>$movie->id,
                'category'=>$category,
                'slug'=>$slug,
                'created_at'=>Carbon::now(),
            ]);
        }





        foreach($request->screen_short as $screen_short){
            $extension = $screen_short->extension();
            $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
            $s_short = ImageProcess($screen_short);
            $s_short->save(public_path('uploads/screen_short/'.$screen_short_name, 60));

            ScreenshortModel::insert([
                'movie_id'=>$movie->id,
                'screen_short'=>$screen_short_name,
                'created_at'=>Carbon::now(),
            ]);
        }
        $user = Auth::user();
        ActivityLog::create([
            'user_id'=>$user->id,
            'designation'=>$user->roll,
            'movie_id'=>$movie->id,
            'ip'=>$request->ip(),
        ]);

        PaymentInfoModel::where('user_id', Auth::user()->id)->increment('point', '1');

        return back()->with('created', 'Movies Inserted Successfully');
    }

    function movie_edit($id){

        $single_cat = InventoryModel::where('movie_id', $id)->get();
        $movie = MovieModel::find($id);
        $categories = CategoryModel::all();
        $downLinks = DownLinkModel::where('movie_id', $id)->get();
        return view('backend.movie.movie_edit', [
            'categories'=>$categories,
            'movie'=>$movie,
            'single_cat'=>$single_cat,
            'downLinks'=>$downLinks,
        ]);

    }

    function prev_link_del($id){
        DownLinkModel::find($id)->delete();
        return back()->with('updated', 'Link Deleted Successfully');
    }



    function movie_update(Request $request, $id){
        $request->validate([
            'keyword'=>'required',
        ]);


        $explode = explode(' ', $request->title);
        $movie = MovieModel::find($id);
        $url_data = MovieModel::find($id)->url;
        $replace = str_replace(array('(', ')', '!', '@'), '',$request->url );
        $lower = strtolower($replace);
        $url = str_replace(' ', '_', $lower).'_'. random_int(000, 999);




        if($request->cover == ''){

            if($request->screen_short == ''){

                if($request->category == ''){

                    if($url_data == $request->url){
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);
                    }
                    else{
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'url'=>$url,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);
                    }

                }

                else{

                    if($url_data == $request->url){
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id',$id)->delete();
                        foreach($request->category as $category){
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '',$after_lower);
                            InventoryModel::insert([
                                'movie_id'=>$id,
                                'category'=>$category,
                                'slug'=>$slug,
                                'created_at'=>Carbon::now(),
                            ]);
                        }
                    }
                    else{
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'url'=>$url,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id',$id)->delete();
                        foreach($request->category as $category){
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '',$after_lower);
                            InventoryModel::insert([
                                'movie_id'=>$id,
                                'category'=>$category,
                                'slug'=>$slug,
                                'created_at'=>Carbon::now(),
                            ]);
                        }
                    }
                }


            }
            else{

                if($request->category == ''){

                   if($url_data == $request->url){
                    $movie = MovieModel::find($id)->update([
                        'title'=>$request->title,
                        'desp'=>$request->desp,
                        'story_line'=>$request->story_line,
                        'director'=>$request->director,
                        'release_year'=>$request->release_year,
                        'running_time'=>$request->running_time,
                        'industry'=>$request->industry,
                        'country'=>$request->country,
                        'language'=>$request->language,
                        'rating'=>$request->rating,
                        'version'=>$request->version,
                        'down_link'=>$request->down_link,
                        'keyword'=>$request->keyword,
                        'updated_at'=>Carbon::now(),
                    ]);


                    foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                        unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                    }
                    $ss = ScreenshortModel::where('movie_id', $id)->delete();

                    foreach($request->screen_short as $screen_short){
                        $extension = $screen_short->extension();
                        $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                        $s_short = ImageProcess($screen_short);
                        $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                        ScreenshortModel::insert([
                            'movie_id'=>$id,
                            'screen_short'=>$screen_short_name,
                            'created_at'=>Carbon::now(),
                        ]);
                    }
                   }
                   else{
                    $movie = MovieModel::find($id)->update([
                        'title'=>$request->title,
                        'desp'=>$request->desp,
                        'story_line'=>$request->story_line,
                        'director'=>$request->director,
                        'release_year'=>$request->release_year,
                        'running_time'=>$request->running_time,
                        'industry'=>$request->industry,
                        'country'=>$request->country,
                        'language'=>$request->language,
                        'rating'=>$request->rating,
                        'version'=>$request->version,
                        'url'=>$url,
                        'down_link'=>$request->down_link,
                        'keyword'=>$request->keyword,
                        'updated_at'=>Carbon::now(),
                    ]);


                    foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                        unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                    }
                    $ss = ScreenshortModel::where('movie_id', $id)->delete();

                    foreach($request->screen_short as $screen_short){
                        $extension = $screen_short->extension();
                        $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                        $s_short = ImageProcess($screen_short);
                        $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                        ScreenshortModel::insert([
                            'movie_id'=>$id,
                            'screen_short'=>$screen_short_name,
                            'created_at'=>Carbon::now(),
                        ]);
                    }
                   }
                }

                else{

                    if($url_data == $request->url){
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id',$id)->delete();
                        foreach($request->category as $category){
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '',$after_lower);
                            InventoryModel::insert([
                                'movie_id'=>$id,
                                'category'=>$category,
                                'slug'=>$slug,
                                'created_at'=>Carbon::now(),
                            ]);
                        }


                        foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                            unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                        }
                        $ss = ScreenshortModel::where('movie_id', $id)->delete();

                        foreach($request->screen_short as $screen_short){
                            $extension = $screen_short->extension();
                            $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                            $s_short = ImageProcess($screen_short);
                            $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                            ScreenshortModel::insert([
                                'movie_id'=>$id,
                                'screen_short'=>$screen_short_name,
                                'created_at'=>Carbon::now(),
                            ]);
                        }
                    }
                    else{
                        $movie = MovieModel::find($id)->update([
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'url'=>$url,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id',$id)->delete();
                        foreach($request->category as $category){
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '',$after_lower);
                            InventoryModel::insert([
                                'movie_id'=>$id,
                                'category'=>$category,
                                'slug'=>$slug,
                                'created_at'=>Carbon::now(),
                            ]);
                        }


                        foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                            unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                        }
                        $ss = ScreenshortModel::where('movie_id', $id)->delete();

                        foreach($request->screen_short as $screen_short){
                            $extension = $screen_short->extension();
                            $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                            $s_short = ImageProcess($screen_short);
                            $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                            ScreenshortModel::insert([
                                'movie_id'=>$id,
                                'screen_short'=>$screen_short_name,
                                'created_at'=>Carbon::now(),
                            ]);
                        }
                    }
                }

            }


        }
        else{


            if($request->screen_short == ''){

                if($request->category == ''){

                if($url_data == $request->url){
                    unlink(public_path('uploads/cover/'.$movie->cover));

                $extension = $request->cover->extension();
                $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                $cover = ImageProcess($request->cover);
                $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));



                $movie = MovieModel::find($id)->update([
                    'cover'=>$cover_name,
                    'title'=>$request->title,
                    'desp'=>$request->desp,
                    'story_line'=>$request->story_line,
                    'director'=>$request->director,
                    'release_year'=>$request->release_year,
                    'running_time'=>$request->running_time,
                    'industry'=>$request->industry,
                    'country'=>$request->country,
                    'language'=>$request->language,
                    'rating'=>$request->rating,
                    'version'=>$request->version,
                    'down_link'=>$request->down_link,
                    'keyword'=>$request->keyword,
                    'updated_at'=>Carbon::now(),
                ]);
                }
                else{
                    unlink(public_path('uploads/cover/'.$movie->cover));

                $extension = $request->cover->extension();
                $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                $cover = ImageProcess($request->cover);
                $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));



                $movie = MovieModel::find($id)->update([
                    'cover'=>$cover_name,
                    'title'=>$request->title,
                    'desp'=>$request->desp,
                    'story_line'=>$request->story_line,
                    'director'=>$request->director,
                    'release_year'=>$request->release_year,
                    'running_time'=>$request->running_time,
                    'industry'=>$request->industry,
                    'country'=>$request->country,
                    'language'=>$request->language,
                    'rating'=>$request->rating,
                    'version'=>$request->version,
                    'url'=>$url,
                    'down_link'=>$request->down_link,
                    'keyword'=>$request->keyword,
                    'updated_at'=>Carbon::now(),
                ]);
                }



                }

                else{

                    if($url_data == $request->url){
                        unlink(public_path('uploads/cover/'.$movie->cover));

                $extension = $request->cover->extension();
                $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                $cover = ImageProcess($request->cover);
                $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));



                $movie = MovieModel::find($id)->update([
                    'cover'=>$cover_name,
                    'title'=>$request->title,
                    'desp'=>$request->desp,
                    'story_line'=>$request->story_line,
                    'director'=>$request->director,
                    'release_year'=>$request->release_year,
                    'running_time'=>$request->running_time,
                    'industry'=>$request->industry,
                    'country'=>$request->country,
                    'language'=>$request->language,
                    'rating'=>$request->rating,
                    'version'=>$request->version,
                    'down_link'=>$request->down_link,
                    'keyword'=>$request->keyword,
                    'updated_at'=>Carbon::now(),
                ]);

                InventoryModel::where('movie_id',$id)->delete();
                foreach($request->category as $category){
                    $after_lower = strtolower($category);
                    $slug = str_replace(' ', '',$after_lower);
                    InventoryModel::insert([
                        'movie_id'=>$id,
                        'category'=>$category,
                        'slug'=>$slug,
                        'created_at'=>Carbon::now(),
                    ]);
                }
                    }
                    else{
                        unlink(public_path('uploads/cover/'.$movie->cover));

                        $extension = $request->cover->extension();
                        $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                        $cover = ImageProcess($request->cover);
                        $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));



                        $movie = MovieModel::find($id)->update([
                            'cover'=>$cover_name,
                            'title'=>$request->title,
                            'desp'=>$request->desp,
                            'story_line'=>$request->story_line,
                            'director'=>$request->director,
                            'release_year'=>$request->release_year,
                            'running_time'=>$request->running_time,
                            'industry'=>$request->industry,
                            'country'=>$request->country,
                            'language'=>$request->language,
                            'rating'=>$request->rating,
                            'version'=>$request->version,
                            'url'=>$url,
                            'down_link'=>$request->down_link,
                            'keyword'=>$request->keyword,
                            'updated_at'=>Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id',$id)->delete();
                        foreach($request->category as $category){
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '',$after_lower);
                            InventoryModel::insert([
                                'movie_id'=>$id,
                                'category'=>$category,
                                'slug'=>$slug,
                                'created_at'=>Carbon::now(),
                            ]);
                        }
                    }
                }


            }
            else{

                if($request->category == ''){
                    if($url_data == $request->url){
                        unlink(public_path('uploads/cover/'.$movie->cover));

                    $extension = $request->cover->extension();
                    $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                    $cover = ImageProcess($request->cover);
                    $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));

                    $movie = MovieModel::find($id)->update([
                        'cover'=>$cover_name,
                        'title'=>$request->title,
                        'desp'=>$request->desp,
                        'story_line'=>$request->story_line,
                        'director'=>$request->director,
                        'release_year'=>$request->release_year,
                        'running_time'=>$request->running_time,
                        'industry'=>$request->industry,
                        'country'=>$request->country,
                        'language'=>$request->language,
                        'rating'=>$request->rating,
                        'version'=>$request->version,
                        'down_link'=>$request->down_link,
                        'keyword'=>$request->keyword,
                        'updated_at'=>Carbon::now(),
                    ]);



                    foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                        unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                    }
                    $ss = ScreenshortModel::where('movie_id', $id)->delete();

                    foreach($request->screen_short as $screen_short){
                        $extension = $screen_short->extension();
                        $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                        $s_short = ImageProcess($screen_short);
                        $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                        ScreenshortModel::insert([
                            'movie_id'=>$id,
                            'screen_short'=>$screen_short_name,
                            'created_at'=>Carbon::now(),
                        ]);
                    }
                    }
                    else{
                        unlink(public_path('uploads/cover/'.$movie->cover));

                    $extension = $request->cover->extension();
                    $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                    $cover = ImageProcess($request->cover);
                    $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));

                    $movie = MovieModel::find($id)->update([
                        'cover'=>$cover_name,
                        'title'=>$request->title,
                        'desp'=>$request->desp,
                        'story_line'=>$request->story_line,
                        'director'=>$request->director,
                        'release_year'=>$request->release_year,
                        'running_time'=>$request->running_time,
                        'industry'=>$request->industry,
                        'country'=>$request->country,
                        'language'=>$request->language,
                        'rating'=>$request->rating,
                        'version'=>$request->version,
                        'url'=>$url,
                        'down_link'=>$request->down_link,
                        'keyword'=>$request->keyword,
                        'updated_at'=>Carbon::now(),
                    ]);



                    foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                        unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                    }
                    $ss = ScreenshortModel::where('movie_id', $id)->delete();

                    foreach($request->screen_short as $screen_short){
                        $extension = $screen_short->extension();
                        $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                        $s_short = ImageProcess($screen_short);
                        $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                        ScreenshortModel::insert([
                            'movie_id'=>$id,
                            'screen_short'=>$screen_short_name,
                            'created_at'=>Carbon::now(),
                        ]);
                    }
                    }
                }
                else{
                    if($url_data == $request->url){
                        unlink(public_path('uploads/cover/'.$movie->cover));

                $extension = $request->cover->extension();
                $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                $cover = ImageProcess($request->cover);
                $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));

                $movie = MovieModel::find($id)->update([
                    'cover'=>$cover_name,
                    'title'=>$request->title,
                    'desp'=>$request->desp,
                    'story_line'=>$request->story_line,
                    'director'=>$request->director,
                    'release_year'=>$request->release_year,
                    'running_time'=>$request->running_time,
                    'industry'=>$request->industry,
                    'country'=>$request->country,
                    'language'=>$request->language,
                    'rating'=>$request->rating,
                    'version'=>$request->version,
                    'down_link'=>$request->down_link,
                    'keyword'=>$request->keyword,
                    'updated_at'=>Carbon::now(),
                ]);

                InventoryModel::where('movie_id',$id)->delete();
                foreach($request->category as $category){
                    $after_lower = strtolower($category);
                    $slug = str_replace(' ', '',$after_lower);
                    InventoryModel::insert([
                        'movie_id'=>$id,
                        'category'=>$category,
                        'slug'=>$slug,
                        'created_at'=>Carbon::now(),
                    ]);
                }


                foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                    unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                }
                $ss = ScreenshortModel::where('movie_id', $id)->delete();

                foreach($request->screen_short as $screen_short){
                    $extension = $screen_short->extension();
                    $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                    $s_short = ImageProcess($screen_short);
                    $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                    ScreenshortModel::insert([
                        'movie_id'=>$id,
                        'screen_short'=>$screen_short_name,
                        'created_at'=>Carbon::now(),
                    ]);
                }
                    }
                    else{
                        unlink(public_path('uploads/cover/'.$movie->cover));

                $extension = $request->cover->extension();
                $cover_name = $explode[0] . random_int(000, 999). '.'. $extension;
                $cover = ImageProcess($request->cover);
                $cover->resize(270,400)->save(public_path('uploads/cover/'.$cover_name));

                $movie = MovieModel::find($id)->update([
                    'cover'=>$cover_name,
                    'title'=>$request->title,
                    'desp'=>$request->desp,
                    'story_line'=>$request->story_line,
                    'director'=>$request->director,
                    'release_year'=>$request->release_year,
                    'running_time'=>$request->running_time,
                    'industry'=>$request->industry,
                    'country'=>$request->country,
                    'language'=>$request->language,
                    'rating'=>$request->rating,
                    'version'=>$request->version,
                    'url'=>$url,
                    'down_link'=>$request->down_link,
                    'keyword'=>$request->keyword,
                    'updated_at'=>Carbon::now(),
                ]);

                InventoryModel::where('movie_id',$id)->delete();
                foreach($request->category as $category){
                    $after_lower = strtolower($category);
                    $slug = str_replace(' ', '',$after_lower);
                    InventoryModel::insert([
                        'movie_id'=>$id,
                        'category'=>$category,
                        'slug'=>$slug,
                        'created_at'=>Carbon::now(),
                    ]);
                }


                foreach(ScreenshortModel::where('movie_id', $id)->get() as $mvi ){
                    unlink(public_path('uploads/screen_short/'.$mvi->screen_short));
                }
                $ss = ScreenshortModel::where('movie_id', $id)->delete();

                foreach($request->screen_short as $screen_short){
                    $extension = $screen_short->extension();
                    $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                    $s_short = ImageProcess($screen_short);
                    $s_short->save(public_path('uploads/screen_short/'.$screen_short_name));

                    ScreenshortModel::insert([
                        'movie_id'=>$id,
                        'screen_short'=>$screen_short_name,
                        'created_at'=>Carbon::now(),
                    ]);
                }
                    }
                }

            }

        }


        $captions = $request->caption;
        $downLinks = $request->down_link;

        if (array_filter($captions)) {
            foreach ($captions as $key => $caption) {
                DownLinkModel::create([
                    'movie_id' => $id,
                    'caption' => $captions[$key],
                    'link' => $downLinks[$key],
                ]);
            }

            MovieModel::find($id)->update([
                'created_at'=>Carbon::now(),
            ]);
        }


        return back()->with('updated', 'Movies Updated Successfully');

    }



}
