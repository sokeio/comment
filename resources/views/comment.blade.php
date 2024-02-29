<div>
    @if ($isEditing)
        @include('comment::partials.comment-form', [
            'method' => 'editComment',
            'state' => 'editState',
            'inputId' => 'reply-comment',
            'inputLabel' => 'Your Reply',
            'button' => 'Edit Comment',
        ])
    @else
        <article class="p-4 mb-1 bg-white rounded border">
            <footer class="d-flex justify-content-between align-items-center mb-1">
                <div class="d-flex align-items-center">
                    <p class="d-inline-flex align-items-center me-3 text-sm text-dark"><img class="me-2 rounded-circle"
                            src="{{ $comment->UserAvatar() }}"
                            alt="{{ $comment->user->name }}">{{ Str::ucfirst($comment->user->name) }}</p>
                    <p class="text-sm text-secondary">
                        <time pubdate datetime="{{ $comment->presenter()->relativeCreatedAt() }}"
                            title="{{ $comment->presenter()->relativeCreatedAt() }}">
                            {{ $comment->presenter()->relativeCreatedAt() }}
                        </time>
                    </p>
                </div>
                @canany(['update', 'delete'], $comment)
                    <div class="position-relative">
                        <div class="dropdown">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('update', $comment)
                                    <a class="dropdown-item" wire:click="$toggle('isEditing')" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-edit dropdown-item-icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        @lang('Edit')
                                    </a>
                                @endcan
                                @can('destroy', $comment)
                                    <a class="dropdown-item" x-on:click="confirmCommentDeletion" x-data="{
                                        confirmCommentDeletion() {
                                            if (window.confirm('You sure to delete this comment?')) {
                                                this.$wire.deleteComment();
                                            }
                                        }
                                    }"
                                        href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-trash dropdown-item-icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        @lang('Delete')
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endcanany
            </footer>
            <p class="text-secondary">
                {!! $comment->presenter()->replaceUserMentions($comment->presenter()->markdownBody()) !!}
            </p>

            <div class="d-flex align-items-center mt-4">
                <livewire:comment::like :$comment :key="$comment->id" />

                @include('comment::partials.comment-reply')

            </div>

        </article>
    @endif
    @if ($isReplying)
        @include('comment::partials.comment-form', [
            'method' => 'postReply',
            'state' => 'replyState',
            'inputId' => 'reply-comment',
            'inputLabel' => 'Your Reply',
            'button' => 'Post Reply',
        ])
    @endif
    @if ($hasReplies)
        <article class="p-1 mb-1  ms-4">
            @foreach ($comment->children as $child)
                <livewire:comment::comment :comment="$child" :key="$child->id" />
            @endforeach
        </article>
    @endif
    <script>
        function detectAtSymbol() {
            const textarea = document.getElementById('reply-comment');
            if (!textarea) {
                return;
            }

            const cursorPosition = textarea.selectionStart;
            const textBeforeCursor = textarea.value.substring(0, cursorPosition);
            const atSymbolPosition = textBeforeCursor.lastIndexOf('@');

            if (atSymbolPosition !== -1) {
                const searchTerm = textBeforeCursor.substring(atSymbolPosition + 1);
                if (searchTerm.trim().length > 0) {
                    @this.dispatch('getUsers', {
                        searchTerm: searchTerm
                    });
                }
            }
        }
    </script>
</div>
