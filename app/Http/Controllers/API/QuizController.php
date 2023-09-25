<?php

namespace App\Http\Controllers\API;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function all(Request $request)
    {
        $user = $request->user();
        $lessons = DB::table('quiz as q')
            ->select('q.id', 'q.title', 'q.description')
            ->join('lessons as l', 'l.id', '=', 'q.lesson_id')
            ->where('l.period_id', $user->period->id)
            ->get();
        return JsonFormatter::success($lessons, message: 'List of quiz');
    }
}
