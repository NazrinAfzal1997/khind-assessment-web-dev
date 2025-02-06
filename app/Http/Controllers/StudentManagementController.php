<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Program;

class StudentManagementController extends Controller
{
    public function index()
    {
        $students = Student::with('program')->get();
        $programs = Program::all();

        return view("student-management.index", compact('students', 'programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'registration_number' => 'required|unique:students',
            'contact_number' => 'required',
            'program_id' => 'required|exists:programs,id',
        ]);

        return Student::create($request->all());
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'program_id' => 'exists:programs,id'
        ]);

        $student->update($request->all());

        return response()->json(['message' => 'Student updated successfully']);
    }

    public function destroy(Student $student) {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
