<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_question_has_many_answers()
    {
        $question = Question::factory()->create();
        Answer::factory()->create(['question_id' => $question->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $question->answers());
    }

    public function test_questions_with_published_at_date_are_published()
    {
        $publishedQuestion1 = Question::factory()->published()->create();
        $publishedQuestion2 = Question::factory()->published()->create();
        $unpublishedQuestion = Question::factory()->unpublished()->create();
        $publishedQuestions = Question::published()->get();
        $this->assertTrue($publishedQuestions->contains($publishedQuestion1));
        $this->assertTrue($publishedQuestions->contains($publishedQuestion2));
        $this->assertFalse($publishedQuestions->contains($unpublishedQuestion));
    }

    public function test_can_mark_an_answer_as_best()
    {
        $question = create(Question::class, ['best_answer_id' => null]);
        $answer = create(Answer::class, ['question_id' => $question->id]);
        $question->markAsBestAnswer($answer);
        $this->assertEquals($question->best_answer_id, $answer->id);
    }
}
