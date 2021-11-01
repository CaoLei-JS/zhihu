<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function scopePublished(Builder $builder)
    {
        $builder->whereNotNull('published_at');
    }

    public function answers(): HasMany
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function markAsBestAnswer(Answer $answer)
    {
        $this->update(['best_answer_id' => $answer->id]);
    }
}
