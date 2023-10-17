<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssayTestAnswer extends Model
{
    use HasFactory;
    protected $table = "essay_test_answer_detail";

    protected $fillable = [
        'user_answer_id',
        'questions_id',
        'answer',
    ];
}
