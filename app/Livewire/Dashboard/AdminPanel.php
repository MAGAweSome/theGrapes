<?php

namespace App\Livewire\Dashboard;

use App\Models\Show;
use App\Models\SocialLink;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Dashboard')]
class AdminPanel extends Component
{
    public ?int $editingShowId = null;

    public string $showTitle = '';

    public string $showVenue = '';

    public string $showDate = '';

    public string $showTime = '';

    public string $showDescription = '';

    public string $showTicketUrl = '';

    public bool $showFeatured = false;

    public bool $showPublished = true;

    public int $showSortOrder = 0;

    public ?int $editingSocialId = null;

    public string $socialPlatform = '';

    public string $socialLabel = '';

    public string $socialUrl = '';

    public string $socialIcon = '';

    public bool $socialIsActive = true;

    public int $socialSortOrder = 0;

    /**
     * Prepare the default form state.
     */
    public function mount(): void
    {
        $this->resetShowForm();
        $this->resetSocialForm();
    }

    /**
     * Save a show entry.
     */
    public function saveShow(): void
    {
        $validated = $this->validate($this->showRules());
        $isEditing = $this->editingShowId !== null;

        Show::updateOrCreate(
            ['id' => $this->editingShowId],
            [
                'title' => $validated['showTitle'],
                'venue' => $validated['showVenue'],
                'event_date' => $validated['showDate'],
                'event_time' => $validated['showTime'] !== '' ? $validated['showTime'] : null,
                'description' => $validated['showDescription'] !== '' ? $validated['showDescription'] : null,
                'ticket_url' => $validated['showTicketUrl'] !== '' ? $validated['showTicketUrl'] : null,
                'is_featured' => $validated['showFeatured'],
                'is_published' => $validated['showPublished'],
                'sort_order' => $validated['showSortOrder'],
            ],
        );

        $this->resetShowForm();
        $this->dispatch('scroll-to-dashboard-section', target: 'shows-list');

        Flux::toast(
            variant: 'success',
            text: $isEditing ? __('Show updated.') : __('Show added.'),
        );
    }

    /**
     * Edit an existing show.
     */
    public function editShow(int $showId): void
    {
        $show = Show::query()->findOrFail($showId);

        $this->editingShowId = $show->id;
        $this->showTitle = $show->title;
        $this->showVenue = $show->venue;
        $this->showDate = $show->event_date->format('Y-m-d');
        $this->showTime = $show->event_time ? substr((string) $show->event_time, 0, 5) : '';
        $this->showDescription = $show->description ?? '';
        $this->showTicketUrl = $show->ticket_url ?? '';
        $this->showFeatured = (bool) $show->is_featured;
        $this->showPublished = (bool) $show->is_published;
        $this->showSortOrder = $show->sort_order;

        $this->dispatch('scroll-to-dashboard-section', target: 'show-form');
    }

    /**
     * Delete a show.
     */
    public function deleteShow(int $showId): void
    {
        Show::query()->findOrFail($showId)->delete();

        if ($this->editingShowId === $showId) {
            $this->resetShowForm();
        }

        $this->dispatch('scroll-to-dashboard-section', target: 'shows-list');

        Flux::toast(variant: 'success', text: __('Show removed.'));
    }

    /**
     * Reset the show form.
     */
    public function resetShowForm(): void
    {
        $this->editingShowId = null;
        $this->showTitle = '';
        $this->showVenue = '';
        $this->showDate = now()->toDateString();
        $this->showTime = '';
        $this->showDescription = '';
        $this->showTicketUrl = '';
        $this->showFeatured = false;
        $this->showPublished = true;
        $this->showSortOrder = $this->nextShowSortOrder();
    }

    /**
     * Save a social link.
     */
    public function saveSocial(): void
    {
        $validated = $this->validate($this->socialRules());
        $isEditing = $this->editingSocialId !== null;

        SocialLink::updateOrCreate(
            ['id' => $this->editingSocialId],
            [
                'platform' => $validated['socialPlatform'],
                'label' => $validated['socialLabel'] !== '' ? $validated['socialLabel'] : null,
                'url' => $validated['socialUrl'],
                'icon' => $validated['socialIcon'] !== '' ? $validated['socialIcon'] : null,
                'is_active' => $validated['socialIsActive'],
                'sort_order' => $validated['socialSortOrder'],
            ],
        );

        $this->resetSocialForm();
        $this->dispatch('scroll-to-dashboard-section', target: 'socials-list');

        Flux::toast(
            variant: 'success',
            text: $isEditing ? __('Social link updated.') : __('Social link added.'),
        );
    }

    /**
     * Edit a social link.
     */
    public function editSocial(int $socialId): void
    {
        $social = SocialLink::query()->findOrFail($socialId);

        $this->editingSocialId = $social->id;
        $this->socialPlatform = $social->platform;
        $this->socialLabel = $social->label ?? '';
        $this->socialUrl = $social->url;
        $this->socialIcon = $social->icon ?? '';
        $this->socialIsActive = (bool) $social->is_active;
        $this->socialSortOrder = $social->sort_order;

        $this->dispatch('scroll-to-dashboard-section', target: 'social-form');
    }

    /**
     * Delete a social link.
     */
    public function deleteSocial(int $socialId): void
    {
        SocialLink::query()->findOrFail($socialId)->delete();

        if ($this->editingSocialId === $socialId) {
            $this->resetSocialForm();
        }

        $this->dispatch('scroll-to-dashboard-section', target: 'socials-list');

        Flux::toast(variant: 'success', text: __('Social link removed.'));
    }

    /**
     * Reset the social form.
     */
    public function resetSocialForm(): void
    {
        $this->editingSocialId = null;
        $this->socialPlatform = '';
        $this->socialLabel = '';
        $this->socialUrl = '';
        $this->socialIcon = '';
        $this->socialIsActive = true;
        $this->socialSortOrder = $this->nextSocialSortOrder();
    }

    /**
     * Validate the show form.
     *
     * @return array<string, mixed>
     */
    protected function showRules(): array
    {
        return [
            'showTitle' => ['required', 'string', 'max:120'],
            'showVenue' => ['required', 'string', 'max:120'],
            'showDate' => ['required', 'date'],
            'showTime' => ['nullable', 'date_format:H:i'],
            'showDescription' => ['nullable', 'string', 'max:2000'],
            'showTicketUrl' => ['nullable', 'url', 'max:255'],
            'showFeatured' => ['boolean'],
            'showPublished' => ['boolean'],
            'showSortOrder' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Validate the social form.
     *
     * @return array<string, mixed>
     */
    protected function socialRules(): array
    {
        return [
            'socialPlatform' => ['required', 'string', 'max:60'],
            'socialLabel' => ['nullable', 'string', 'max:120'],
            'socialUrl' => ['required', 'url', 'max:255'],
            'socialIcon' => ['nullable', 'string', 'max:60'],
            'socialIsActive' => ['boolean'],
            'socialSortOrder' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get the next show sort order.
     */
    protected function nextShowSortOrder(): int
    {
        return (int) (Show::query()->max('sort_order') ?? 0) + 1;
    }

    /**
     * Get the next social sort order.
     */
    protected function nextSocialSortOrder(): int
    {
        return (int) (SocialLink::query()->max('sort_order') ?? 0) + 1;
    }

    #[Computed]
    public function shows()
    {
        return Show::query()
            ->orderBy('sort_order')
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->get();
    }

    #[Computed]
    public function socialLinks()
    {
        return SocialLink::query()
            ->orderBy('sort_order')
            ->orderBy('platform')
            ->get();
    }
}