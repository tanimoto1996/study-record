<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'todo_body', 'todo_status', 'user_id',
    ];

    // usersテーブルと紐付ける
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
