<?php

namespace App\models\website;

use Illuminate\Database\Eloquent\Model;

class WhyTravelWith extends Model
{
    protected $table = 'why_travel_withs';

    protected $fillable = [
        'image',
        'title',
        'description',
        'sort_order',
        'status',
    ];
}
