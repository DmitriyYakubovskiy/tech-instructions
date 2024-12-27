<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Instruction;

class InstructionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instructions = Instruction::where('title', 'LIKE', "%{$search}%")->get();
        return view('instructions.index', compact('instructions'));
    }
    
    public function show($id)
    {
        $instruction = Instruction::findOrFail($id);
        return view('instructions.show', compact('instruction'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|file|mimes:pdf',
        ]);
    
        $path = $request->file('file')->store('instructions');
    
        Instruction::create([
            'title' => $request->title,
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('instructions.index');
    }
}
