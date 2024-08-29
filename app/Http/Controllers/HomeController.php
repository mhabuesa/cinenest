<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DownloadContent;
use App\Models\MovieModel;
use App\Models\TotalContentVisitor;
use App\Models\TotalWebVisitor;
use App\Models\UniqueContentVisitor;
use App\Models\UniqueWebVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index(Request $request){
        $all_ip = $request->ip();
        TotalWebVisitor::Create(['ip' => $all_ip]);

        // Unique Visitor
        $ip = $request->ip();
        UniqueWebVisitor::firstOrCreate(['ip' => $ip]);

        $supperHits = MovieModel::where('supper_hit', 1)->latest()->get();
        $oscars = MovieModel::where('oscar', 1)->latest()->take(10)->get();
        $movies = MovieModel::latest()->get();
        return view('frontend.index', [
            'movies'=>$movies,
            'supperHits'=>$supperHits,
            'oscars'=>$oscars,
        ]);
    }

    function dashboard(){

        $totalWebView = TotalWebVisitor::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $totalContentView = TotalContentVisitor::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $totalView = $totalWebView + $totalContentView;


        $uniqueWebView = UniqueWebVisitor::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $uniqueDownloadView = UniqueContentVisitor::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $uniqueView =  $uniqueWebView + $uniqueDownloadView ;
        $totalItem =  MovieModel::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $download =  DownloadContent::whereMonth('created_at', Carbon::now()->month)->get()->count();


        $totalDownload = DownloadContent::all()->count();
        $totalWeb = TotalWebVisitor::all()->count();
        $totalContent = TotalContentVisitor::all()->count();
        $totalViews = $totalWeb + $totalContent;


        $views = TotalContentVisitor::select('movie_id', DB::raw('COUNT(*) as movie_count'))
        ->groupBy('movie_id')
        ->orderBy('movie_count', 'DESC')
        ->take(10)->get();

        $contentDownload = DownloadContent::select('movie_id', DB::raw('COUNT(*) as movie_count'))
        ->groupBy('movie_id')
        ->orderBy('movie_count', 'DESC')
        ->take(10)->get();



        if(Auth::user()->roll == 'admin'){
            return view('backend.index',[
                'totalView'=>$totalView,
                'uniqueView'=>$uniqueView,
                'totalItem'=>$totalItem,
                'download'=>$download,
                'views'=>$views,
                'contentDownload'=>$contentDownload,
                'totalDownload'=>$totalDownload,
                'totalViews'=>$totalViews,
            ]);
        }
        else{
            return redirect()->route('profile');
        }

    }

    function unauthorized(){
        return view('backend.unauthorized');
    }

    function activityLog(){
    if(Auth::user()->roll == 'admin'){
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
            'activities'=>$activities,
            'logs'=>$logs,
        ]);
    }
    else{
        return redirect()->route('profile');
    }
    }


}
