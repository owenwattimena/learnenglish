<?php

namespace App\Http\Controllers\API;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use App\Models\EssayTestAnswer;
use App\Models\MultipleCO;
use App\Models\MultipleTestAnswer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function all(Request $request)
    {
        $user = $request->user();
        $lessons = DB::table('quiz as q')
            ->select('q.id', 'q.title', 'q.description', 'q.type')
            ->join('lessons as l', 'l.id', '=', 'q.lesson_id')
            ->where('l.period_id', $user->period->id)
            ->get();
        $lessons->each(function ($item) use ($user) {
            $correct = 0;
            $totalQuestion = Question::where('quiz_id', $item->id)->count();

            if ($item->type == 'multiple') {
                $userAnswer = UserAnswer::with([
                    'multipleAnswerDetail' => function ($query) {
                        return $query->with('selectedOption');
                    }
                ])->where('user_id', $user->id)->where('quiz_id', $item->id)->first()->toArray();
                if (!empty($userAnswer['multiple_answer_detail'])) {

                    foreach ($userAnswer['multiple_answer_detail'] as $key => $value) {
                        $correct += $value['selected_option']['is_answer'] ?? 0;
                    }
                }
            } else {
                $userAnswer = UserAnswer::with([
                    'essayAnswerDetail'
                ])->where('user_id', $user->id)->where('quiz_id', $item->id)->first()->toArray();
                if (!empty($userAnswer['essay_answer_detail'])) {

                    foreach ($userAnswer['essay_answer_detail'] as $key => $value) {
                        $correct += $value['is_correct'] ?? 0;
                    }
                }
            }
            $item->score = ($totalQuestion > 0) ? ($correct / $totalQuestion * 100 ?? 0) : 0;
            $item->is_final = $userAnswer['start_at'] != null && $userAnswer['end_at'] != null;
        });
        return JsonFormatter::success($lessons, message: 'List of quiz');
    }

    public function get(Request $request, int $quizId)
    {
        $quiz = Quiz::with('questions')->where('id', $quizId)->first();
        return JsonFormatter::success($quiz, message: 'Quiz');
    }

    public function getEssayQuestionAnswer(Request $request, int $quizId, int $idQuestion)
    {
        $user = $request->user();
        $userAnswer = UserAnswer::where('user_id', $user->id)->where('quiz_id', $quizId)->first();
        $answer = EssayTestAnswer::where('questions_id', $idQuestion)->where('user_answer_id', $userAnswer->id)->first();
        if ($answer)
            return JsonFormatter::success($answer, message: 'Essay answer');
        return JsonFormatter::error(message: 'Data not found.', code: 404);

    } ///

    public function getQuestionOption(Request $request, int $quizId, int $idQuestion)
    {
        $user = $request->user();
        $multiple = MultipleCO::where('question_id', $idQuestion)->get();
        $answer = DB::table('multiple_choice_options as mco')
            ->leftJoin('multiple_test_answer_detail as mta', 'mco.id', '=', 'mta.multiple_choice_options_id')
            ->leftJoin('user_answers as ua', 'mta.user_answer_id', '=', 'ua.id')
            ->select(['mco.id', 'mco.question_id', 'mco.number', 'mco.is_answer', 'mco.option', DB::raw('(mta.questions_id IS NOT NULL) as is_selected'), 'ua.user_id'])
            ->where('mco.question_id', $idQuestion)
            ->where('ua.user_id', $user->id)
            ->first();

        $multiple->each(function ($item) use ($answer) {
            if ($answer != null && $item->id == $answer->id) {
                $item->is_selected = true;
            } else {
                $item->is_selected = false;
            }
        });
        return JsonFormatter::success($multiple, message: 'Multiple choice option');
    }

    public function saveAnswer(Request $request, int $id)
    {
        $user = $request->user();
        $validator = Validator::make($request->input(), [
            'quiz_id' => 'required',
        ]);

        if ($request->quiz_id != $id) {
            return JsonFormatter::error("Data does not match.", code: 422);
        }
        if ($validator->fails()) {
            return JsonFormatter::error("Incomplete data.", data: $validator->errors()->all(), code: 422);
        }
        $answer = UserAnswer::where('quiz_id', $request->quiz_id)->where('user_id', $user->id)->first();
        if ($answer != null) {
            return JsonFormatter::success($answer, 'User answer data.');
        }

        $answer = new UserAnswer;
        $answer->quiz_id = $request->quiz_id;
        $answer->user_id = $user->id;
        $answer->start_at = now();

        if ($answer->save()) {
            return JsonFormatter::success($answer, 'User answer data.');
        }
        return JsonFormatter::error('Error. cann not access the quiz data.');
    }

    public function saveQuestionAnswer(Request $request, int $quizId)
    {
        $validator = Validator::make($request->input(), [
            'user_answer_id' => 'required',
            'questions_id' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonFormatter::error("Incomplete data.", data: $validator->errors()->all(), code: 422);
        }

        $data['user_answer_id'] = $request->user_answer_id;
        $data['questions_id'] = $request->questions_id;

        if ($request->input('multiple_choice_options_id')) {
            $data['multiple_choice_options_id'] = $request->multiple_choice_options_id;
            $result = MultipleTestAnswer::updateOrCreate(
                ['user_answer_id' => $data['user_answer_id'], 'questions_id' => $data['questions_id']],
                ['multiple_choice_options_id' => $data['multiple_choice_options_id']]
            );
            if ($result) {
                return JsonFormatter::success($result, 'Answer saved successfully.');
            }
            return JsonFormatter::error('Answer failed to save.');

        } else if ($request->input('answer')) {
            $data['answer'] = $request->answer;
            $result = EssayTestAnswer::updateOrCreate(
                ['user_answer_id' => $data['user_answer_id'], 'questions_id' => $data['questions_id']],
                ['answer' => $data['answer']]
            );
            if ($result) {
                return JsonFormatter::success($result, 'Answer saved successfully.');
            }
            return JsonFormatter::error('Answer failed to save.');
        }
        return JsonFormatter::error('Incomplete data. Answer failed to save.');
    }

    public function finish(Request $request, int $quizId)
    {
        $user = $request->user();

        $userAnswer = UserAnswer::where('user_id', $user->id)->where('quiz_id', $quizId)->first();
        $userAnswer->end_at = now();
        if($userAnswer->save())
        {
            return JsonFormatter::success($userAnswer, 'Quiz successfully completed');
        }
        return JsonFormatter::error('Failed to complete the quiz');
    }
    public function result(Request $request, int $quizId)
    {
        $user = $request->user();
        $quiz = Quiz::findOrFail($quizId);
        $totalQuestion = Question::where('quiz_id', $quizId)->count();
        $correct = 0;
        if($quiz->type == 'multiple')
        {
            $userAnswer = UserAnswer::with(['multipleAnswerDetail' => function($query){
                return $query->with('selectedOption');
            }])->where('user_id', $user->id)->where('quiz_id', $quizId)->first()->toArray();
            foreach ($userAnswer['multiple_answer_detail'] as $key => $value) {
                $correct += $value['selected_option']['is_answer'];
            }
        }else{

            $userAnswer = UserAnswer::with('essayAnswerDetail')->where('user_id', $user->id)->where('quiz_id', $quizId)->first()->toArray();
            foreach ($userAnswer['essay_answer_detail'] as $key => $value) {
                $correct += $value['is_correct'];
            }
        }
        $data['correct'] = $correct;
        $data['total_question'] = $totalQuestion;
        $data['score'] = ($totalQuestion > 0) ? $correct / $totalQuestion * 100 : 0;
        return JsonFormatter::success($data, 'Quiz result');

    }
}
