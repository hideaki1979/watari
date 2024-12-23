<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dm extends Model
{
    /** @use HasFactory<\Database\Factories\DmFactory> */
    use HasFactory;

    protected $fillable = ['send_datetime', 'message'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
