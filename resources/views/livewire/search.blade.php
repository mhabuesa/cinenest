<!-- catalog -->
<div class="catalog">
    <div class="container">
        <div class="row row--grid">

            @forelse ($movies as $movie )

            <!-- card -->
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{route('movie.details', $movie->url)}}">
                <div class="card">
                    <div class="card__cover">
                        <img loading="lazy" src="{{asset('uploads')}}/cover/{{$movie->cover}}" alt="">
                        <a href="{{route('movie.details', $movie->url)}}" class="card__play">
                            <i class="icon ion-ios-play"></i>
                        </a>
                        @if ($movie->rating)
                        <span class="card__rate card__rate--green">{{$movie->rating}}</span>
                        @endif
                        @if ($movie->version)
                        <span class="version card__rate--green">{{$movie->version}}</span>
                        @endif
                    </div>
                    <div class="card__content">
                        <h3 class="card__title"><a href="{{route('movie.details', $movie->url)}}">{{$movie->title}}</a></h3>
                        <span class="card__category">
                            @foreach (App\Models\InventoryModel::where('movie_id', $movie->id)->get() as $category )
                            <a href="{{route('category.view',$category->slug)}}">{{$category->category}}</a>
                            @endforeach
                        </span>
                    </div>
                </div>
                </a>
            </div>
            <!-- end card -->

            @empty
            <!-- card -->
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <h3 class="text_center">No Movies Found</h3>
            </div>
            <!-- end card -->

            @endforelse
        </div>
        <div class="row">
            <!-- paginator -->
                <div class="col-12">
                    {{ $movies->links('vendor.livewire.custom') }}
                </div>
            <!-- end paginator -->
        </div>

    </div>
</div>
<!-- end catalog -->
