@extends('layouts.backend')
@include('backend.movie.add_movie_headerscript')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Add New Movie</h3>
        </div>
        <div class="card-body">
            <form action="{{route('movie.store')}}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row row--form">
                    <div class="col-12 col-md-5 form__cover">
                        <div class="row row--form">
                            <div class="col-12 col-sm-6 col-md-12 mb-3">
                                <div class="form__img">
                                    <label for="form__img-upload">Upload cover (270 x 400)</label>
                                    <input id="form__img-upload" name="cover" type="file" accept=".png, .jpg, .jpeg">
                                    <img id="form__img" src="#" alt=" ">
                                </div>
                                @error('cover')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-7 form__content">
                        <div class="row row--form">
                            <div class="col-12">
                                <input type="text" name="title" class="form-control" placeholder="Title" required value="{{old('title')}}">
                            </div>

                            <div class="col-12 mt-2">
                                <textarea name="desp" class="form-control" rows="4" placeholder="Description" required>{{old('desp')}}</textarea>
                            </div>

                            <div class="col-12 mt-2">
                                <textarea name="story_line" class="form-control" rows="2" placeholder="Story Line" required>{{old('story_line')}}</textarea>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mt-2">
                                <input type="text" name="director" class="form-control" placeholder="Director" required value="{{old('director')}}">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mt-2">
                                <input type="text" name="release_year" class="form-control" placeholder="Release year" required value="{{old('release_year')}}">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mt-2">
                                <input type="text" name="running_time" class="form-control" placeholder="Running timed in minutes" required value="{{old('running_time')}}">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mt-2">
                                <input type="text" name="industry" class="form-control" placeholder="Industry" value="{{old('industry')}}">
                            </div>

                            <div class="col-12 col-sm-12 col-lg-4 mt-2">
                                <input type="text" name="country" class="form-control" placeholder="Enter Country" value="{{old('country')}}" required>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-4 mt-2">
                                <input type="text" name="language" class="form-control" placeholder="Enter Language" value="{{old('language')}}" required>
                            </div>

                            <div class="col-12 col-lg-12 mt-2">
                                <select id="select-gear" class="demo-default" name="category[]" multiple placeholder="Select Category..." >
                                    <option value="">Select Category...</option>
                                    <optgroup label="">
                                        @foreach ($categories as $category )
                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                        @endforeach

                                    </optgroup>

                                  </select>
                                @error('category')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6 mt-2">
                                <input type="text" name="rating" class="form-control" placeholder="Rating Point" value="{{old('rating')}}" >
                            </div>

                            <div class="col-12 col-sm-12 col-lg-6 mt-2">
                                <input type="text" class="form-control" name="version" placeholder="Video Quality Version" value="{{old('version')}}">
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row--form">
                            <div class="col-12">

                                <div class="upload__box">
                                    <div class="upload__btn-box">
                                      <label class="upload__btn">
                                        <p>Upload images</p>
                                        <input type="file" multiple="" name="screen_short[]" data-max_length="20" class="upload__inputfile">
                                      </label>
                                    </div>
                                    @error('screen_short')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                    <div class="upload__img-wrap"></div>
                                  </div>


                            </div>

                            <div class="col-12 mt-2">
                                <input type="text" name="keyword" required placeholder="Keyword Here"  id="input-tags" value="" />
                            </div>

                            <div class="col-12 mt-2">
                                <input type="text" class="form-control" name="url" placeholder="Create Movie URL" required value="{{old('url')}}">
                            </div>

                            <div class="col-12 mt-3 mb-4">
                                <label for="caption">Caption & Download Link</label>
                                <div id="container">
                                    <!-- Existing content -->
                                    <div class="d-flex justify-content-between mt-1">
                                        <input type="text" class="form-control mx-1" name="caption[]" placeholder="Add Download Caption" required>
                                        <input type="text" class="form-control mx-1" name="down_link[]" placeholder="Add Download link" required>
                                        <a class="btn btn-danger btn-sm mx-1" id="add"><i class="fa-solid fa-plus text-white"></i></a>
                                    </div>

                                </div>
                                    @error('caption')
                                        <small class="btn btn-danger">{{$message}}</small>
                                    @enderror
                                    @error('down_link')
                                        <small class="btn btn-danger">{{$message}}</small>
                                    @enderror

                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">publish</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@include('backend.movie.add_movie_footerscript')
