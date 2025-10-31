@extends('layouts.backend')
@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Permission</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th style="width: 5%">Role</th>
                                <th>Permission</th>
                                <th style="width: 15%">Action</th>
                            </tr>

                            @forelse ($roles as $role)
                            <tr>
                                <td>{{$role->name}}</td>
                                <td>
                                    @foreach ($role->getPermissionNames() as $permission)
                                        <span class="badge bg-primary m-1">{{$permission}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('role.edit', $role->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{route('role.delete', $role->id)}}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    <h3 class="text-center">Not Available Any Permission</h3>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3>User Role</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th style="width: 5%">User</th>
                                <th>Role</th>
                                <th style="width: 15%">Action</th>
                            </tr>

                            @forelse ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary m-1">{{$role}}</span>
                                        @empty
                                        <span class="badge bg-light text-dark m-1">No Role</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{route('role.remove', $user->id)}}" class="btn btn-danger btn-sm">Remove Role</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    <h3 class="text-center">Not Available Any Permission</h3>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
       <div class="row">
        <!--<div class="col-lg-12 mb-3">-->
        <!--    <div class="card">-->
        <!--        <div class="card-header">-->
        <!--            <h3>Add Permission</h3>-->
        <!--        </div>-->
        <!--        <div class="card-body">-->
        <!--            <form action="{{route('permission.store')}}" method="POST">-->
        <!--                @csrf-->
        <!--                <div class="form-group">-->
        <!--                    <label for="permission_name">Permission</label>-->
        <!--                    <input type="text" name="permission_name" id="permission_name" class="form-control">-->
        <!--                    @error('permission_name')-->
        <!--                        <small class="text-danger">{{$message}}</small>-->
        <!--                    @enderror-->
        <!--                </div>-->

        <!--                <div class="form-group mt-3">-->
        <!--                    <button type="submit" class="btn btn-primary w-100"> Submit</button>-->
        <!--                </div>-->

        <!--            </form>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
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

        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Assign Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('role.assign')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role_name">Select User</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role">Select Role</label>
                            <select name="role" id="role" class="form-control">
                                @foreach ($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
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
