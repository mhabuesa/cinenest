<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MovieModel;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use App\Models\CommentModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\DownLinkModel;
use App\Models\FavoriteModel;
use App\Models\InventoryModel;
use Illuminate\Support\Number;
use App\Models\DownloadContent;
use App\Models\ScreenShortLink;
use App\Models\TotalWebVisitor;
use App\Models\PaymentInfoModel;
use App\Models\ScreenshortModel;
use App\Models\TotalContentVisitor;
use App\Models\UniqueContentVisitor;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Encoders\WebpEncoder;

class MovieController extends Controller
{
    function movie_add()
    {


        if (Auth::user()->role == 'admin' || Auth::user()->role == 'moderator' || Auth::user()->role == 'marketer') {
            $categories = CategoryModel::all();
            return view('backend.movie.movie_add', [
                'categories' => $categories,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function movie_list()
    {

        $movies = MovieModel::where('status', 1)->latest()->get();
        return view('backend.movie.movies_list', [
            'movies' => $movies,
        ]);
    }

    function movie_delete($id)
    {

        foreach (ScreenshortModel::where('movie_id', $id)->get() as $mvi) {
            unlink(public_path('uploads/screen_short/' . $mvi->screen_short));
        }

        foreach (ScreenShortLink::where('movie_id', $id)->get() as $ss) {
            ScreenShortLink::find($ss->id)->delete();
        }
        $movie = MovieModel::find($id);
        unlink(public_path('uploads/cover/' . $movie->cover));
        ScreenshortModel::where('movie_id', $id)->delete();
        InventoryModel::where('movie_id', $id)->delete();
        DownLinkModel::where('movie_id', $id)->delete();
        TotalContentVisitor::where('movie_id', $id)->delete();
        UniqueContentVisitor::where('movie_id', $id)->delete();
        DownloadContent::where('movie_id', $id)->delete();

        CommentModel::where('movie_id', $id)->delete();
        FavoriteModel::where('movie_id', $id)->delete();
        ActivityLog::where('movie_id', $id)->delete();

        if ($movie->user_id != null) {
            PaymentInfoModel::where('user_id', $movie->user_id)->decrement('point', 1);
        }

        $movie->delete();


        return back()->with('delete', 'Movie Delete Successfully');
    }

    function movie_store(Request $request)
    {
        $request->validate([
            'cover' => 'required',
            'category' => 'required',
        ]);

        $replace = str_replace(array('(', ')', '!', '@'), '', $request->url);
        $lower = strtolower($replace);
        $url = str_replace(' ', '_', $lower) . '_' . random_int(000, 999);
        $explode = explode(' ', $request->title);

        $image = ImageProcess($request->cover);
        $image->resize(270, 400);
        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));

        $movie = MovieModel::create([
            'cover' => $cover_name,
            'title' => $request->title,
            'desp' => $request->desp,
            'story_line' => $request->story_line,
            'director' => $request->director,
            'release_year' => $request->release_year,
            'running_time' => $request->running_time,
            'industry' => $request->industry,
            'country' => $request->country,
            'language' => $request->language,
            'rating' => $request->rating,
            'version' => $request->version,
            'trailer' => $request->trailer,
            'url' => $url,
            'keyword' => $request->keyword,
            'status' => 0,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
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



        foreach ($request->category as $category) {
            $after_lower = strtolower($category);
            $slug = str_replace(' ', '', $after_lower);
            InventoryModel::create([
                'movie_id' => $movie->id,
                'category' => $category,
                'slug' => $slug,
                'created_at' => Carbon::now(),
            ]);
        }



        if ($request->screen_short != '') {
            foreach ($request->screen_short as $screen_short) {
                $extension = $screen_short->extension();
                $screen_short_name = $explode[0] . random_int(0000, 9999) . '.' . $extension;
                $s_short = ImageProcess($screen_short);
                $s_short->encode(new WebpEncoder)->save(public_path('uploads/screen_short/' . $screen_short_name, 60));

                ScreenshortModel::create([
                    'movie_id' => $movie->id,
                    'screen_short' => $screen_short_name,
                ]);
            }
        }



        $user = Auth::user();
        ActivityLog::create([
            'user_id' => $user->id,
            'designation' => $user->role,
            'movie_id' => $movie->id,
            'ip' => $request->ip(),
        ]);

        return back()->with('created', 'Movies Inserted Successfully');
    }

    function movie_edit($id)
    {

        $single_cat = InventoryModel::where('movie_id', $id)->get();
        $movie = MovieModel::find($id);
        $categories = CategoryModel::all();
        $downLinks = DownLinkModel::where('movie_id', $id)->get();
        $screenShorts = ScreenshortModel::where('movie_id', $id)->get();
        $screenShortLinks = ScreenShortLink::where('movie_id', $id)->get();
        return view('backend.movie.movie_edit', [
            'categories' => $categories,
            'movie' => $movie,
            'single_cat' => $single_cat,
            'downLinks' => $downLinks,
            'screenShorts' => $screenShorts,
            'screenShortLinks' => $screenShortLinks,
        ]);
    }

    function prev_link_del($id)
    {
        DownLinkModel::find($id)->delete();
        return back()->with('updated', 'Link Deleted Successfully');
    }



    function movie_update(Request $request, $id)
    {
        $request->validate([
            'keyword' => 'required',
        ]);


        $explode = explode(' ', $request->title);
        $movie = MovieModel::find($id);
        $url_data = MovieModel::find($id)->url;
        $replace = str_replace(array('(', ')', '!', '@'), '', $request->url);
        $lower = strtolower($replace);
        $url = str_replace(' ', '_', $lower) . '_' . random_int(000, 999);




        if ($request->cover == '') {

            if ($request->screen_short == '') {

                if ($request->category == '') {

                    if ($url_data == $request->url) {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {

                    if ($url_data == $request->url) {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    } else {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
            } else {

                if ($request->category == '') {

                    if ($url_data == $request->url) {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {

                    if ($url_data == $request->url) {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    } else {
                        $movie = MovieModel::find($id)->update([
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
            }
        } else {


            if ($request->screen_short == '') {

                if ($request->category == '') {

                    if ($url_data == $request->url) {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));



                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));



                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {

                    if ($url_data == $request->url) {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));



                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    } else {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));



                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
            } else {

                if ($request->category == '') {
                    if ($url_data == $request->url) {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));

                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));

                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {
                    if ($url_data == $request->url) {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));

                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    } else {
                        unlink(public_path('uploads/cover/' . $movie->cover));

                        $image = ImageProcess($request->cover);
                        $image->resize(270, 400);
                        $cover_name = $explode[0] . random_int(000, 999) . '.webp';
                        $image->encode(new WebpEncoder)->save(public_path('uploads/cover/' . $cover_name));

                        $movie = MovieModel::find($id)->update([
                            'cover' => $cover_name,
                            'title' => $request->title,
                            'desp' => $request->desp,
                            'story_line' => $request->story_line,
                            'director' => $request->director,
                            'release_year' => $request->release_year,
                            'running_time' => $request->running_time,
                            'industry' => $request->industry,
                            'country' => $request->country,
                            'language' => $request->language,
                            'rating' => $request->rating,
                            'version' => $request->version,
                            'trailer' => $request->trailer,
                            'url' => $url,
                            'down_link' => $request->down_link,
                            'keyword' => $request->keyword,
                            'updated_at' => Carbon::now(),
                        ]);

                        InventoryModel::where('movie_id', $id)->delete();
                        foreach ($request->category as $category) {
                            $after_lower = strtolower($category);
                            $slug = str_replace(' ', '', $after_lower);
                            InventoryModel::insert([
                                'movie_id' => $id,
                                'category' => $category,
                                'slug' => $slug,
                                'created_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
            ]);
        }

        if ($request->screen_short != null) {

            foreach($request->screen_short as $screen_short){
                $extension = $screen_short->extension();
                $screen_short_name = $explode[0] . random_int(0000, 9999). '.'. $extension;
                $s_short = ImageProcess($screen_short);
                $s_short->encode(new WebpEncoder)->save(public_path('uploads/screen_short/'.$screen_short_name, 60));

                ScreenshortModel::create([
                    'movie_id'=>$id,
                    'screen_short'=>$screen_short_name,
                ]);
            }
        }


        return back()->with('updated', 'Movies Updated Successfully');
    }


    function pendinglist()
    {
        if (Auth::user()->role == 'admin') {

            $movies = MovieModel::all();
            $similarMovies = [];

            foreach ($movies as $movie) {
                $title_explode = explode(' ', $movie->title);

                // Ensure that there are enough words in the title
                if (count($title_explode) >= 4) {
                    // Combine the 2nd, 3rd, and 4th words
                    $movie_title = $title_explode[0] . ' ' . $title_explode[1] . ' ' . $title_explode[2];

                    // Search for similar movies
                    $similar = MovieModel::where('title', 'LIKE', '%' . $movie_title . '%')->get();

                    // Exclude the current movie from the similar movies
                    if ($similar->count() > 1) {
                        $similarMovies[$movie->id] = $similar->where('id', '!=', $movie->id);
                    }
                }
            }

            $movies = MovieModel::where('status', 0)->get();
            return view('backend.movie.pending_list', compact('movies', 'similarMovies'));
        } else {
            $movies = MovieModel::where('user_id', Auth::user()->id)->where('status', 0)->get();
            return view('backend.movie.pending_list', compact('movies'));
        }
    }

    function approve(MovieModel $movie)
    {
        $movie->update([
            'status' => 1,
            'approval' => 1,
        ]);
        PaymentInfoModel::where('user_id', $movie->user_id)->increment('point', '1');

        return back()->with('success', 'Movie Approved Successfully');
    }
    function reject(MovieModel $movie, Request $request)
    {

        $request->validate([
            'reject_reason' => 'required',
        ]);

        $movie->update([
            'approval' => 0,
            'reject_reason' => $request->reject_reason
        ]);
        return back()->with('success', 'Movie Rejected Successfully');
    }


    function rejected_list()
    {
        $movies = MovieModel::where('user_id', Auth::user()->id)->where('approval', 0)->get();
        return view('backend.movie.rejected_list', compact('movies'));
    }

    function approval_req(MovieModel $movie)
    {
        $movie->update([
            'approval' => null,
        ]);
        return back()->with('success', 'Requested for Approval');
    }


    function movie_per_delete($id)
    {

        foreach (ScreenshortModel::where('movie_id', $id)->get() as $mvi) {
            unlink(public_path('uploads/screen_short/' . $mvi->screen_short));
        }

        foreach (ScreenShortLink::where('movie_id', $id)->get() as $ss) {
            ScreenShortLink::find($ss->id)->delete();
        }
        $movie = MovieModel::find($id);
        unlink(public_path('uploads/cover/' . $movie->cover));
        ScreenshortModel::where('movie_id', $id)->delete();
        InventoryModel::where('movie_id', $id)->delete();
        DownLinkModel::where('movie_id', $id)->delete();
        TotalContentVisitor::where('movie_id', $id)->delete();
        UniqueContentVisitor::where('movie_id', $id)->delete();
        DownloadContent::where('movie_id', $id)->delete();

        CommentModel::where('movie_id', $id)->delete();
        FavoriteModel::where('movie_id', $id)->delete();
        ActivityLog::where('movie_id', $id)->delete();

        $movie->delete();


        return back()->with('success', 'Movie Delete Successfully');
    }

    function screenshortLink_delete($id)
    {
        ScreenShortLink::find($id)->delete();
        return back()->with('success', 'Screen Short Deleted Successfully');
    }

    function screenshort_delete($id)
    {
        ScreenshortModel::find($id)->delete();
        return back()->with('success', 'Screen Short Deleted Successfully');
    }
}
