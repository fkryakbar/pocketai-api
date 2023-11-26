<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAIController extends Controller
{
    public function grammar(Request $request)
    {
        $request->validate([
            'sentences' => 'required',
        ]);

        $requestBody = [
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a good grammar corrector, and your job is only and only correct my English words, so please check and edit the English words that all I've sent to you and give me a short explanation only if I've made mistakes"
                ],
                [
                    'role' => 'user',
                    'content' => '"' . $request->sentences . '"'
                ]
            ]
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPEN_AI_TOKEN'),
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', $requestBody);

        if ($response->successful()) {
            $responseData = $response->json();
            return response($responseData);
        } else {
            $errorCode = $response->status();
            return response([
                'status' => 'Failed to fetch',
                'message' => 'something went wrong'
            ], $errorCode);
        }
    }


    public function assistant(Request $request)
    {
        $request->validate([
            'sentences' => 'required',
        ]);

        $requestBody = [
            'model' => 'gpt-4-1106-preview',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a good assistant, your task is to help me solve various problems and provide the information I need, help me with everything except math problems, if I ask about math, tell me go to 'Math Solver' page."
                ],
                [
                    'role' => 'user',
                    'content' => $request->sentences
                ]
            ],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPEN_AI_TOKEN'),
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', $requestBody);

        if ($response->successful()) {
            $responseData = $response->json();
            return response($responseData);
        } else {
            $errorCode = $response->status();
            return response([
                'status' => 'Failed to fetch',
                'message' => 'something went wrong'
            ], $errorCode);
        }
    }


    public function translate(Request $request)
    {
        $request->validate([
            'sentences' => 'required',
            'language' => 'required',
        ]);

        $requestBody = [
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a good translator, and your job is only and only translate words I've sent to " . $request->language . " with good translation"
                ],
                [
                    'role' => 'user',
                    'content' => '"' . $request->sentences . '"'
                ]
            ],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPEN_AI_TOKEN'),
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', $requestBody);

        if ($response->successful()) {
            $responseData = $response->json();
            return response($responseData);
        } else {
            $errorCode = $response->status();
            return response([
                'status' => 'Failed to fetch',
                'message' => 'something went wrong'
            ], $errorCode);
        }
    }
    public function rephrase(Request $request)
    {
        $request->validate([
            'sentences' => 'required',
        ]);

        $requestBody = [
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Your job is only and only to translate the words or sentences I send to you. Match the language with the language I send."
                ],
                [
                    'role' => 'user',
                    'content' => '"' . $request->sentences . '"'
                ]
            ],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPEN_AI_TOKEN'),
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', $requestBody);

        if ($response->successful()) {
            $responseData = $response->json();
            return response($responseData);
        } else {
            $errorCode = $response->status();
            return response([
                'status' => 'Failed to fetch',
                'message' => 'something went wrong'
            ], $errorCode);
        }
    }
    public function math(Request $request)
    {
        $request->validate([
            'sentences' => 'required',
        ]);

        $requestBody = [
            'model' => 'gpt-4-1106-preview',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a mathematics problem solver, your job is only and only to solve mathematics problems, give me the answer with latex format. Do not solve any problems other than mathematics."
                ],
                [
                    'role' => 'user',
                    'content' => $request->sentences
                ]
            ],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPEN_AI_TOKEN'),
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', $requestBody);

        if ($response->successful()) {
            $responseData = $response->json();
            return response($responseData);
        } else {
            $errorCode = $response->status();
            return response([
                'status' => 'Failed to fetch',
                'message' => 'something went wrong'
            ], $errorCode);
        }
    }
}
