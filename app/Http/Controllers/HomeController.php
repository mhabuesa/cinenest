<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MovieModel;
use App\Models\ActivityLog;
use Spatie\Sitemap\Sitemap;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;
use App\Models\CategoryModel;
use App\Models\ConfigMetaModel;
use App\Models\DownloadContent;
use App\Models\TotalWebVisitor;
use App\Models\UniqueWebVisitor;
use Illuminate\Support\Facades\DB;
use App\Models\TotalContentVisitor;
use App\Models\UniqueContentVisitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    function index(Request $request)
    {

        $supperHits = MovieModel::where('supper_hit', 1)->latest()->get();
        $oscars = MovieModel::where('oscar', 1)->latest()->take(10)->get();
        $movies = MovieModel::latest()->get();
        $pageMeta = ConfigMetaModel::find(1);
        return view('frontend.index', [
            'movies' => $movies,
            'supperHits' => $supperHits,
            'oscars' => $oscars,
            'pageMeta' => $pageMeta,
        ]);
    }

    function dashboard()
    {


        $totalItem =  MovieModel::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $download =  DownloadContent::whereMonth('created_at', Carbon::now()->month)->get()->count();


        $totalDownload = DownloadContent::all()->count();

        $contentDownload = DownloadContent::select('movie_id', DB::raw('COUNT(*) as movie_count'))
            ->groupBy('movie_id')
            ->orderBy('movie_count', 'DESC')
            ->take(10)->get();



        if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer') {
            return view('backend.index', [
                'totalItem' => $totalItem,
                'download' => $download,
                'contentDownload' => $contentDownload,
                'totalDownload' => $totalDownload,
            ]);
        } else {
            return redirect()->route('profile');
        }
    }

    function unauthorized()
    {
        return view('backend.unauthorized');
    }

    function activityLog()
    {
        if (Auth::user()->role == 'admin') {
            $activities = ActivityLog::where('log', null)->select('user_id', DB::raw('COUNT(*) as movie_count'))
                ->groupBy('user_id')
                ->orderBy('movie_count', 'DESC')
                ->get();


            $logIds = ActivityLog::select(DB::raw('MAX(id) as id'))
                ->where('log', '!=', null)
                ->groupBy('user_id')
                ->pluck('id');

            $logs = ActivityLog::whereIn('id', $logIds)
                ->with('user')
                ->latest()
                ->get();

            return view('backend.activityLog', [
                'activities' => $activities,
                'logs' => $logs,
            ]);
        } else {
            return redirect()->route('profile');
        }
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return redirect()->back()->with('success', 'Cache has been cleared successfully!');
    }

    public function sitemap()
    {
        // Single Url
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/disclaimer'))
            ->add(Url::create('/privacyPolicy'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/user/profile'))
            ->add(Url::create('/signup'))
            ->add(Url::create('/forget'))
            ->add(Url::create('/oscar'))
            ->add(Url::create('/signin'));

        // Category
        $categories = CategoryModel::all();
        foreach ($categories as $category) {
            $sitemap->add(Url::create('/cat/' . $category->slug));
        }

        // Movie
        $movies = MovieModel::all();
        foreach ($movies as $movie) {
            $sitemap->add(Url::create('/mvi/' . $movie->url));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        return response()->file(public_path('sitemap.xml'));
    }

    public function sitemap_reload(){
        $sitemapPath = public_path('sitemap.xml');

    if (File::exists($sitemapPath)) {
        File::delete($sitemapPath);
        return redirect()->back()->with('success', 'Sitemap Reload successfully!');
    }

    return redirect()->back()->with('error', 'Sitemap file does not exist!');
    }
}
