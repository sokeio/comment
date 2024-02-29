<form class="mb-6" wire:submit="{{ $method }}">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="p-2 mb-3 bg-green text-green-fg rounded"
                role="alert">
                <span class="font-medium">Success!</span> {{ session('message') }}
            </div>
        </div>
    @endif
    @csrf
    <div
        class="py-2 px-4 mb-4 bg-white rounded-lg rounded-top-lg border border-gray-200">
        <label for="{{ $inputId }}" class="visually-hidden">{{ $inputLabel }}</label>
        <textarea id="{{ $inputId }}" rows="6"
            class="form-control py-0 w-full text-sm text-gray-900 border-0 @error($state . '.body')
                              border-danger @enderror"
            placeholder="Write a comment..." wire:model="{{ $state }}.body" oninput="detectAtSymbol()"></textarea>
        @if (!empty($users) && $users->count() > 0)
            @include('comment::partials.dropdowns.users')
        @endif
        @error($state . '.body')
            <p class="mt-2 text-sm text-danger">
                {{ $message }}
            </p>
        @enderror
    </div>

    <button wire:loading.attr="disabled" type="submit"
        class="btn btn-primary inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
        <div wire:loading wire:target="{{ $method }}">
            @include('comment::partials.loader')
        </div>
        {{ $button }}
    </button>

</form>
