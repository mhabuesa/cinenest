@extends('layouts.backend')
@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h3>Permission</h3>
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
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
       <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Add Permission</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('permission.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="permission_name">Permission</label>
                            <input type="text" name="permission_name" id="permission_name" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100"> Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Add Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('role.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role_name">Role</label>
                            <input type="text" name="role_name" id="role_name" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label for="role_name">Permission</label>
                            <div class="permission">

                                @foreach ($permissions as $permission)
                                <div class="form-check mx-1">
                                    <input class="form-check-input" type="checkbox" name="permission[]" id="{{$permission->id}}" value="{{$permission->name}}">
                                    <label class="form-check-label" for="{{$permission->id}}">
                                    {{$permission->name}}
                                    </label>
                                </div>
                                @endforeach

                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100"> Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
</div>
@endsection
