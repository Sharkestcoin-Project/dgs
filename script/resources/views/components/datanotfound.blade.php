@props([
    'message' => $meesage ?? __("We couldn't find any data"),
    'help' => $help ?? __("Sorry we can't find any data, to get rid of this message, make at least 1 entry."),
    'button_name' => null,
    'button_link' => null,
    'button_icon' => null
])

<div class="empty-state h-400" data-height="400">
    <div class="empty-state-icon">
        <i class="fas fa-question"></i>
    </div>
    <h2>{{ $message }}</h2>
    <p class="lead">
        {{ $help }}
    </p>
    @if(isset($button_name) && isset($button_link))
    <a href="{{ $button_link }}" class="btn btn-primary mt-4">
        @if($button_icon)
            <i class="{{ $button_icon }}"></i>
        @endif
        {{ $button_name }}
    </a>
    @endif
</div>
