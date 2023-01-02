<div class="media">
    <!-- first comment -->

    <div class="media-heading">
        <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        </button> <span class="label label-info">25</span>{{$sc->user->name}} {{$sc->user->family}}
    </div>

    <div class="panel-collapse collapse in" id="collapseOne">

        <div class="media-left">
            <div class="vote-wrap">
                <div class="save-post">
                    <a href="#"><span class="glyphicon glyphicon-star" aria-label="Save"></span></a>
                </div>
                <div class="vote up">
                    <i class="glyphicon glyphicon-menu-up"></i>
                </div>
                <div class="vote inactive">
                    <i class="glyphicon glyphicon-menu-down"></i>
                </div>
            </div>
            <!-- vote-wrap -->
        </div>
        <!-- media-left -->


        <div class="media-body">
            {{$sc->comment}}
            <div class="comment-meta">
                <span><a href="#">حذف</a></span>
                <span><a href="#">گزارش</a></span>
                <span><a href="#">hide</a></span>
                <span>
                        <a class="" role="button" data-toggle="collapse" href="#replyCommentT" aria-expanded="false" aria-controls="collapseExample">پاسخ</a>
                      </span>
                <div class="collapse" id="replyCommentT">
                    <form>
                        <div class="form-group">
                            <label for="comment">Your Comment</label>
                            <textarea name="comment" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Send</button>
                    </form>
                </div>
            </div>
            <!-- comment-meta -->
            @if (count($sc->children) > 0)
                @foreach ($sc->children as $child)
                    @include('site.scientific.comment', ['sc'=>$child])
                @endforeach
            @endif
        </div>
    </div>
    <!-- comments -->

</div>