<?php

namespace Tests\Feature;

use App\Models\Question;
use Carbon\Carbon;
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

    public function test_user_can_view_a_published_question()
    {
        $question = Question::factory()->create([
            'published_at' => Carbon::parse('-1 week')
        ]);
        $this->get('/questions/' . $question->id)
            ->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }

    public function test_user_cannot_view_unpublished_question()
    {
        $question = Question::factory()->create(['published_at' => null]);
        $this->withExceptionHandling()
            ->get('/questions/' . $question->id)
            ->assertStatus(404);
    }
}
