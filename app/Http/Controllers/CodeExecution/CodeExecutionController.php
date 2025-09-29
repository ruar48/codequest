<?php

namespace App\Http\Controllers\CodeExecution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExecutedCode;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Models\TestPerformance;

use Illuminate\Support\Facades\Log;
class CodeExecutionController extends Controller
{

    public function execute(Request $request)
    {
        \Log::info($request->all());

    // Get user ID from request
    $userId = $request->input('user_id');

    if (!$userId) {
        return response()->json([
            'error' => 'Bad Request',
            'message' => 'User ID is required.'
        ], 400);
    }

        $code = $request->input('code');

        if (!$code) {
            return response()->json([
                'error' => 'No code provided.',
                'message' => 'Please send valid PHP code.'
            ], 400);
        }

        // Syntax Checking using eval() wrapped in try-catch
        try {
            eval('if(0){' . $code . '}'); // Dummy eval to check syntax
        } catch (\ParseError $e) {
            $line = $e->getLine() - 1;
            $formattedMessage = "Parse error: syntax error, line {$line} " . $e->getMessage();

            // Store execution attempt in DB with user_id
            ExecutedCode::create([
                'user_id' => $userId, // Store user ID
                'code' => $code,
                'output' => $formattedMessage,
                'is_error' => true
            ]);

            return response()->json([
                'error' => 'Syntax error in PHP code.',
                'message' => $formattedMessage,
                'line' => $line
            ], 500);
        }

        // Start output buffering for execution
        ob_start();
        try {
            eval($code);
            $executionOutput = ob_get_clean(); // Get the output
            $executionOutput = trim($executionOutput);

            // Store successful execution in DB with user_id
            ExecutedCode::create([
                'user_id' => $userId, // Store user ID
                'code' => $code,
                'output' => $executionOutput,
                'is_error' => false
            ]);

            return response()->json([
                'output' => $executionOutput
            ], 200);
        } catch (\Throwable $e) {
            ob_end_clean();
            $line = $e->getLine();
            $formattedMessage = "Runtime error: line {$line} " . $e->getMessage();

            // Store runtime error in DB with user_id
            ExecutedCode::create([
                'user_id' => $userId, // Store user ID
                'code' => $code,
                'output' => $formattedMessage,
                'is_error' => true
            ]);

            return response()->json([
                'error' => 'Runtime error in PHP code.',
                'message' => $formattedMessage,
                'line' => $line
            ], 500);
        }
    }





    public function testbank(Request $request)
    {
        \Log::info($request->all());

        // Get user ID and code from request
        $userId = $request->input('user_id');
        $code = $request->input('code');

        if (!$userId || !$code) {
            return response()->json([
                'error' => 'Bad Request',
                'message' => 'User ID and PHP code are required.'
            ], 400);
        }

        // Fetch expected output from database
        $expectedOutput = Question::where('user_id', $userId)->value('output');

        if (!$expectedOutput) {
            return response()->json([
                'error' => 'No matching expected output found.',
                'message' => 'No test case available for this user.'
            ], 404);
        }

        // Check Syntax
        try {
            eval('if(0){' . $code . '}');
        } catch (\ParseError $e) {
            $formattedMessage = "Syntax error: line " . ($e->getLine() - 1) . " " . $e->getMessage();

            return response()->json([
                'error' => 'Syntax error in PHP code.',
                'message' => $formattedMessage
            ], 500);
        }

        // Execute Code
        ob_start();
        try {
            eval($code);
            $executionOutput = ob_get_clean();
            $executionOutput = trim($executionOutput);
        } catch (\Throwable $e) {
            ob_end_clean();
            $formattedMessage = "Runtime error: line " . $e->getLine() . " " . $e->getMessage();

            return response()->json([
                'error' => 'Runtime error in PHP code.',
                'message' => $formattedMessage
            ], 500);
        }

        // Check if execution output matches expected output
        if ($executionOutput === trim($expectedOutput)) {
            // Insert into DB if it matches
            ExecutedCode::create([
                'user_id' => $userId,
                'code' => $code,
                'output' => $executionOutput,
                'is_error' => false
            ]);

            return response()->json([
                'output' => $executionOutput,
                'status' => 'Success! Output matches expected result.'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Output does not match expected result.',
                'expected' => $expectedOutput,
                'received' => $executionOutput
            ], 400);
        }
    }




