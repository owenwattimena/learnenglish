<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Period;
use DB;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $data['periods'] = Period::all();
        return view('period.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "periode" => "required"
        ]);
        return DB::transaction(function () use ($data) {
            Period::query()->update(['status' => false]);
            if (Period::create($data)) {
                return redirect()->back()->with(AlertFormatter::success('Period successfully added'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Failed to add Period'));
        });
    }

    public function changeStatus(Request $request, int $periodId)
    {
        return DB::transaction(function () use ($request, $periodId) {
            $period = Period::findOrFail($periodId);
            if ($period->status == true) {
                $period->status = false;
                if ($period->save()) {
                    return redirect()->back()->with(AlertFormatter::success('Period status successfully change'));
                }
                return redirect()->back()->with(AlertFormatter::success('Failed to change period status'));
            }else{
                Period::query()->update(['status' => false]);
                $period->status = true;
                if ($period->save()) {
                    return redirect()->back()->with(AlertFormatter::success('Period status successfully change'));
                }
                return redirect()->back()->with(AlertFormatter::success('Failed to change period status'));
            }
        });
    }

    public function update(Request $request, int $periodId)
    {
        $data = $request->validate([
            "periode" => "required"
        ]);

        if(Period::findOrFail($periodId)->update($data) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Period status successfully updated'));
        }
        return redirect()->back()->with(AlertFormatter::success('Failed to update period'));
    }

    public function delete(Request $request, int $periodId)
    {
        if(Period::destroy($periodId) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Period status successfully deleted'));
        }
        return redirect()->back()->with(AlertFormatter::success('Failed to delete period'));
    }
}
