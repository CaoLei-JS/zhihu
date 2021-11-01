<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {

    }

    public function show($questionId)
    {
        $question = Question::whereNotNull('published_at')->findOrFail($questionId);
        return view('questions.show', compact('question'));
    }
}
