<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return view("program.index");
    }

    public function fetchData()
    {
        $data = Program::all();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:programs,name',
            'code' => 'required|unique:programs,code',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code has already been taken.',
        ]);

        $item = Program::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $item,
        ], 201);
    }

    public function edit($id)
    {
        $program = Program::find($id);

        if ($program) {
            return response()->json([
                'data' => $program
            ]);
        }

        return response()->json([
            'message' => 'Program not found'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'message' => 'Program not found'
            ], 404);
        }

        $program->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Program updated successfully',
            'data' => $program
        ]);
    }

    public function destroy($id)
    {

        $item = Program::find($id);

        if ($item) {
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Program deleted successfully!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Program not found.',
            ], 404);
        }
    }
}
