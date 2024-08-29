@extends('layouts.backend')
@section('content')
   <div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <tr class="table-dark">
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roll</th>

                        @if (Auth::user()->roll == 'admin')
                            <th>Action</th>
                        @endif
                    </tr>

                    @foreach ($users as $sl=> $user )
                        <tr class="text-capitalize">
                            <td>{{$sl+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->roll}}</td>
                            @if (Auth::user()->roll == 'admin')
                                <td>
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info">Edit</a>
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_delete{{$user->id}}"> <i class="fa-solid fa-trash" style="color: #ff0000;"></i> </a>
                                </td>
                            @endif
                        </tr>


                        <!-- Category Delete Modal -->
                        <div class="modal fade" id="category_delete{{$user->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3 class="mb-2">Are you Sure?</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-danger me-sm-3 me-1" href="{{route('users.delete',$user->id)}}">Delete</a>
                                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--/ Category Delete Modal -->
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    @if (Auth::user()->roll == 'admin')
    <div class="col-lg-4">
        <div class="card-body demo-vertical-spacing demo-only-element">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <h5 class="card-header">Add User</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">

                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Name..." required aria-label="Name..." aria-describedby="basic-addon-search31" />
                    </div>

                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-mail"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email..." aria-label="Email..." required aria-describedby="basic-addon-search31" />
                    </div>

                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-lock"></i></span>
                        <input type="password" name="password" required class="form-control" id="basic-default-password32" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password" />
                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>

                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-key"></i></span>
                        <select class="form-control" name="roll" id="roleSelect">
                            <option value="admin">Admin</option>
                            <option value="moderator" class="moderator">Moderator</option>
                            <option value="marketer">Marketer</option>
                        </select>
                    </div>

                    <div class="input-group input-group-merge rate" style="display:none;">
                        <span class="input-group-text" id="basic-addon-search31"><i class="fa-solid fa-dollar-sign"></i></span>
                        <input type="number" name="rate" class="form-control" placeholder="Rate..."/>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection

@push('script')
@if (session('created'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('created')}}"
    });
</script>
@endif

@if (session('delete'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('delete')}}"
    });
</script>
@endif
<script>
    $(document).ready(function(){
        $('#roleSelect').on('change', function() {
            if ($(this).val() === 'moderator') {
                $('.rate').show();
            } else {
                $('.rate').hide();
            }
        });
    });
</script>
@endpush
