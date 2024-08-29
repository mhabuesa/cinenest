@extends('layouts.backend')
@section('content')
    <div class="col-lg-10 m-auto">
        <div class="card table-responsive">
            <div class="card-header">
                <h3>Message Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr class="table-dark">
                        <th>Date</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                    <tr>
                        <td>{{$message->created_at->format('h:i A')}} - {{$message->created_at->format('d-M-Y')}}</td>
                        <td>{{$message->name}}</td>
                        <td>{{$message->subject}}</td>
                        <td>{{$message->email}}</td>
                        <td>
                            <p>{{$message->message}}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
