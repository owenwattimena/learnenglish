<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data['user'] = User::all();
        return view('student.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
            'password' => 'required'
        ]);

        $period = Period::where('status', true)->first();

        if($period == null)
        {
            return redirect()->back()->with(AlertFormatter::danger('Please select active period first in Periode Menu'));
        }
        $data['period_id'] = $period->id;

        if(User::create($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Student successfully added'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to add Student'));
    }

    public function update(Request $request, int $userId)
    {
        $data = $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
        ]);

        if($request->input('password'))
        {
            $data['password'] = $request->input('password');
        }

        if(User::findOrFail($userId)->update($data) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Student successfully updated'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to update Student'));
    }

    public function delete(Request $request, int $userId)
    {
        if(User::destroy($userId) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Student successfully deleted'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Failed to update Student'));
    }
}
