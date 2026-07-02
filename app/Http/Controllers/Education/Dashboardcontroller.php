<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Course;
use App\Models\Education\Grade;
use App\Models\Education\Student;
use App\Models\Education\Teacher;
use App\Models\Education\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents  = Student::count();
        $activeCourses  = Course::where('status', 'active')->count();
        $totalTeachers  = Teacher::count();
        $avgGrade       = round((float)(Grade::whereNotNull('average')->avg('average') ?? 0), 1);
        $recentStudents = Student::with('program')->latest()->take(8)->get();

        // Datos para gráfico: promedio por curso (top 6)
        $chartCourses = Course::with(['grades' => fn($q) => $q->whereNotNull('average')])
            ->where('status', 'active')->take(6)->get()
            ->map(fn($c) => [
                'name'    => $c->code ?? substr($c->name, 0, 12),
                'average' => round((float)($c->grades->avg('average') ?? 0), 1),
            ]);

        // Asistencia últimos 7 días (una sola consulta)
        $attendanceRaw = Attendance::selectRaw('DATE(date) as day, status, COUNT(*) as count')
            ->whereBetween('date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupByRaw('DATE(date), status')
            ->get()
            ->groupBy(fn($r) => $r->day);

        $attendanceStats = collect(range(6, 0))->map(function ($d) use ($attendanceRaw) {
            $date = now()->subDays($d)->format('Y-m-d');
            $dayStats = $attendanceRaw->get($date, collect());
            return [
                'date'    => now()->subDays($d)->format('d/m'),
                'present' => $dayStats->where('status', 'present')->sum('count'),
                'absent'  => $dayStats->where('status', 'absent')->sum('count'),
            ];
        });

        return view('education.dashboard', compact(
            'totalStudents', 'activeCourses', 'totalTeachers', 'avgGrade',
            'recentStudents', 'chartCourses', 'attendanceStats'
        ));
    }
}
