@if ($socialLinks->isNotEmpty())
    <div class="badge-row">
        @foreach ($socialLinks as $socialLink)
            <a class="badge flex-badge" href="{{ $socialLink->url }}" target="_blank" rel="noreferrer">
                @if($socialLink->icon)
                    <img src="https://cdn.simpleicons.org/{{ strtolower(trim($socialLink->icon)) }}/f7efe7" class="social-icon" alt="" width="16" height="16" />
                @endif
                {{ $socialLink->label ?: $socialLink->platform }}
            </a>
        @endforeach
    </div>
@else
    <p>No social links have been added yet.</p>
@endif
