<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MultipleTestAnswer extends Model
{
    use HasFactory;
    protected $table = "multiple_test_answer_detail";
    protected $fillable = [
        'user_answer_id',
        'questions_id',
        'multiple_choice_options_id',
    ];

    /**
     * Get the selectedOption associated with the MultipleTestAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function selectedOption(): HasOne
    {
        return $this->hasOne(MultipleCO::class, 'id', 'multiple_choice_options_id');
    }
}
