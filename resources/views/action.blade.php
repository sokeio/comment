<div class="d-inline-flex align-items-center me-2 s-action s-action-{{ $type }}">
    <button wire:click="action"
        class="d-inline-flex align-items-center space-2 {{ $this->isAction() ? $actionClass : $unactionClass }} border-1 border-secondary rounded-1 focus-outline-none">
        @if ($icon)
            <i class="{{ $icon }} {{ $this->isAction() ? $actionIconClass : $unactionIconClass }} "></i>
        @endif

        <span class="fw-bold px-1">{{ $count }}</span>
        @if ($text)
            <span>@lang($text)</span>
        @endif
    </button>
</div>
