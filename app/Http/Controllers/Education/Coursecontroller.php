<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Course;
use App\Models\Education\Program;
use App\Models\Education\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses         = Course::with(['teacher', 'program'])->withCount('students')->orderBy('name')->get();
        $totalCourses    = $courses->count();
        $activeCourses   = $courses->where('status', 'active')->count();
        $finishedCourses = $courses->where('status', 'finished')->count();
        $pendingCourses  = $courses->where('status', 'pending')->count();

        return view('education.courses.index', compact(
            'courses', 'totalCourses', 'activeCourses', 'finishedCourses', 'pendingCourses'
        ));
    }

    public function create()
    {
        $teachers = Teacher::where('status', 'active')->orderBy('name')->get();
        $programs = Program::orderBy('name')->get();
        return view('education.courses.form', compact('teachers', 'programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:20|unique:courses,code',
            'teacher_id'  => 'nullable|exists:teachers,id',
            'program_id'  => 'nullable|exists:programs,id',
            'credits'     => 'required|integer|min:1|max:10',
            'status'      => 'required|in:active,pending,finished',
            'description' => 'nullable|string|max:1000',
        ]);

        Course::create($data);
        return redirect()->route('education.courses.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function show(Course $course)
    {
        $course->load(['teacher', 'program', 'students', 'grades.student']);
        return view('education.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $teachers = Teacher::where('status', 'active')->orderBy('name')->get();
        $programs = Program::orderBy('name')->get();
        return view('education.courses.form', compact('course', 'teachers', 'programs'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:20|unique:courses,code,' . $course->id,
            'teacher_id'  => 'nullable|exists:teachers,id',
            'program_id'  => 'nullable|exists:programs,id',
            'credits'     => 'required|integer|min:1|max:10',
            'status'      => 'required|in:active,pending,finished',
            'description' => 'nullable|string|max:1000',
        ]);

        $course->update($data);
        return redirect()->route('education.courses.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('education.courses.index')
            ->with('success', 'Curso eliminado.');
    }
}
