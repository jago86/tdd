<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_email',
        'to_email',
        'title',
        'message',
        'file',
    ];

    public static function booted()
    {
        static::created(function (Transfer $transfer) {
            $transfer->hash = Str::random(256) . $transfer->id;
            $transfer->save();
        });
    }
}
