<div class="d-inline-flex align-items-center me-2" x-init="$wire.checkView()"
    @if ($poll) wire:poll.{{ $poll }}s="loadView" @endif>
    <span class="fw-bold text-dark px-1">{{ $count }}</span>
    @if ($text)
        <span>@lang($text)</span>
    @endif
</div>
