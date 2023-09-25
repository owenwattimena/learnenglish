<?php

namespace App\Http\Controllers\API;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function all(Request $request)
    {
        $user = $request->user();
        $lessons = Lesson::where('period_id', $user->period->id)->get();
        return JsonFormatter::success($lessons, message: 'List of lesson');
    }

    public function get(Request $request , $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        return JsonFormatter::success($lesson, message: 'Lesson detail');
    }
}
