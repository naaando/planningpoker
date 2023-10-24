<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'round_id',
        'name',
        'vote',
    ];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}
