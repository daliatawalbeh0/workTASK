<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'location',
        'location_ar',
        'capacity',
        'event_date',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);  // ربط الحدث بالفئة
    }
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);  // ربط الحدث مع الحضور
    }

}
