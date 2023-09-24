<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleCO extends Model
{
    use HasFactory;
    protected $table = 'multiple_choice_options';
    public $timestamps = false;
    protected $fillable = [
        'question_id',
        'number',
        'option',
        'is_answer',
    ];
}
