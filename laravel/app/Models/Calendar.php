<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{

    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'calendar_body', 'calendar_field', 'user_id',
    ];

    // usersテーブルと紐付ける
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
