@extends('layouts.backend')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-dark">All Comments</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Visitor</th>
                            <th>Comment</th>
                            <th>Reply</th>
                            <th width="50">Action</th>
                        </tr>
                        @foreach ($comments as $sl => $comment)
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $comment->visitor->name }}</td>
                                <td>{{ $comment->comment }}</td>
                                @if($comment->replies->isNotEmpty())
                                    <td>
                                        @foreach($comment->replies as $reply)
                                            {{ $reply->reply }}
                                        @endforeach
                                    </td>
                                @else
                                    <td>No replies</td>
                                @endif
                                {{-- @php
                                    $replies = App\Models\CommentReplyModel::where('comment_id', $comment->id)->get();
                                @endphp
                                <td>
                                    @foreach($replies as $reply)
                                    {{ $reply->reply }}
                                    @endforeach
                                <td> --}}
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comment_{{$comment->id}}"> Write </button>
                                </td>
                            </tr>

                            <!-- Add New Credit Card Modal -->
                            <div class="modal fade" id="comment_{{$comment->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                    <div class="modal-content p-3 p-md-5">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-4">
                                                <h3 class="mb-2 text-dark">Send a Reply</h3>
                                            </div>
                                            <form action="{{route('reply.store',$comment->id)}}" class="row g-3" method="POST">
                                                @csrf
                                                <div class="col-12">
                                                    <label class="form-label w-100" for="modalAddCard">Comment</label>
                                                    <div class="input-group input-group-merge">
                                                        <textarea class="form-control" name="" id="" rows="5" disabled>{{$comment->comment}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label w-100" for="modalAddCard">Reply</label>
                                                    <div class="input-group input-group-merge">
                                                        <textarea class="form-control" name="reply" id="" rows="5" required ></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12col-md-6 text-center mt-3">
                                                    <button type="submit"
                                                        class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                    <button type="reset" class="btn btn-label-secondary btn-reset"
                                                        data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Add New Credit Card Modal -->
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')

@if (session('success'))
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
    title: "{{session('success')}}"
    });
</script>
@endif


@endpush
