<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'created_by',
    ];

    /**
     * العلاقة مع المستخدم الذي أنشأ القالب
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
