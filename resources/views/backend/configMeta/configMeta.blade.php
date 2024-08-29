@extends('layouts.backend')
@include('backend.movie.add_movie_headerscript')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Config Meta Update</h4>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{route('configMeta.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="owner">Site Owner Name</label>
                            <input type="text" name="owner" id="owner" class="form-control" value="{{$meta->owner}}">
                            @error('owner')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label for="type">Site Type</label>
                            <input type="text" name="type" id="type" class="form-control" value="{{$meta->type}}">
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label for="site_name">Site Name</label>
                            <input type="text" name="site_name" id="site_name" class="form-control" value="{{$meta->site_name}}">
                            @error('site_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label for="verify">Google Site Verification</label>
                            <input type="text" name="verify" id="verify" class="form-control" value="{{$meta->verify}}">
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label for="local">Local</label>
                            <input type="text" name="local" id="local" class="form-control" value="{{$meta->local}}">
                            @error('local')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label for="image">Image</label>
                            <input type="file" name="image" accept="jpg, png" id="image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-4 mt-3 text-center">
                            <label for="image">Preview</label> <br>
                            <img src="{{asset('uploads')}}/metaConfig/{{$meta->image}}" id="blah" alt=""  height="70">
                        </div>

                        <div class="row">
                            <div class="mb-2">
                                <label for="title" >Title</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{$meta->title}}">
                            </div>

                            <div class="mb-2">
                                <label for="desp">Description</label>
                                <textarea name="desp" id="desp" cols="30" rows="3" class="form-control">{{$meta->desp}}</textarea>
                            </div>

                            <div class="mb-2">
                                <label for="desp">Keyword</label>
                                <input type="text" name="keyword" required  id="input-tags" value="{{$meta->keyword}}" />
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('backend.movie.add_movie_footerscript')
@push('script')

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


