<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RoachPHP\Roach;
use RoachPHP\ItemPipeline\Item;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Spider\Configuration\Configuration;
use RoachPHP\Spider\SpiderInterface;
use RoachPHP\Spider\BasicSpider;
use App\Models\Link;
use App\Models\Site;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware as MiddlewareUserAgentMiddleware;
use RoachPHP\Spider\Configuration\Overrides;
use RoachPHP\ItemPipeline\ItemInterface;


class ScrapeLinksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;
    public $owner_id;

    public function __construct($url, $owner_id)
    {
        $this->url = $url;
        $this->owner_id = $owner_id;
    }

    public function handle()
    {
        Roach::startSpider(
            CustomSpider::class, 
            new Overrides(
                startUrls: [$this->url],
                itemProcessors: [
                    SaveLinksProcessor::class,
                ] 
            ),
            context: [
                'owner_id' => $this->owner_id,
                'url' => $this->url
                ]
        );
    }
}

class CustomSpider extends BasicSpider implements SpiderInterface
{
    public array $startUrls = [];
    public Site $site;

    public function configure(): void
    {
        $this->setDownloaderMiddleware([MiddlewareUserAgentMiddleware::class => [
            'userAgent' => 'Mozilla/5.0 (compatible; Roach/1.0)',
        ]]);
    }

    public function parse($response): \Generator
    {
        $siteName = $response->filter('title')->text();
        // Crear o encontrar el Site
        $site = Site::firstOrCreate(
            [
                'url' => $this->context['url'],
                'name' => $siteName,
                'owner_id' => (integer)$this->context['owner_id']
            ]
        );
        foreach ($response->filter('a') as $node) {
            yield $this->item([
                'url' => $node->getAttribute('href'),
                'name' => $node->textContent,
                'site_id' => $site->id,
            ]);
        }
        $site->status = 'Completed';
        $site->save();
    }
}

class SaveLinksProcessor implements ItemProcessorInterface
{
    public function configure(array $options): void
    {
        
    }
    
    public function processItem(ItemInterface $item): ItemInterface
    {
        Link::create([
            'url' => $item->get('url'),
            'name' => $item->get('name'),
            'site_id' => $item->get('site_id'),
        ]);
        return $item;
    }
}
