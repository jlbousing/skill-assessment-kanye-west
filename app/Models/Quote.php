<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "text",
        "created_at",
        "updated_at"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
