<?php

namespace App\Http\Controllers\API\Answer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{

    /**
     * AnswerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnswerRequest $request
     * @return JsonResponse
     */
    public function store(AnswerRequest $request): JsonResponse
    {
        $thread_id = $request->input('thread_id');
        Answer::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'thread_id' => $thread_id,
        ]);

        Thread::query()->where('id', $thread_id)->increment('replies_count');

        return response()->json([
            'created' => true,
            'massage' => 'answer created successfully'
        ], Response::HTTP_CREATED);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Answer $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer): JsonResponse
    {
        $answer->delete();

        return response()->json([
            'status' => true,
            'massage' => 'answer deleted successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AnswerRequest $request
     * @param Answer $answer
     * @return JsonResponse
     *
     */
    public function update(AnswerRequest $request, Answer $answer): JsonResponse
    {
        $answer->update([
            'content' => $request->input('content')
        ]);

        return response()->json([
            'status' => true,
            'massage' => 'answer updated successfully'
        ], Response::HTTP_OK);
    }
}