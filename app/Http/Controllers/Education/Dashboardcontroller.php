<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Course;
use App\Models\Education\Grade;
use App\Models\Education\Student;
use App\Models\Education\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents  = Student::count();
        $activeCourses  = Course::where('status', 'active')->count();
        $totalTeachers  = Teacher::count();
        $avgGrade       = round(Grade::whereNotNull('average')->avg('average') ?? 0, 1);
        $recentStudents = Student::with('program')->latest()->take(8)->get();

        return view('education.dashboard', compact(
            'totalStudents', 'activeCourses', 'totalTeachers', 'avgGrade', 'recentStudents'
        ));
    }
}
