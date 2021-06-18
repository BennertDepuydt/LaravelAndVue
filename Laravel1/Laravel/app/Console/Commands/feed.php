<?php

namespace App\Console\Commands;

use App\Event;
use Illuminate\Console\Command;
use App\Console\Commands;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use App\Console\Commands\SimpleXmlElement;
use App\Post;

class feed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:generate {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $worldFeeds = [];
        $url = $this->argument('url');
        $xml = file_get_contents($url);
        preg_match_all('#<vrtns:nstag xmlns="">(.+?)</vrtns:nstag>#', $xml, $matches);
        $ob = simplexml_load_string($xml);
        $i = 0;
        foreach ($ob->entry as $entry) {
            $json = json_encode($entry);
            $array = json_decode($json, TRUE);
            $title = $array['title'][0];
            $summary = $array['summary'][0];
            $category = $matches[1][$i];
            $image = $array['link'][2]['@attributes']['href'];
            $published = $array['published'];
            $date = date('Y-m-d h:i:s', strtotime($published));
            $post = new Post;
            $post->title = $title;
            $post->description = $summary;
            $post->imagelink = $image;
            $post->category = $category;
            $post->published = $date;
            $post->save();
            $i++;
        }
    }

}
