<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'deadline', 'status', 'category_id'];
    protected $casts = [
        'status' => TaskStatus::class,  // Cast status to TaskStatus enum
    ];
    // Each task belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
