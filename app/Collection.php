<?php

namespace App;

use Conner\Tagging\Taggable;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model implements SluggableInterface
{
    use SluggableTrait, Taggable;

    protected $sluggable = [
        'build_from' => 'label',
        'save_to' => 'slug'
    ];

    protected $fillable = ['label', 'description'];

    public static function boot()
    {
        parent::boot();
        Collection::deleting(function($collection) {
            foreach($collection->miniatures() as $mini) {
                $mini->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function miniatures()
    {
        return $this->hasMany(Miniature::class);
    }

    public function images()
    {
        return $this->morphToMany(Photo::class, 'imageable');
    }
}
