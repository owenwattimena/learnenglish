<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'question',
        'quiz_id'
    ];

    /**
     * Get all of the option for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function option(): HasMany
    {
        return $this->hasMany(MultipleCO::class, 'question_id', 'id');
    }
    /**
     * Get all of the option for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mTAnswerDetail(): HasMany
    {
        return $this->hasMany(MultipleTestAnswer::class, 'questions_id', 'id');
    }

    /**
     * Get all of the eTAnswerDetail for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eTAnswerDetail(): HasMany
    {
        return $this->hasMany(EssayTestAnswer::class, 'questions_id', 'id');
    }

}
