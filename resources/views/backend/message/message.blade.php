@extends('layouts.backend')
@section('content')
    <div class="col-lg-10 m-auto">
        <div class="card table-responsive">
            <div class="card-header">
                <h3>All Mesages</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>

                    @forelse ($messages as $sl=> $message )
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$message->name}}</td>
                            <td>{{$message->subject}}</td>
                            <td>{{$message->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('message.read',$message->id)}}" class="btn btn-{{$message->status == 0?'warning':'success'}}">{{$message->status == 0?'Unread':'Read'}}</a>
                            </td>
                        </tr>
                    @empty

                    @endforelse

                </table>
            </div>
        </div>
    </div>
@endsection
