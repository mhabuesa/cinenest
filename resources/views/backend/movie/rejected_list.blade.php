@extends('layouts.backend')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex justify-content-center">
                <h4 class="me-2">Movies</h4>
            </div>
            <a href="{{route('movie.add')}}" class="btn btn-primary"> Add Movies  &nbsp;  <i class="fa-solid fa-plus"></i></a>
        </div>
        <div class="card-body table-responsive">

           <table id="example" class="display table-bordered" style="width:100%">
                <thead>
                    <tr style="text-center">
                        <th>SL</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Industry</th>
                        <th>Release Year</th>
                        <th>Reject Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($movies as $sl=> $movie )
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>
                            <img width="50" src="{{asset('uploads')}}/cover/{{$movie->cover}}" alt="">
                        </td>
                        <td>{{$movie->title}}</td>
                        <td>{{$movie->industry}}</td>
                        <td>{{$movie->release_year}}</td>
                        <td>
                            <span class="fw-bold">{{$movie->reject_reason}}</span>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{route('movie.edit',$movie->id)}}"> Edit</a>
                            <a class="btn btn-success" href="{{route('approval.req', $movie->id)}}"> Approval Request </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('script')
@if (session('category_store'))
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
    title: "{{session('category_store')}}"
    });
</script>
@endif

@if (session('error'))
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
    title: "{{session('error')}}"
    });
</script>
@endif

@error('category')
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
    title: "Category Already Added"
    });
</script>
@enderror

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








