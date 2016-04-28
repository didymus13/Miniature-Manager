<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Miniature extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'label',
        'save_to' => 'slug'
    ];

    protected $fillable = ['label', 'progress'];

    public static function boot()
    {
        parent::boot();

        Miniature::deleting(function($miniature) {
            foreach($miniature->photos as $photo) {
                $photo->delete();
            }
        });

        Miniature::saved(function ($miniature) {
            $miniature->collection->touch();
        });
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function getFeaturedImageAttribute()
    {
        foreach($this->photos as $photo) {
            return $photo;
        }
        return null;
    }
}
