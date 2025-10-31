@extends('layouts.backend')
@section('content')
   <div class="row">
    @can('todo_create')
    <div class="col-lg-12">
        <div class="card-body demo-vertical-spacing demo-only-element">
            <form action="{{ route('todo.store') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="row">
                        <h5>Add Todo</h5>
                        <div class="col-lg-9 mt-2">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="title"><i class="ti ti-user"></i></span>
                                <input type="text" name="title" class="form-control" placeholder="Title..." required aria-label="Title..." aria-describedby="title" />
                            </div>
                        </div>
                        <div class="col-lg-2 mt-2">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="release_year"><i class="ti ti-calendar"></i></span>
                                <input type="text" name="release_year" class="form-control" placeholder="Release Year..." required aria-label="Release Year..." aria-describedby="release_year" />
                            </div>
                        </div>
                        <div class="col-lg-1 mt-2">
                            <div class="input-group input-group-merge">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    @endcan
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="example" class="table table-bordered">
                    <thead>
                    <tr class="table-dark">
                        <th class="text-light">SL</th>
                        <th class="text-light">Title</th>
                        <th class="text-light">Release Year</th>
                        <th class="text-light">Status</th>
                        <th class="text-light">User</th>
                        @can('todo_delete')
                        <th class="text-light">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($todos as $sl=> $todo )
                        <tr class="text-capitalize">
                            <td>{{$sl+1}}</td>
                            <td>{{$todo->title}}</td>
                            <td>{{$todo->release_year}}</td>

                            <td>
                                @if ($todo->status == 0)
                                    <span class="btn btn-primary btn-sm" style="cursor: default"> Unassigned</span>
                                    <a href="{{route('todo.assign', $todo->id)}}" class="btn btn-success btn-sm"> <i class="fa-solid fa-plus"></i></a>
                                @elseif ($todo->status == 1)
                                    <span class="btn btn-danger btn-sm"> Assigned</span>
                                    @if ($todo->user_id == Auth::user()->id)
                                        <a href="{{route('todo.complete', $todo->id)}}" class="btn btn-danger btn-sm"> <i class="fa-solid fa-check"></i></a>
                                    @endif
                                @elseif ($todo->status == 2)
                                <span class="btn btn-success btn-sm" style="cursor: default"> Completed</span>
                                @endif
                            </td>
                            <td>
                                @if ($todo->user_id)
                                    {{$todo->user->name}}
                                @endif
                            </td>

                            @can('todo_delete')
                            <td>
                                <a href="{{route('todo.delete', $todo->id)}}" class="btn btn-danger btn-sm"> <i class="fa-solid fa-trash"></i></a>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
