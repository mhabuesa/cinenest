
<!-- catalog -->
<div class="catalog">
    <div class="container">
        <div class="row row--grid">

            @foreach ($oscars as $oscar  )

            <!-- card -->
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{route('movie.details', $oscar->url)}}">
                <div class="card">
                    <div class="card__cover">
                        <img src="{{asset('uploads')}}/cover/{{$oscar->cover}}" alt="">
                        <a href="{{route('movie.details', $oscar->url)}}" class="card__play">
                            <i class="icon ion-ios-play"></i>
                        </a>
                        @if ($oscar->rating)
                        <span class="card__rate card__rate--green">{{$oscar->rating}}</span>
                        @endif
                        @if ($oscar->version)
                        <span class="version card__rate--green">{{$oscar->version}}</span>
                        @endif
                    </div>
                    <div class="card__content">
                        <h3 class="card__title"><a href="{{route('movie.details', $oscar->url)}}">{{$oscar->title}}</a></h3>
                        <span class="card__category">
                            @foreach (App\Models\InventoryModel::where('movie_id', $oscar->id)->get() as $category )
                            <a href="{{route('category.view',$category->slug)}}">{{$category->category}}</a>
                            @endforeach

                        </span>
                    </div>
                </div>
                </a>
            </div>
            <!-- end card -->

            @endforeach


        </div>

        <div class="row">
            <!-- paginator -->
                <div class="col-12">
                    {{ $oscars->links('vendor.livewire.custom') }}
                </div>
            <!-- end paginator -->
        </div>
    </div>
</div>
<!-- end catalog -->
