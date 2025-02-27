<?php

namespace App\Http\Controllers\CodeExecution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExecutedCode;
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


}
