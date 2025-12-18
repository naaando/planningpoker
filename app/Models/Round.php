<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = ['room_id', 'finished_at'];

    protected $with = ['votes'];

    protected $appends = ['votes_average', 'votes_count'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function isFinished(): Attribute
    {
        return Attribute::get(fn (mixed $value, array $attributes) => !empty($attributes['finished_at']));
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
