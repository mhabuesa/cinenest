@extends('layouts.backend')
@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="">
                <h4 class="me-2">Movies</h4>
                <span class="">Total: {{$movies->count()}}</span>
            </div>
        </div>
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead>
                    <tr style="text-center">
                        <th>SL</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Industry</th>
                        <th>Category</th>
                        <th>Release Year</th>
                        <th>Oscar</th>
                        <th>Supper Hit</th>
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
                            <label class="form-check-label" for="oscar{{ $movie->id }}">
                                <div class="btn btn-{{ $movie->oscar == '1' ? 'success' : 'primary' }} btn-sm" id="oscar-btn-{{ $movie->id }}">
                                    <input class="form-check-input change-status" type="checkbox" {{ $movie->oscar == '1' ? 'checked' : '' }} data-id="{{ $movie->id }}" id="oscar{{ $movie->id }}">
                                    Oscar Win
                                </div>
                            </label>
                        </td>
                        <td>
                            <label class="form-check-label" for="featured{{ $movie->id }}">
                                <div class="btn btn-{{ $movie->supper_hit == '1' ? 'success' : 'primary' }} btn-sm" id="supper-btn-{{ $movie->id }}">
                                    <input class="form-check-input change-featured" type="checkbox" {{ $movie->supper_hit == '1' ? 'checked' : '' }} data-id="{{ $movie->id }}" id="featured{{ $movie->id }}">
                                    Supper Hit
                                </div>
                            </label>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.change-status').on('change', function(){
            var rowId = $(this).data('id');
            var newStatus = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('oscar.status') }}',
                type: 'POST',
                data: {
                    id: rowId,
                    status: newStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                if(response.success) {
                    $('#row-' + rowId + ' td:nth-child(2)').text(newStatus);
                    var btn = $('#oscar-btn-' + rowId);
                    if (newStatus == 1) {
                        btn.removeClass('btn-primary').addClass('btn-success');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-primary');
                    }
                    showToast('success', response.message);
                } else {
                    showToast('error', response.message);
                }
            },
                error: function(){
                    showToast('error', 'An error occurred while updating the Oscar status.');
                }
            });
        });



        $('.change-featured').on('change', function(){
            var rowId = $(this).data('id');
            var newStatus = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('supper.status') }}', // Adjust the route accordingly
                type: 'POST',
                data: {
                    id: rowId,
                    status: newStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                if(response.success) {
                    $('#row-' + rowId + ' td:nth-child(3)').text(newStatus);
                    var btn = $('#supper-btn-' + rowId);
                    if (newStatus == 1) {
                        btn.removeClass('btn-primary').addClass('btn-success');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-primary');
                    }
                    showToast('success', response.message);
                } else {
                    showToast('error', response.message);
                }
                },

                error: function(){
                    showToast('error', 'An error occurred while updating the Featured status.');
                }
            });
        });

        function showToast(icon, title) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: icon,
                title: title
            });
        }
    });
    </script>


@endpush
