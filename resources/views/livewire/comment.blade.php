<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- content tabs -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                    <div class="row">
                        <!-- comments -->
                        <div class="col-12">
                            <div class="comments">
                                <ul class="comments__list">
                                    <div class="comment_content mb_6">
                                        @foreach ($comments as $comment )

                                        <li class="comments__item">
                                            <div class="comments__autor">
                                                <span class="comments__name">{{$comment->visitor->name}}</span>
                                                <span class="comments__time">{{$comment->created_at->diffForHumans()}}</span>
                                            </div>
                                            <p class="comments__text">{{$comment->comment}}</p>
                                            <div class="comments__actions">
                                                <div class="comments__rate">
                                                    @auth('visitor')
                                                    <a wire:click="like({{ $comment->id }})"><i class="icon ion-md-thumbs-up"></i>{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('like', 1)->count()}}</a>

                                                    <a wire:click="dislike({{ $comment->id }})">{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('dislike', 1)->count()}}<i class="icon ion-md-thumbs-down"></i></a>
                                                    @else
                                                    <a href="{{route('signin')}}"><i class="icon ion-md-thumbs-up"></i>{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('like', 1)->count()}}</a>

                                                    <a href="{{route('signin')}}">{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('dislike', 1)->count()}}<i class="icon ion-md-thumbs-down"></i></a>

                                                    @endauth
                                                </div>
                                            </div>
                                        </li>

                                        @foreach($comment->replies as $reply)
                                        <li class="comments__item comments__item--answer">
                                            <div class="comments__autor">
                                                <span class="comments__name">Author</span>
                                                <span class="comments__time">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="comments__text">{{ $reply->reply }}</p>
                                        </li>
                                        @endforeach



                                        @endforeach


                                    </div>






                                </ul>

                                @auth('visitor')
                                    <form wire:submit="comments" class="form">
                                        @csrf
                                    <textarea wire:model="comment" class="form__textarea" placeholder="Add comment"></textarea>
                                    <div class="" style="display: flex; justify-content:between;">
                                        <button type="submit" class="form__btn">Send</button>
                                        @if (session('commented'))
                                        <h3 class="success text_center btn bg_success"><i class="fa-solid fa-check fa-xl"></i> &nbsp; <span class="color_light">{{session('commented')}}</span></h3>
                                        @endif
                                    </div>

                                </form>
                                @else
                                <div class="col-12 mb_4">
                                    <!-- content title -->
                                    <h3 class="text_center"><span class="color_dark btn bg_success"><a href="{{route('signin')}}" class="color_light fw_1">Sign In to Write a Comment &nbsp; </a></span></h3>
                                    <!-- end content title -->
                                </div>
                                @endauth
                            </div>
                        </div>
                        <!-- end comments -->
                    </div>
                </div>



            </div>
            <!-- end content tabs -->
        </div>

    </div>
</div>
