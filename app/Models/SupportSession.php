<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'support_agent_id',
        'subject',
        'status', // active, closed, cancelled
        'priority', // low, medium, high, urgent
        'category',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع موظف الدعم
     */
    public function supportAgent()
    {
        return $this->belongsTo(User::class, 'support_agent_id');
    }

    /**
     * علاقة مع رسائل الدردشة
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    /**
     * إنهاء الجلسة وحذف الرسائل المرتبطة بها
     */
    public function closeSession()
    {
        $this->update([
            'status' => 'closed',
            'ended_at' => now(),
        ]);

        // حذف جميع الرسائل المرتبطة بالجلسة
        $this->messages()->delete();
    }

    /**
     * التحقق مما إذا كانت الجلسة نشطة
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
