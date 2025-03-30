<?php

namespace App\Http\Controllers\TestBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\TestPerformance;

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



    public function getQuestionsEasy()
    {
        try {

            $userId = auth()->id(); // Get the authenticated user ID
            Log::info("Authenticated User ID: " . $userId);
            // Get questions that the user has NOT answered
            $questions = Question::where('level', 'easy')
                ->whereDoesntHave('testPerformances', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($questions->isEmpty()) {
                return response()->json(['questions' => []], 200);
            }

            return response()->json([
                'questions' => $questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'output' => $question->output,
                        'tips' => $question->tips,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }


    public function getQuestionsMedium()
    {
        try {

            $userId = auth()->id(); // Get the authenticated user ID
            Log::info("Authenticated User ID: " . $userId);
            // Get questions that the user has NOT answered
            $questions = Question::where('level', 'intermediate')
                ->whereDoesntHave('testPerformances', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($questions->isEmpty()) {
                return response()->json(['questions' => []], 200);
            }

            return response()->json([
                'questions' => $questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'output' => $question->output,
                        'tips' => $question->tips,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }


    public function getQuestionsHard()
    {
        try {

            $userId = auth()->id(); // Get the authenticated user ID
            Log::info("Authenticated User ID: " . $userId);
            // Get questions that the user has NOT answered
            $questions = Question::where('level', 'hard')
                ->whereDoesntHave('testPerformances', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($questions->isEmpty()) {
                return response()->json(['questions' => []], 200);
            }

            return response()->json([
                'questions' => $questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'output' => $question->output,
                        'tips' => $question->tips,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }


}
