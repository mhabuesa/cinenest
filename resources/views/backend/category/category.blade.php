@extends('layouts.backend')
@section('content')


<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Categories</h4>
            {{-- <a href="#addNewCCModal" data-bs-toggle="modal"><h4 class="btn btn-primary">Add Category  &nbsp;<i class="fa-solid fa-plus"></i></h4></a> --}}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCategory"> Add Category  &nbsp;  <i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="card-body table-responsive">

            <table id="example" class="display table-bordered" style="width:100%">
                <thead>
                    <tr style="text-center">
                        <th>SL</th>
                        <th>Category</th>
                        <th>Movies</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($categories as $sl=> $category )
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$category->category}}</td>
                        <td>{{App\Models\InventoryModel::where('category',$category->category)->count()}}</td>
                        <td>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCategory{{$category->id}}"> <i class="fa-solid fa-pencil" style="color: #ffff;"></i></a>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_delete{{$category->id}}"> <i class="fa-solid fa-trash" style="color: #ff0000;"></i> </a>
                        </td>
                    </tr>

                    <!-- Category Delete Modal -->
                        <div class="modal fade" id="category_delete{{$category->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3 class="mb-2">Are you Sure?</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-danger me-sm-3 me-1" href="{{route('category.delete',$category->id)}}">Delete</a>
                                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--/ Category Delete Modal -->

                        <!-- Edit Category Modal -->
                            <div class="modal fade" id="editCategory{{$category->id}}" tabindex="-1" aria-hidden="true" >
                                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Update Category</h3>
                                    </div>
                                    <form id="addNewCCForm" class="row g-3" action="{{route('category.update',$category->id)}}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label w-100" for="modalAddCard">Category Name</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCard" name="category" class="form-control credit-card-mask" type="text" placeholder="Category Name" aria-describedby="modalAddCard2" required value="{{$category->category}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <!--/ Edit Category Modal -->
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>






    <!-- Add Category Modal -->
        <div class="modal fade" id="addNewCategory" tabindex="-1" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Add New Category</h3>
                </div>
                <form id="addNewCCForm" class="row g-3" action="{{route('category.store')}}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label class="form-label w-100" for="modalAddCard">Category Name</label>
                        <div class="input-group input-group-merge">
                            <input id="modalAddCard" name="category" class="form-control credit-card-mask" type="text" placeholder="Category Name" aria-describedby="modalAddCard2" required/>
                            <span class="input-group-text cursor-pointer p-1" id="modalAddCard2"><span class="card-type"></span></span>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    <!--/ Add Category Modal -->




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








