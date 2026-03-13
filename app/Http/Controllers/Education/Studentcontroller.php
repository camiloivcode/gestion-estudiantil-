<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Program;
use App\Models\Education\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('program')->orderBy('name')->get();
        return view('education.students.index', compact('students'));
    }

    public function create()
    {
        $programs = Program::orderBy('name')->get();
        return view('education.students.form', compact('programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:students,email',
            'student_code'    => 'nullable|string|max:20|unique:students,student_code',
            'semester'        => 'required|integer|min:1|max:12',
            'status'          => 'required|in:active,inactive,graduated',
            'program_id'      => 'nullable|exists:programs,id',
            'enrollment_date' => 'nullable|date',
            'notes'           => 'nullable|string|max:1000',
        ]);

        Student::create($data);
        return redirect()->route('education.students.index')
            ->with('success', 'Estudiante registrado correctamente.');
    }

    public function show(Student $student)
    {
        $student->load(['program', 'grades.course', 'attendances.course', 'courses']);
        return view('education.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $programs = Program::orderBy('name')->get();
        return view('education.students.form', compact('student', 'programs'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:students,email,' . $student->id,
            'student_code'    => 'nullable|string|max:20|unique:students,student_code,' . $student->id,
            'semester'        => 'required|integer|min:1|max:12',
            'status'          => 'required|in:active,inactive,graduated',
            'program_id'      => 'nullable|exists:programs,id',
            'enrollment_date' => 'nullable|date',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $student->update($data);
        return redirect()->route('education.students.index')
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('education.students.index')
            ->with('success', 'Estudiante eliminado.');
    }
}
