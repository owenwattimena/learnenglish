<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\MultipleCO;
use App\Models\Question;
use App\Models\Quiz;
use DB;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(int $lessonId, int $quizId)
    {
        $data['lesson'] = Lesson::findOrFail($lessonId);
        $data['quiz'] = Quiz::findOrFail($quizId);
        $data['questions'] = Question::where('quiz_id', $quizId)->get();
        return view('quiz.question', $data);
    }

    public function create(Request $request, int $lessonId, int $quizId)
    {
        $data = $request->validate([
            "no" => "required",
            "question" => "required",
        ]);
        $data['quiz_id'] = $quizId;
        return DB::transaction(function () use ($request, $data) {

            $question = Question::create($data);
            if ($question) {
                if(isset($request->answer)){
                    // save option a
                    MultipleCO::create([
                        'question_id' => $question->id,
                        'number' => 'a',
                        'option' => $request->option_a,
                        'is_answer' => $request->answer == 'option_a' ? true : false
                    ]);
                    // save option b
                    MultipleCO::create([
                        'question_id' => $question->id,
                        'number' => 'b',
                        'option' => $request->option_b,
                        'is_answer' => $request->answer == 'option_b' ? true : false
                    ]);
                    // save option b
                    MultipleCO::create([
                        'question_id' => $question->id,
                        'number' => 'c',
                        'option' => $request->option_c,
                        'is_answer' => $request->answer == 'option_c' ? true : false
                    ]);
                    // save option d
                    MultipleCO::create([
                        'question_id' => $question->id,
                        'number' => 'd',
                        'option' => $request->option_d,
                        'is_answer' => $request->answer == 'option_d' ? true : false
                    ]);
                }


                return redirect()->back()->with(AlertFormatter::success('Question successfully added'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Failed to add question'));
        });
    }
    public function delete(Request $request, int $lessonId, int $quizId, int $id)
    {
        if (Question::destroy($id) > 0) {
            MultipleCO::where('question_id', $id)->delete();
            return redirect()->back()->with(AlertFormatter::success('Question successfully deleted'));
        }
        return redirect()->back()->with(AlertFormatter::success('Failed to delete question'));
    }
}
