<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
    ];

    public function phoneUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
