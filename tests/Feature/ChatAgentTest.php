<?php

namespace Tests\Feature;

use App\Ai\ChatAgent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Ai\Enums\Lab;
use Tests\TestCase;

class ChatAgentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_prompt_the_chat_agent(): void
    {
        $user = User::factory()->create();

        $agent = (new ChatAgent)->forUser($user);

        $response = $agent->prompt('Hello, who are you?');

        $this->assertNotEmpty($response->text);
        $this->assertNotNull($response->conversationId);
    }

    /** @test */
    public function it_remembers_conversation_context(): void
    {
        $user = User::factory()->create();

        $agent = (new ChatAgent)->forUser($user);

        $first = $agent->prompt('What is my name?');
        $second = $agent->continue($first->conversationId, as: $user)->prompt('Can you remind me?');

        $this->assertNotEmpty($first->conversationId);
        $this->assertEquals($first->conversationId, $second->conversationId);
    }

    /** @test */
    public function it_can_use_a_specific_provider(): void
    {
        $user = User::factory()->create();

        $agent = (new ChatAgent)->forUser($user);

        $response = $agent->prompt('Say hello.', provider: Lab::Anthropic);

        $this->assertNotEmpty($response->text);
    }
}
