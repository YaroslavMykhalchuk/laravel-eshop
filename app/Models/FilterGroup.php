<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterGroup extends Model
{
    protected $table = 'filter_groups';

    protected $fillable = [
        'title',
    ];

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_filters', 'category_id', 'filter_group_id');
    }
}
