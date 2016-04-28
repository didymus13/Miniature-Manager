<?php

namespace App\Http\Controllers;

use App\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = App::make('sitemap');
        $sitemap->setCache('showcase.sitemap', 60);
        if ($sitemap->isCached()) {
            return $sitemap->render('xml');
        }

        $sitemap->add(url('/'), Carbon::now()->toIso8601String(), '1.0', 'daily');
        $sitemap->add(route('collections.index'), Carbon::now()->toIso8601String(), '0.9', 'daily');

        foreach (Collection::with(['miniatures', 'miniatures.photos'])->get() as $collection) {
            $sitemap->add(
                route('collections.show', $collection->slug),
                $collection->updated_at->toIso8601String(),
                '0.8',
                'weekly',
                $this->renderImagesSitemap($collection->photos)
            );

            foreach($collection->miniatures as $miniature) {
                $sitemap->add(
                    route('miniatures.show', $miniature->slug),
                    $miniature->updated_at->toIso8601String(),
                    '0.7',
                    'weekly',
                    $this->renderImagesSitemap($miniature->photos)
                );

                foreach ($miniature->photos as $photo) {
                    $sitemap->add(
                        route('photos.show', $photo->id),
                        $photo->updated_at->toIso8601String(),
                        '0.7',
                        'monthly',
                        $this->renderImagesSitemap([$photo])
                    );
                }
            }
        }
        return $sitemap->render('xml');
    }

    protected function renderImagesSitemap($photos) {
        $out = [];
        if (!count($photos)) {
            return $out;
        }

        foreach ($photos as $photo) {
            $out[] = [
                'url' => $photo->fullUrl,
                'title' => $photo->caption,
                'caption' => $photo->caption
            ];
        }

        return $out;
    }
}
