<?php

namespace App\Http\Controllers;

use App\Ai\ChatAgent;
use Illuminate\Http\Request;
use Laravel\Ai\Exceptions\RateLimitedException;

class ChatController extends Controller
{
    /**
     * Show the chat page.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.chat')->renderSections()['content'];
        }

        return view('pages.chat');
    }

    /**
     * Send a message to the chat agent and return the response.
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        try {
            $agent = (new ChatAgent)->forUser($request->user());

            $response = $agent->prompt($request->input('message'));

            return response()->json([
                'response' => $response->text,
                'conversation_id' => $response->conversationId,
            ]);
        } catch (RateLimitedException $e) {
            return response()->json([
                'error' => 'The AI provider is currently rate limited. Please wait a moment and try again.',
            ], 429);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Sorry, something went wrong. Please try again.',
            ], 500);
        }
    }
}
