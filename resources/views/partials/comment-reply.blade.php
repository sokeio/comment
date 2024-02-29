@if (config('comment.comment_nesting') === true)
    @auth
        @if ($comment->isParent())
            <button type="button" wire:click="$toggle('isReplying')"
                class="btn btn-secondary btn-sm text-decoration-none me-2">
                <i class="bi bi-reply fs-4"></i>
                <span class="px-1">@lang('Reply')</span>

            </button>
            <div wire:loading wire:target="$toggle('isReplying')">
                @include('comment::partials.loader')
            </div>
        @endif
    @endauth
    @if ($comment->children->count())
        <button type="button" wire:click="$toggle('hasReplies')"
            class="btn bg-lime text-lime-fg btn-sm text-decoration-none">
            @if (!$hasReplies)
                View all Replies ({{ $comment->children->count() }})
            @else
                Hide Replies
            @endif
        </button>
        <div wire:loading wire:target="$toggle('hasReplies')">
            @include('comment::partials.loader')
        </div>
    @endif
@endif
