<?php

namespace App\Http\Controllers\CodeExecution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodeExecutionController extends Controller
{
    // public function execute(Request $request)
    // {
    //     \Log::info($request->all());
    //     $code = $request->input('code');

    //     if (!$code) {
    //         return response()->json(['error' => 'No code provided.', 'message' => 'Please send valid PHP code.'], 400);
    //     }

    //     // Start output buffering
    //     ob_start();

    //     try {
    //         // Allow full PHP code execution using eval()
    //         eval($code); // Execute PHP code directly
    //         $output = ob_get_clean(); // Get the output
    //         return response()->json(['output' => $output]); // Return the result of the code execution
    //     } catch (\ParseError $e) {
    //         ob_end_clean(); // Clear output on error
    //         return response()->json([
    //             'error' => 'Syntax error in PHP code.',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     } catch (\Throwable $e) {
    //         ob_end_clean(); // Clear output on error
    //         return response()->json([
    //             'error' => 'Runtime error in PHP code.',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function execute(Request $request)
    {
        \Log::info($request->all());

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
            $line = $e->getLine() - 1; // Adjust for wrapper line offset
            $formattedMessage = "Parse error: syntax error, line {$line} " . $e->getMessage();

            return response()->json([
                'error' => 'Syntax error in PHP code.',
                'message' => $formattedMessage,
                'line' => $line,
                'code_snippet' => $this->getCodeSnippet($code, $line),
                'code' => 500
            ], 500);
        }

        // Start output buffering for execution
        ob_start();

        try {
            eval($code);
            $executionOutput = ob_get_clean(); // Get the output

            return response()->json([
                'output' => trim($executionOutput) // Remove extra spaces/newlines
            ], 200);
        } catch (\ParseError $e) {
            ob_end_clean(); // Clear buffer
            $line = $e->getLine();
            $formattedMessage = "Parse error: syntax error, line {$line} " . $e->getMessage();

            return response()->json([
                'error' => 'Syntax error in PHP code.',
                'message' => $formattedMessage,
                'line' => $line,
                'code_snippet' => $this->getCodeSnippet($code, $line),
                'code' => 500
            ], 500);
        } catch (\Throwable $e) {
            ob_end_clean(); // Clear buffer
            $line = $e->getLine();
            $formattedMessage = "Runtime error: line {$line} " . $e->getMessage();

            return response()->json([
                'error' => 'Runtime error in PHP code.',
                'message' => $formattedMessage,
                'line' => $line,
                'code_snippet' => $this->getCodeSnippet($code, $line),
                'code' => 500
            ], 500);
        }
    }

    /**
     * Extracts the code snippet for the error line.
     */
    private function getCodeSnippet($code, $line)
    {
        $codeLines = explode("\n", $code);
        return isset($codeLines[$line - 1]) ? trim($codeLines[$line - 1]) : "Unavailable";
    }

//     public function execute(Request $request)
// {
//     \Log::info($request->all());
//     $code = $request->input('code');
//     $expectedOutput = $request->input('expected_output'); // Get expected output from request

//     if (!$code) {
//         return response()->json(['error' => 'No code provided.', 'message' => 'Please send valid PHP code.'], 400);
//     }

//     if (is_null($expectedOutput)) {
//         return response()->json(['error' => 'No expected output provided.', 'message' => 'Please provide an expected output.'], 400);
//     }

//     // Start output buffering
//     ob_start();

//     try {
//         eval($code); // Execute PHP code
//         $output = ob_get_clean(); // Get the output

//         if ($output === $expectedOutput) {
//             return response()->json([
//                 'output' => $output,
//                 'message' => 'Congrats! The output matches the expected output.'
//             ]);
//         } else {
//             return response()->json([
//                 'error' => 'Output does not match expected output.',
//                 'expected' => $expectedOutput,
//                 'actual' => $output
//             ], 400);
//         }
//     } catch (\ParseError $e) {
//         ob_end_clean(); // Clear output on error
//         return response()->json([
//             'error' => 'Syntax error in PHP code.',
//             'message' => $e->getMessage()
//         ], 500);
//     } catch (\Throwable $e) {
//         ob_end_clean(); // Clear output on error
//         return response()->json([
//             'error' => 'Runtime error in PHP code.',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }


}
