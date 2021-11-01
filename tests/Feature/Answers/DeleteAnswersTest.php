<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAnswersTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_delete_answers()
    {
        $this->withExceptionHandling();
        $answer = create(Answer::class);
        $this->delete(route('answers.destroy', ['answer' => $answer]))
            ->assertRedirect('login');
    }

    public function test_unauthorized_user_cannot_delete_answers()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $answer = create(Answer::class);
        $this->delete(route('answers.destroy', ['answer' => $answer]))
            ->assertStatus(403);
    }

    public function test_authorized_user_can_delete_answers()
    {
        $this->signIn();
        $answer = create(Answer::class, ['user_id' => auth()->id()]);
        $this->delete(route('answers.destroy', ['answer' => $answer]));
        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
    }
}
