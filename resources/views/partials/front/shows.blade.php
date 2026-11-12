@if ($upcomingShows->isNotEmpty())
    <div class="shows-list">
        @foreach ($upcomingShows as $show)
            <article class="card {{ $show->is_featured ? 'featured' : '' }}">
                <div class="card-date">
                    <span class="month">{{ $show->event_date->format('M') }}</span>
                    <span class="day">{{ $show->event_date->format('d') }}</span>
                </div>
                <div class="card-details">
                    <div class="card-header">
                        <h3>{{ $show->venue }}</h3>
                        @if ($show->is_featured)
                            <span class="badge" style="background: rgba(209, 95, 47, 0.2); color: #f0a56f; border: none; padding: 0.25rem 0.75rem; font-size: 0.75rem;">
                                Featured
                            </span>
                        @endif
                    </div>
                    <div class="card-meta">
                        <span>{{ $show->event_date->format('l, F j, Y') }}</span>
                        @if ($show->event_time)
                            <span>&bull;</span>
                            <span>{{ Carbon\Carbon::parse($show->event_time)->format('g:i A') }}</span>
                        @endif
                    </div>
                    @if ($show->description)
                        <p class="card-desc">{{ $show->description }}</p>
                    @endif
                </div>
                @if ($show->ticket_url)
                    <div class="card-action">
                        <a href="{{ $show->ticket_url }}" target="_blank" rel="noreferrer" class="button primary">
                            Tickets
                        </a>
                    </div>
                @endif
            </article>
        @endforeach
    </div>
@else
    <div class="card">
        <p>No upcoming shows announced yet. Check back soon!</p>
    </div>
@endif
