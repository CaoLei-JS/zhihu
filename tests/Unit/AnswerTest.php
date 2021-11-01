<?php

namespace Tests\Unit;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_knows_if_it_is_the_best()
    {
        $answer = create(Answer::class);
        $this->assertFalse($answer->isBest());
        $answer->question->update(['best_answer_id' => $answer->id]);
        $this->assertTrue($answer->isBest());
    }

    public function test_an_answer_belongs_to_a_question()
    {
        $answer = create(Answer::class);
        $this->assertInstanceOf(BelongsTo::class, $answer->question());
    }
}
