@extends('layouts.backend')
@section('content')
<div class="row">

    <div class="col-lg-4 mt-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <p>Items added this month</p>
                <div class=" mt-3 d-flex justify-content-between">
                    <p>{{$totalItem}}</p>
                    <span><i class="fa-solid fa-film fa-xl" style="color: #FFD43B;"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <p>Items Download this month</p>
                <div class=" mt-3 d-flex justify-content-between">
                    <p>{{$download}}</p>
                    <span><i class="fa-regular fa-circle-down fa-xl" style="color: #FFD43B;"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <p>Total Download</p>
                <div class=" mt-3 d-flex justify-content-between">
                    <p>{{$totalDownload}}</p>
                    <span><i class="fa-regular fa-circle-down fa-xl" style="color: #FFD43B;"></i></span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-10 mt-4 m-auto">
        <div class="card">
            <div class="card-header bg_dark text-white">
                <div class=" mt-3 d-flex justify-content-between">
                    <p>Top Downloaded Movie</p>
                    <span><i class="fa-regular fa-circle-down fa-xl" style="color: #FFD43B;"></i></span>
                </div>
            </div>
            <div class="card-body table-responsive" style="padding: 0; border-radius: 0 0 9px 9px;" >
                <table class="table table-bordered" >
                    <tr class="table-dark">
                        <th>SL</th>
                        <th>Name</th>
                        <th style="width: 30px">Download</th>
                    </tr>
                    @foreach ($contentDownload as $sl=> $download )
                    @php
                        $top = App\Models\MovieModel::where('id', $download->movie_id)->first()
                    @endphp

                    <tr class="bg_gray">
                        <td>{{$sl+1}}</td>
                        <td>{{$top->title}}</td>
                        <td style="width: 30px">{{$download->movie_count}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


</div>
@endsection
