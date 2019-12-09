<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use HasSlug;
    use NodeTrait;
    use LogsActivity;

    protected $table = 'category';

    protected $fillable = ['name','slug','priority'];

    protected static $logAttributes = ['name','slug','priority'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    /*
    public function getRouteKeyName()
    {
        return 'id';
    }
    */
}
