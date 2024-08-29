@extends('layouts.backend')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Movie Poster List</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th style="width: 5%">SL</th>
                            <th>Name</th>
                            <th style="width: 15%">Designation</th>
                            <th>Movie Uploads</th>
                            <th>Details</th>
                        </tr>
                    @foreach ($activities as $key=> $activity )
                        <tr class="text-capitalize">
                            <td>{{$key+1}}</td>
                            <td>{{$activity->user->name}}</td>
                            <td>{{$activity->user->roll}}</td>
                            <td>{{$activity->movie_count}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">{{$activity->user->id}}View</button>
                            </td>
                        </tr>
                        <div class="modal fade" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <div class="m-auto">
                                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Movie Upload History</h5>
                                  </div>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tbl">
                                                <div class="t_header d-flex">
                                                    <div class="t_h sl">SL</div>
                                                    <div class="t_h title">Title</div>
                                                    <div class="t_h name">IP</div>
                                                    <div class="t_h date">Date</div>
                                                </div>

                                                @foreach (App\Models\ActivityLog::where('user_id', $activity->user->id)->where('log', null)->get() as $key=> $info )
                                                <div class="t_body d-flex">
                                                    <div class="t_d sl">{{$key+1}}</div>
                                                    <div class="t_d title"><a href="{{route('movie.details', $info->movie->url)}}" target="_blank">{{$info->movie->title}}</a></div>
                                                    <div class="t_d name">{{$info->ip}}</div>
                                                    <div class="t_d date">{{ $info->created_at->format('d/M/Y') }}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>Activity</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th style="width: 5%">SL</th>
                            <th>Name</th>
                            <th style="width: 15%">Designation</th>
                            <th>Log</th>
                        </tr>
                    @foreach ($logs as $key=> $activity )
                        <tr class="text-capitalize">
                            <td>{{$key+1}}</td>
                            <td>{{$activity->user->name}}</td>
                            <td>{{$activity->user->roll}}</td>
                            <td>{{$activity->log}}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
