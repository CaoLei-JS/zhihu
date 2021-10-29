<?php

namespace Tests\Feature;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_view_questions()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/questions');

        $response->assertStatus(200);
    }

    public function test_user_can_view_a_single_question()
    {
        $this->withoutExceptionHandling();
        $question = Question::factory()->create();
        $test = $this->get('/questions/' . $question->id);
        $test->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }
}
