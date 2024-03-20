    <section class="{{ $classBox }}">
        <div class="d-flex justify-content-between align-items-center mb-6">
            <h2 class="text-lg lg:text-2xl fw-bold text-dark">Discussion
                ({{ $comments->count() }})</h2>
        </div>
        @auth
            @include('comment::partials.comment-form', [
                'method' => 'postComment',
                'state' => 'newCommentState',
                'inputId' => 'comment',
                'inputLabel' => 'Your comment',
                'button' => 'Post comment',
            ])
        @else
            <a class="py-3 text-sm" href="{{ applyFilters('login_url', route('site.login')) }}">
                @lang('Log in to comment!')
            </a>
        @endauth
        @if ($comments->count())
            @foreach ($comments as $comment)
                <livewire:comment::comment :$comment :key="$comment->id" />
            @endforeach
            {{ $comments->links('sokeio::pagination') }}
        @else
            <p>@lang('No comments yet!')</p>
        @endif
    </section>
