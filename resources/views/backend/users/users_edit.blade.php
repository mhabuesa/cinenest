@extends('layouts.backend')
@section('content')
    <div class="col-lg-6 m-auto">
        <form action="{{ route('users.update',$user->id) }}" method="POST">
            @csrf
            <div class="card mb-4">
                <h5 class="card-header">Edit User</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">

                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-user"></i></span>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Name..." required aria-label="Name..." aria-describedby="basic-addon-search31" />
                </div>

                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-mail"></i></span>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Email..." aria-label="Email..." required aria-describedby="basic-addon-search31" />
                </div>

                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="basic-default-password32" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password" />
                    <span class="input-group-text cursor-pointer" id="basic-default-password"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>

                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-key"></i></span>
                    <select class="form-control" name="roll" id="">
                        <option {{$user->roll == 'admin'?'selected':''}} value="admin">Admin</option>
                        <option {{$user->roll == 'moderator'?'selected':''}} value="moderator">Moderator</option>
                        <option {{$user->roll == 'marketer'?'selected':''}} value="marketer">Marketer</option>
                    </select>
                </div>


                <div class="mt-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>


                </div>
            </div>
        </form>
    </div>
@endsection


@push('script')
@error('email')
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
    icon: "error",
    title: "User Email Already Exists"
    });
</script>
@enderror

@if (session('update'))
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
    title: "{{session('update')}}"
    });
</script>
@endif
@endpush
