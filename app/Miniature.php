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

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
