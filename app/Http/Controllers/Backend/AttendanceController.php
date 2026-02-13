<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    // Show Daily Entry Form
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Get all employees (Role check is optional if you have roles)
        $employees = User::where('email', '!=', 'admin@app.com')->with(['attendances' => function ($query) use ($date) {
            $query->where('date', $date);
        }])->get();

        return view('backend.attendance.index', compact('employees', 'date'));
    }

    // Save Attendance (Bulk Action)
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $userId => $data) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'date' => $request->date
                ],
                [
                    'status' => $data['status'],
                    'check_in' => $data['check_in'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Attendance Updated Successfully');
    }

    public function report(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        // 1. Get Filter Parameters
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $viewType = $request->input('view_type', 'calendar'); // Default to Calendar

        // 2. Date Object for calculations
        $dateObj = \Carbon\Carbon::createFromDate($year, $month, 1);

        // 3. Fetch Data
        $attendances = Attendance::where('user_id', $user_id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date'); // Key by date for Calendar mapping

        // 4. Calculate Stats
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();

        return view('backend.attendance.report', compact(
            'user',
            'attendances',
            'present',
            'absent',
            'late',
            'dateObj',
            'month',
            'year',
            'viewType'
        ));
    }
    public function getNotes($user_id)
    {
        $notes = Note::where('created_on', $user_id)
            ->where('is_delete', 0)
            ->get();
// dd($notes);
        return response()->json($notes);
    }
    public function storeNote(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'note' => 'required|string'
        ]);
// dd($request);
        $note = Note::create([
            // 'user_id' => $request->user_id,
            'note' => $request->note,
            'status' => "1",
            'created_on' => $request->user_id,
            // 'is_delete' => 0
        ]);
// dd($note);
        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }
    public function deleteNote($id)
{
    $note = \App\Models\Note::findOrFail($id);

    $note->is_delete = 1;
    $note->save();

    return response()->json([
        'success' => true
    ]);
}

}
