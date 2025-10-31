
<!-- catalog -->
<div class="catalog">
    <div class="container">
        <div class="row row--grid">

            @forelse ($movies as $movie)
                @php
                    // Fetch related movie details based on the value you have
                    $relatedMovie = App\Models\MovieModel::where('status', 1)->where('id', $movie->movie_id)->first();
                @endphp

                @if ($relatedMovie)
                    <!-- card -->
                    <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                        <a href="{{ route('movie.details', $relatedMovie->url) }}">
                            <div class="card">
                                <div class="card__cover">
                                    <img src="{{ asset('uploads/cover/' . $relatedMovie->cover) }}" alt="">
                                    <a href="{{ route('movie.details', $relatedMovie->url) }}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                    @if ($relatedMovie->rating)
                                        <span class="card__rate card__rate--green">{{ $relatedMovie->rating }}</span>
                                    @endif
                                    @if ($relatedMovie->version)
                                        <span class="version card__rate--green">{{ $relatedMovie->version }}</span>
                                    @endif
                                </div>
                                <div class="card__content">
                                    <h3 class="card__title">
                                        <a href="{{ route('movie.details', $relatedMovie->url) }}">{{ $relatedMovie->title }}</a>
                                    </h3>
                                    <span class="card__category">
                                        @foreach (App\Models\InventoryModel::where('movie_id', $movie->movie_id)->get() as $category)
                                            <a href="{{ route('category.view', $category->slug) }}">{{ $category->category }}</a>
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- end card -->
                @endif
            @empty
                <!-- card -->
                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                    <h3 class="text_center">There is no content in this category</h3>
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
