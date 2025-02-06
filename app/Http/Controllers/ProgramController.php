<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();

        return view("program.index", compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:programs',
            'code' => 'required|unique:programs',
        ]);

        return Program::create($request->all());
    }

    public function destroy($id)
    {
        $item = Program::findOrFail($id);
        $item->delete();

        return redirect()->route('program.index')->with('success', 'Item deleted successfully!');
    }
}
