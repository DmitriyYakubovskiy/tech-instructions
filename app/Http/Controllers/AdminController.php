<?php

namespace App\Http\Controllers;
use App\Instruction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approve($id)
    {
        $instruction = Instruction::findOrFail($id);
        $instruction->approved = true;
        $instruction->save();
    
        return redirect()->route('admin.instructions.index');
    }
    
    public function destroy($id)
    {
        Instruction::destroy($id);
        return redirect()->route('admin.instructions.index');
    }
}
