<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Jobs\ScrapeLinksJob;
use App\Models\Site;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class ScrapeLinksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_the_scrape_job()
    {
        Queue::fake();

        // Create a user
        $user = User::factory()->create();

        $url = 'http://example.com';

        // Act as the created user and make the request
        $this->actingAs($user)->get('/site/scrape?url=' . $url);

        Queue::assertPushed(ScrapeLinksJob::class, function ($job) use ($url, $user) {
            return $job->url === $url && $job->owner_id === $user->id;
        });
    }

    /** @test */
    public function it_creates_site_and_links()
    {
        Bus::fake();

        // Create a user
        $user = User::factory()->create();

        $url = 'http://example.com';

        // Act as the created user and dispatch the job
        $this->actingAs($user)->get('/site/scrape?url=' . $url);

        // Dispatch job and wait for it to complete before checking database records
        Bus::assertDispatched(ScrapeLinksJob::class, function ($job) use ($url, $user) {
            $job->handle();

            return true;
        });

        $this->assertDatabaseHas('sites', [
            'url' => $url,
            'owner_id' => $user->id,
        ]);

        $site = Site::where('url', $url)->first();
        // Check if the site was created correctly
        $this->assertNotNull($site);

        // Check if the links were created by it's counting is bigger than 0
        $this->assertGreaterThan(0, $site->links()->count());
    }
}
