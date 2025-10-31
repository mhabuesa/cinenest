<div class="row row--grid">

    @foreach ($movies as $movie )
        <!-- card -->
    <div class="col-6 col-sm-4 col-md-3 col-xl-2">
        <a href="{{route('movie.details',$movie->url)}}">
            <div class="card">
                <div class="card__cover">
                    <img src="{{asset('uploads')}}/cover/{{$movie->cover}}" alt="">
                    <a href="{{route('movie.details',$movie->url)}}" class="card__play">
                        <i class="icon ion-ios-play"></i>
                    </a>
                    @if ($movie->rating)
                    <span class="card__rate card__rate--{{$movie->rating >= 7 ? 'green' : ($movie->rating >= 5 ? 'yellow' : 'red')}}">{{$movie->rating}}</span>
                    @endif
                    @if ($movie->version)
                    <span class="version card__rate--green">{{$movie->version}}</span>
                    @endif

                    @auth('visitor')
                        <a wire:click="favorite({{ $movie->id }})"" class="item__favorite {{ App\Models\FavoriteModel::where('movie_id', $movie->id)->where('visitor_id', Auth::guard('visitor')->user()->id)->first() ? 'favorite_active' : '' }}" >
                            <i class="fa-duotone fa-bookmark"></i>
                        </a>
                    @else
                        <a href="{{route('signin')}}" class="item__favorite"><i class="fa-duotone fa-bookmark"></i></a>
                    @endauth

                </div>
                <div class="card__content">
                    <h3 class="card__title"><a href="{{route('movie.details',$movie->url)}}">{{$movie->title}}</a></h3>
                    <span class="card__category">
                        @foreach (App\Models\InventoryModel::where('movie_id', $movie->id )->get() as $category )
                        <a href="{{route('category.view',$category->slug)}}">{{$category->category}}</a>
                        @endforeach
                    </span>
                </div>
            </div>
        </a>
    </div>
    <!-- end card -->
    @endforeach



    <!-- paginator -->
<div class="col-12">
    {{ $movies->links('vendor.livewire.custom') }}
</div>
<!-- end paginator -->

</div>
