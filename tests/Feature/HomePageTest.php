<?php

namespace Tests\Feature;

use App\Models\Show;
use App\Models\SocialLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_database_driven_shows_and_socials(): void
    {
        Show::query()->create([
            'title' => 'Summer at The Cellar',
            'venue' => 'The Cellar',
            'event_date' => now()->addWeek()->toDateString(),
            'event_time' => '20:30:00',
            'description' => 'Full band night with new tracks.',
            'ticket_url' => 'https://example.com/tickets',
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        SocialLink::query()->create([
            'platform' => 'Instagram',
            'label' => '@thegrapesband',
            'url' => 'https://instagram.com/thegrapesband',
            'icon' => 'instagram',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Summer at The Cellar');
        $response->assertSee('The Cellar');
        $response->assertSee('@thegrapesband');
    }
}