<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAnswersTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_post_an_answer()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $question = Question::factory()->published()->create();
        $this->post("questions/$question->id/answers", [
            'content' => 'This is an answer'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signed_in_user_can_post_an_answer_to_a_published_question()
    {
        $question = Question::factory()->published()->create();
        $this->signIn($user = create(User::class));

        $response = $this->post("/questions/{$question->id}/answers", [
            'content' => 'This is an answer.'
        ]);

        $response->assertStatus(302);

        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);

        $this->assertEquals(1, $question->answers()->count());
    }

    public function test_user_can_not_post_an_answer_to_an_unpublished_question()
    {
        $question = Question::factory()->unpublished()->create();
        $this->signIn($user = create(User::class));
        $response = $this->withExceptionHandling()
            ->post("questions/{$question->id}/answers", [
                'user_id' => $user->id,
                'content' => 'This is an answer'
            ]);
        $response->assertStatus(404);
        $this->assertDatabaseMissing('answers', ['question_id' => $question->id]);
        $this->assertEquals(0, $question->answers()->count());
    }

    public function test_content_is_required_to_post_answers()
    {
        $question = Question::factory()->published()->create();
        $this->signIn($user = create(User::class));
        $response = $this->withExceptionHandling()
            ->post("/questions/{$question->id}/answers", [
                'user_id' => $user->id,
                'content' => null
            ]);
        $response->assertRedirect()
            ->assertSessionHasErrors('content');
    }
}
