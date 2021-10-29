<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
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
}
