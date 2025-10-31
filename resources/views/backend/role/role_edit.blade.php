@extends('layouts.backend')
@section('content')
    <div class="row">
        <div class="col-lg-4 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Permission</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('permission.update', $role->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" name="role_name" disabled id="role_name" class="form-control" value="{{$role->name}}">
                        </div>
                        <div class="form-group">
                            <label for="role_name">Permision</label>

                            @foreach ($permissions as $permission)
                                <div class="form-check mx-1">
                                    <input {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}} class="form-check-input" type="checkbox" name="permission[]" id="{{$permission->id}}" value="{{$permission->name}}">
                                    <label class="form-check-label" for="{{$permission->id}}">
                                    {{$permission->name}}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                        <div class="form-group mt-3 d-flex justify-content-between">
                            <a href="{{route('role')}}" type="button" class="btn btn-warning mx-2">Back</a>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
