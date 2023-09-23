<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Period;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $period = Period::where('status', true)->first();

        $data['lessons'] = Lesson::where('period_id', $period->id ?? 0)->get();

        return view('lesson.index', $data);
    }

    public function add()
    {
        return view('lesson.create');
    }
    public function edit(int $id)
    {
        $data['lesson'] = Lesson::findOrFail($id);
        return view('lesson.create', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "title" => "required",
            "description" => "required",
            "lesson" => "required",
        ]);

        $period = Period::where('status', true)->first();

        if ($period == null)
            return redirect()->back()->with(AlertFormatter::danger('Please select active period first in Periode Menu'));

        $data['period_id'] = $period->id;

        if (Lesson::create($data)) {
            return redirect()->route('lesson')->with(AlertFormatter::success('Lesson successfully added'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to add lesson'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "title" => "required",
            "description" => "required",
            "lesson" => "required",
        ]);

        if(Lesson::findOrFail($id)->update($data) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Lesson successfully updated'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to update Lesson'));
    }

    public function delete(Request $request, int $id)
    {
        if(Lesson::destroy($id) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Lesson successfully deleted'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to update Lesson'));
    }
}
