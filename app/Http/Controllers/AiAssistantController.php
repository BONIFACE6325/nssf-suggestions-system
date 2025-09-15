<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiAssistantController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(120)->post(
                'https://gwakila63-nssf-suggestion-system.hf.space/api/predict',
                [
                    'data' => [$userMessage]
                ]
            );

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Failed to connect to Hugging Face Space API',
                    'details' => $response->body()
                ], 500);
            }

            $data = $response->json();

            $answer = $data['data'][0] ?? 'No valid response from Hugging Face Space';

            return response()->json([
                'reply' => $answer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception occurred',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