    public function testbanks(Request $request)
    {
        \Log::info("🔹 Received Request Data: " . json_encode($request->all()));

        // Get user input
        $userId = $request->input('user_id');
        $answer = trim($request->input('answer')); // Can be PHP or SQL
        $questionId = $request->input('question_id');

        // Validate input
        if (!$userId || !$answer || !$questionId) {
            return response()->json([
                'error' => 'Bad Request',
                'message' => 'User ID, Question ID, and answer are required.'
            ], 400);
        }

        // Fetch the question
        $question = DB::connection('mysql')->table('questions')->find($questionId);
        if (!$question) {
            return response()->json([
                'error' => 'Question not found.',
                'message' => 'Invalid Question ID.'
            ], 404);
        }

        \Log::info("✅ Fetched Question: " . json_encode($question));

        $expectedCode = trim($question->output);
        $userOutput = '';
        $expectedOutput = '';
        $isCorrect = false;
        $isError = false;

        // Determine difficulty points
        $difficultyPoints = match ($question->level) {
            'easy' => 1,
            'intermediate' => 2,
            'hard' => 3,
            default => 1,
        };

        // **Determine Answer Type**
        if (preg_match('/\$(\w+)|\b(echo|print|function|if|else|foreach|while|array|return)\b/', $answer)) {
            $answerType = 'php';
        } elseif (preg_match('/^\s*(SELECT|INSERT|UPDATE|DELETE|CREATE|DROP|ALTER)\b/i', $answer)) {
            $answerType = 'sql';
        } else {
            return response()->json([
                'error' => 'Unable to determine answer type.',
                'message' => 'Answer must be either PHP or SQL.'
            ], 400);
        }

        \Log::info("🔹 Detected Answer Type: " . strtoupper($answerType));

        if ($answerType === 'php') {
            \Log::info("🔹 Processing PHP answer.");

            // **Execute Expected PHP Code**
            ob_start();
            try {
                eval($expectedCode);
                $expectedOutput = ob_get_clean();
                $expectedOutput = trim($expectedOutput);
            } catch (\Throwable $e) {
                ob_end_clean();
                return response()->json([
                    'error' => 'Runtime error in expected PHP code.',
                    'message' => "Runtime error: " . $e->getMessage(),
                    'line' => $e->getLine()
                ], 500);
            }

            // **Execute User's PHP Code**
            ob_start();
            try {
                eval($answer);
                $userOutput = ob_get_clean();
                $userOutput = trim($userOutput);
            } catch (\Throwable $e) {
                ob_end_clean();
                $isError = true;
                $userOutput = "PHP Error: " . $e->getMessage();
            }

            // Compare Outputs
            $isCorrect = ($userOutput === $expectedOutput);
        } elseif ($answerType === 'sql') {
            \Log::info("🔹 Processing SQL query.");

            // Prevent dangerous SQL queries
            if (preg_match('/\b(DROP|DELETE|TRUNCATE|ALTER|UPDATE)\b/i', $answer)) {
                return response()->json([
                    'error' => 'Unsafe SQL query detected.',
                    'message' => 'Your query contains restricted operations.'
                ], 403);
            }

            try {
                // Execute expected SQL query
                $expectedResult = DB::connection('sql_db')->select($expectedCode);
                $expectedOutput = json_decode(json_encode($expectedResult), true);

                // Execute user's SQL query
                $userResult = DB::connection('sql_db')->select($answer);
                $userOutput = json_decode(json_encode($userResult), true);

                // Sort results for consistent comparison
                sort($expectedOutput);
                sort($userOutput);

                // Compare outputs
                if ($userOutput === $expectedOutput) {
                    $isCorrect = true;
                    $userOutput = "Executed Successfully";
                } else {
                    $userOutput = "You didn't get the required data.";
                }

            } catch (\Throwable $e) {
                $isError = true;
                $userOutput = "SQL Error: " . $e->getMessage();
            }
        }

        // **Save Execution in Database**
        ExecutedCode::create([
            'user_id' => $userId,
            'code' => $answer,
            'output' => $userOutput,
            'is_error' => $isError
        ]);

        // **Save Test Performance**
        TestPerformance::create([
            'user_id' => $userId,
            'question_id' => $questionId,
            'answer' => $answer,
            'is_correct' => $isCorrect,
            'points' => $isCorrect ? $difficultyPoints : 0
        ]);

        return response()->json([
            'success' => true,
            'user_output' => $userOutput,
            'expected_output' => $expectedOutput,
            'correct' => $isCorrect,
            'points_awarded' => $isCorrect ? $difficultyPoints : 0
        ]);
    }


}
