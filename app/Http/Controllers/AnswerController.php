<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\StoreRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreRequest $request, $questionId)
    {
        $question = Question::published()->findOrFail($questionId);
        $question->answers()->create([
            'user_id' => auth()->id(),
            'content' => $request['content']
        ]);
        return response()->json([], 201);
    }
}
