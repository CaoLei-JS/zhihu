<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BestAnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guests_can_not_mark_best_answer()
    {
        $this->expectException(AuthenticationException::class);
        $question = create(Question::class);
        $answer = create(Answer::class, ['question_id' => $question->id], 2);
        $this->post(route('best-answers.store', ['answer' => $answer[1]]), [$answer[1]]);
    }

    public function test_can_mark_one_answer_as_the_best()
    {
        $this->signIn();
        $question = create(Question::class, ['user_id' => auth()->id()]);
        $answers = create(Answer::class, ['question_id' => $question->id], 2);
        $this->assertFalse($answers[0]->isBest());
        $this->assertFalse($answers[1]->isBest());
        $this->postJson(route('best-answers.store', ['answer' => $answers[1]]), [$answers[1]]);
        $this->assertFalse($answers[0]->refresh()->isBest());
        $this->assertTrue($answers[1]->refresh()->isBest());
    }
}
