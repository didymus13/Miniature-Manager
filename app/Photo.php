<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Support\Facades\Storage;

class Photo extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $fillable = ['url', 'caption'];

    protected $sluggable = [
        'build_from' => 'caption',
        'save_to' => 'slug'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        Photo::deleting( function($photo) {
            Storage::disk('public')->delete($photo->url);
            Storage::disk('public')->delete($photo->thumb_url);
        });
    }

    public function getSiblingsAttribute()
    {
        return $this->imageable->photos->reject(function($photo) {
            return $photo->id === $this->id;
        });
    }
}
