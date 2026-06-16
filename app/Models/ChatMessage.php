<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'session_id',
        'sender_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * العلاقة مع الجلسة
     */
    public function session()
    {
        return $this->belongsTo(SupportSession::class, 'session_id');
    }

    /**
     * العلاقة مع المرسل
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * التحقق مما إذا كان المرسل هو المستخدم
     */
    public function isFromUser()
    {
        return $this->session->user_id === $this->sender_id;
    }

    /**
     * التحقق مما إذا كان المرسل هو موظف الدعم
     */
    public function isFromSupportAgent()
    {
        return $this->session->support_agent_id === $this->sender_id;
    }
}
