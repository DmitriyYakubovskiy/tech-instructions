<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Instruction;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instructions = Instruction::where('title', 'like', '%' . $search . '%')->where('approved', true)->get();
        return view('instructions.index', compact('instructions', 'search'));
    }

    public function create()
    {
        return view('instructions.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'file' => 'required|file|mimes:jpeg,pdf,jpg,png|max:2048',
                'icon' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            ]);

            $instruction = new Instruction($request->all());

            if ($request->hasFile('file')) {
                $fileName = uniqid('instruction_', true) . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(public_path('instructions'), $fileName);
                $instruction->file_path = 'instructions/' . $fileName;
            } else {
                return response()->json(['message' => 'Файл не загружен.'], 400);
            }
            if ($request->hasFile('icon')) {
                $iconName = uniqid('icon_', true) . '.' . $request->file('icon')->getClientOriginalExtension();
                $request->file('icon')->move(public_path('instructions_icons'), $iconName);
                $instruction->icon_path = 'instructions_icons/' . $iconName;
            } else {
                return response()->json(['message' => 'Файл не загружен.'], 400);
            }

            $instruction->save();

            return response()->json(['message' => 'Инструкция успешно отправлена на утверждение.'], 200);
        } catch (\Exception $e) {
            Log::error('Ошибка при сохранении инструкции: ' . $e->getMessage());

            return response()->json(['message' => 'Произошла ошибка при отправке инструкции. Пожалуйста, попробуйте еще раз.'], 500);
        }
    }

    public function show($id)
    {
        $instruction = Instruction::findOrFail($id);
        $complaints = Complaint::where('instruction_id', $instruction->id)->get();
        return view('instructions.show', compact('instruction', 'complaints'));
    }

    public function complain(Request $request, $id)
    {
        $instruction = Instruction::findOrFail($id);

        $request->validate(['reason' => 'required']);

        $complaint = Complaint::create([
            'instruction_id' => $instruction->id,
            'reason' => $request->reason,
            'user_id' => Auth::user()->id,
        ]);

        $complaints = Complaint::where('instruction_id', $instruction->id)->with('user')->get();

        return response()->json([
            'success' => true,
            'message' => 'Жалоба подана.',
            'complaints' => $complaints,
        ]);
    }

    public function destroy($id)
    {
        $instruction = Instruction::findOrFail($id);
        $instruction->delete();

        return redirect()->route('instructions.index')->with('success', 'Инструкция успешно удалена.');
    }
}
