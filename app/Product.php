<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;

    protected $table = 'product';

    protected $fillable = ['name','category_id','price','is_available'];

    protected static $logAttributes = ['name','category_id','price','is_available'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
