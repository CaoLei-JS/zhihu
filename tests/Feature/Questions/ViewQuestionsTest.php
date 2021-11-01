<?php

namespace Tests\Feature\Questions;

use App\Models\Answer;
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

    public function test_can_see_answers_when_view_a_published_question()
    {
        $question = Question::factory()->published()->create();
        create(Answer::class, ['question_id' => $question->id], 40);
        $response = $this->get("/questions/$question->id");
        $result = $response->data('answers')->toArray();
        $this->assertCount(20, $result['data']);
        $this->assertEquals(40, $result['total']);
    }
}
