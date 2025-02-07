<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class StudentManagementController extends Controller
{
    public function index()
    {
        $programs = Program::all();

        return view("student-management.index", compact('programs'));
    }

    public function fetchData()
    {
        $data = Student::with('program')->get();

        return response()->json($data);
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

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'string',
            'program_id' => 'required|exists:programs,id',
            'registration_number' => 'required|string|unique:students,registration_number',
            'contact_number' => 'required|string',
            'start_program_date' => 'required|date',
            'end_program_date' => 'required|date|after_or_equal:start_program_date',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'address.string' => 'Address must be a valid string.',
            'program_id.required' => 'Program is required.',
            'program_id.exists' => 'The selected program is invalid.',
            'registration_number.required' => 'Registration number is required.',
            'registration_number.string' => 'Registration number must be a valid string.',
            'registration_number.unique' => 'The registration number has already been taken.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.string' => 'Contact number must be a valid string.',
            'start_program_date.required' => 'Start program date is required.',
            'start_program_date.date' => 'Start program date must be a valid date.',
            'end_program_date.required' => 'End program date is required.',
            'end_program_date.date' => 'End program date must be a valid date.',
            'end_program_date.after_or_equal' => 'End program date must be after or equal to start program date.',
        ]);

        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'program_id' => $request->program_id,
            'registration_number' => $request->registration_number,
            'contact_number' => $request->contact_number,
            'start_program_date' => $request->start_program_date,
            'end_program_date' => $request->end_program_date,
            'created_by' => Auth::id(),
        ]);

        $student->load('program');

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ],200);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'data' => $student
            ]);
        }

        return response()->json([
            'message' => 'Student not found'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('program')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'string',
            'program_id' => 'required|exists:programs,id',
            'registration_number' => 'required|string|unique:students,registration_number,' . $student->id,
            'contact_number' => 'required|string',
            'start_program_date' => 'required|date',
            'end_program_date' => 'required|date|after:start_program_date',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'address.string' => 'Address must be a valid string.',
            'program_id.required' => 'Program is required.',
            'program_id.exists' => 'The selected program is invalid.',
            'registration_number.required' => 'Registration number is required.',
            'registration_number.string' => 'Registration number must be a valid string.',
            'registration_number.unique' => 'The registration number has already been taken.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.string' => 'Contact number must be a valid string.',
            'start_program_date.required' => 'Start program date is required.',
            'start_program_date.date' => 'Start program date must be a valid date.',
            'end_program_date.required' => 'End program date is required.',
            'end_program_date.date' => 'End program date must be a valid date.',
            'end_program_date.after' => 'End program date must be after start program date.',
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'program_id' => $request->program_id,
            'registration_number' => $request->registration_number,
            'contact_number' => $request->contact_number,
            'start_program_date' => $request->start_program_date,
            'end_program_date' => $request->end_program_date,
            'updated_by' => Auth::id(),
        ]);

        $student->load('program');

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    public function destroy($id)
    {

        $item = Student::find($id);

        if ($item) {
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ], 404);
        }
    }
}
