<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HplcResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'vector',
        'file_path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
