<?php

namespace App\Http\Controllers\TestBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('admin.testbank', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'output' => 'required|string',
            'level' => 'required|in:easy,intermediate,hard',
            'tips' => 'nullable|string',
        ]);

        Question::create($request->all());

        return response()->json(['success' => 'Question added successfully']);
    }

    public function edit(Question $question)
    {
        return response()->json($question);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
            'output' => 'required|string',
            'level' => 'required|in:easy,intermediate,hard',
            'tips' => 'nullable|string',
        ]);

        $question->update($request->all());

        return response()->json(['success' => 'Question updated successfully']);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json(['success' => 'Question deleted successfully']);
    }



    public function getQuestions()
    {
        try {
            $questions = Question::all();

            if ($questions->isEmpty()) {
                return response()->json(['questions' => []], 200);
            }

            return response()->json(['questions' => $questions], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }



}
