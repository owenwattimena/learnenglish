<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(int $lessonId)
    {
        $data['lesson'] = Lesson::findOrFail($lessonId);
        $data['quiz'] = Quiz::where('lesson_id', $lessonId)->get();
        return view('quiz.index', $data);
    }

    public function create(Request $request, int $lessonId)
    {
        $data = $request->validate([
            "type" => "required",
            "title" => "required",
            "description" => "required",
        ]);

        $data['lesson_id'] = $lessonId;

        if( Quiz::create($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Quiz successfully added'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to add quiz'));
    }

    public function delete(Request $request, int $lessonId, int $quizId)
    {
        if(Quiz::destroy($quizId) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Period status successfully deleted'));
        }
        return redirect()->back()->with(AlertFormatter::success('Failed to delete period'));
    }
}
