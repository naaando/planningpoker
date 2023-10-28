<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    use HasUlids;

    protected $with = ['votes'];

    protected $appends = ['votes_average', 'votes_count'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function getVotesAverageAttribute()
    {
        return $this->votes->avg('vote') ?? 0;
    }

    public function getVotesCountAttribute()
    {
        return $this->votes->whereNotNull('vote')->count();
    }
}
