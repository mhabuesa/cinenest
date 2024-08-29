@extends('layouts.backend')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex justify-content-center">
                <h4 class="me-2">Movies</h4>  <span class="m-auto">Total: {{$movies->count()}}</span>
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
                        <th>Category</th>
                        <th>Release Year</th>
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
                        <td>
                            @foreach (App\Models\InventoryModel::where('movie_id', $movie->id)->get() as $category )
                                <a class="me-2 text-info" href="#">{{$category->category}}</a>
                            @endforeach
                        </td>
                        <td>{{$movie->release_year}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('movie.edit',$movie->id)}}"> <i class="fa-solid fa-pencil" style="color: #ffff;"></i></a>
                            @if (Auth::user()->roll == 'admin')
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#movie_delete{{$movie->id}}"> <i class="fa-solid fa-trash" style="color: #ff0000;"></i> </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Category Delete Modal -->
                        <div class="modal fade" id="movie_delete{{$movie->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3 class="mb-2">Are you Sure?</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-danger me-sm-3 me-1" href="{{route('movie.delete',$movie->id)}}">Delete</a>
                                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--/ Category Delete Modal -->
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








