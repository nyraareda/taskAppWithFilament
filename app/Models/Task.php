<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'deadline', 'status', 'category_id'];

    // Each task belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
