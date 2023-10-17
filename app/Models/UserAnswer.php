<?php

namespace App\Models;

use App\Models\MultipleTestAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_answers';

    public $timestamps = false;

    /**
     * Get all of the multipleAnswerDetail for the UserAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multipleAnswerDetail(): HasMany
    {
        return $this->hasMany(MultipleTestAnswer::class, 'user_answer_id', 'id');
    }

    /**
     * Get all of the essayAnswerDetail for the UserAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function essayAnswerDetail(): HasMany
    {
        return $this->hasMany(EssayTestAnswer::class, 'user_answer_id', 'id');
    }
}
