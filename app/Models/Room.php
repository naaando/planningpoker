<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'slug';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'round_id'];

    protected $with = ['round'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get the rounds
     */
    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    /**
     * Get the current round
     */
    public function round()
    {
        return $this->hasOne(Round::class)->whereNull('finished_at');
    }
}
