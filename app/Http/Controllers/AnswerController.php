<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\StoreRequest;
use App\Models\Answer;
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
        return back();
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return back();
    }
}
