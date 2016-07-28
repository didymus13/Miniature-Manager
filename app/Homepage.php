<?php

namespace App;


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
        $this->mostViewedCollection = Collection::orderBy('views', 'desc')->first();
        $this->lastUpdatedCollection = Collection::orderBy('updated_at', 'desc')->first();
    }
}
