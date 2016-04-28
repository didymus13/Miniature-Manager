<?php

namespace App;


use Conner\Tagging\Model\Tagged;
use Illuminate\Support\Facades\DB;

/**
 * Class Homepage
 * Homepage facade model to contain all necessary information
 * @package App
 */
class Homepage
{
    public $newPhotos = [];
    public $topTags = [];
    public $mostViewedCollection = null;
    public $lastUpdatedCollection = null;

    protected $photoLimit = 12;

    public function __construct()
    {
        $this->newPhotos = Photo::orderBy('created_at', 'desc')->limit($this->photoLimit)->get();
        $this->topTags = Tagged::where('taggable_type', Collection::class)
            ->groupBy('tag_slug')
            ->select(DB::raw('count(*) as counts, tag_name, tag_slug'))
            ->orderBy('counts', 'desc')
            ->orderBy('tag_name', 'asc')
            ->limit(10)
            ->get();
        $this->mostViewedCollection = Collection::orderBy('views', 'desc')->first();
        $this->lastUpdatedCollection = Collection::orderBy('updated_at', 'desc')->first();
    }
}
