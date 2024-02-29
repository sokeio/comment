<div class="d-inline-flex align-items-center me-2">
    <button wire:click="like"
        class="d-inline-flex align-items-center space-2 {{ $comment->isLiked() ? 'text-success' : 'text-secondary' }} border-0 focus-outline-none">
        <svg class="bi bi-hand-thumbs-up" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M1 9.5a1.5 1.5 0 113 0v5a1.5 1.5 0 01-3 0v-5zM5 9.5v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 16h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 6H12V2a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 5.933a4 4 0 00-.8 2.4z" />
        </svg>

        <span class="fw-bold text-dark px-1">{{ $count }}</span>
        <span class="visually-hidden">@lang('likes')</span>
    </button>
</div>
