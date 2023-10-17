<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\EssayTestAnswer;
use App\Models\Lesson;
use App\Models\MultipleCO;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserAnswer;
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
                if (isset($request->answer)) {
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

    public function result(Request $request, int $lessonId, int $quizId)
    {
        $data['lesson'] = Lesson::findOrFail($lessonId);
        $data['quiz'] = Quiz::findOrFail($quizId);
        $answers = DB::table('user_answers as ua')
            ->join('users as u', 'u.id', '=', 'ua.user_id')
            ->where('ua.quiz_id', $quizId)
            ->select(['u.nama', 'ua.id', 'ua.user_id', 'ua.start_at', 'ua.end_at'])
            ->where('ua.start_at', '!=', null)
            ->get();
        $data['total_question'] = Question::where('quiz_id', $quizId)->count();



        if ($data['quiz']->type == 'multiple') {
            $answers->each(function ($item) use ($data) {
                $item->correct_answer = DB::table('multiple_test_answer_detail as mtad')
                    ->join('multiple_choice_options as mco', 'mtad.multiple_choice_options_id', '=', 'mco.id')
                    ->where('mco.is_answer', true)
                    ->where('mtad.user_answer_id', $item->id)
                    ->count();
                $item->score = $item->correct_answer / $data['total_question'] * 100;
            });
            $data['answers'] = $answers;
        }else{
            $answers->each(function ($item) use ($data) {
                $item->correct_answer = DB::table('essay_test_answer_detail')
                ->where('is_correct', true)
                ->where('user_answer_id', $item->id)
                ->count();
                $item->score = $item->correct_answer / $data['total_question'] * 100;
            });
            $data['answers'] = $answers;
        }
        // dd($data);
        return view('quiz.result', $data);
    }
    public function resultDetail(Request $request, int $lessonId, int $quizId, int $userAnswer)
    {
        $userAnswers = UserAnswer::findOrFail($userAnswer);
        $data['user'] = User::findOrFail($userAnswers->user_id);
        $data['lesson'] = Lesson::findOrFail($lessonId);
        $data['quiz'] = Quiz::findOrFail($quizId);
        $data['total_question'] = Question::where('quiz_id', $quizId)->count();
        if($data['quiz']->type == 'multiple'){
            $data['correctAnswer'] = DB::table('multiple_test_answer_detail as mtad')
                ->join('multiple_choice_options as mco', 'mtad.multiple_choice_options_id', '=', 'mco.id')
                ->where('mco.is_answer', true)
                ->where('mtad.user_answer_id', $userAnswer)
                ->count();
        }else{
            $data['correctAnswer'] = DB::table('essay_test_answer_detail as etad')
                ->where('etad.is_correct', true)
                ->where('etad.user_answer_id', $userAnswer)
                ->count();
        }
        $data['score'] = $data['correctAnswer'] / $data['total_question'] * 100;
        if($data['quiz']->type == 'multiple')
        {
            $data['questionAnswer'] = Question::where('quiz_id', $quizId)->with(['option' => function($query){
                return $query->where('is_answer', true);
            }, 'mTAnswerDetail' => function($query) use ($userAnswer){
                return $query->with('selectedOption')->where('user_answer_id', $userAnswer);
            }])->get();
        }else{
            $data['questionAnswer'] = Question::where('quiz_id', $quizId)->with(['eTAnswerDetail' => function($query) use ($userAnswer){
                return $query->where('user_answer_id', $userAnswer);
            }])->get();
        }
        // dd($data);
        return view('quiz.result-detail', $data);
    }

    public function resultEssayEvaluate(Request $request, int $lessonId, int $quizId, int $userAnswer)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $essaytTA = EssayTestAnswer::findOrFail($data['id']);
        if($request->correct)
        {
            $essaytTA->is_correct = true;
        }else{
            $essaytTA->is_correct = false;
        }
        if($essaytTA->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Evaluate succesfully'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Evaluate failed'));
    }
}
