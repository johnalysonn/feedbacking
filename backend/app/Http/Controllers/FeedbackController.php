<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Resources\FeedbackResource;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->type){
            $type = $request->type;
            $feedbacks = Feedback::where('type', $type)->get();

            if($feedbacks->count() > 0){
                return response() -> json([
                    'message' => 'Feedbacks do tipo '.$type.' exibidos com sucesso',
                    'response' => FeedbackResource::collection($feedbacks),
                ]);
            }

            return response() -> json([
                'message' => 'Não há feedbacks do tipo '.$type,
            ]);

        }
        $feedbacks = Feedback::all();

        return response() -> json([
            'request' => $request->all(),
            'message' => 'Feedbacks exibidos com sucesso',
            'response' => FeedbackResource::collection($feedbacks)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'text' => 'required|string',
            'fingerprint' => 'numeric',
            'device' => 'required|string',
            'page' => 'required|string'
        ]);

        $user = auth()->user();

        $data['apiKey'] = $user->apiKey;
        $data['user_id'] = $user->id;

        if($data['type'] !== 'issue' || $data['type'] !== 'idea' || $data['type'] !== 'other'){
            return response() -> json([
                'Error' => 'Tipo de feedback '. $data['type'].' não aceito',
                'Status' => 400
            ], 400);
        }
        if(Feedback::create($data)){
            return response() -> json([
                'message' => 'Feedback criado com sucesso',
                'Feedback' => $data
            ]);
        }

        return response() -> json([
            'Error' => 'Erro ao criar feedback',
            'Status' => 400
        ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
    public function summary(){
        $feedbacks = Feedback::all();
        $feedbacks_issue = Feedback::where('type', 'issue')->get();
        $feedbacks_idea = Feedback::where('type', 'idea')->get();
        $feedbacks_other = Feedback::where('type', 'other')->get();

        $type = [
           'all' => 0,
            'issue' => 0,
            'idea' => 0,
            'other' => 0
        ];

        $type['all'] = count($feedbacks);
        $type['issue'] = count($feedbacks_issue);
        $type['idea'] = count($feedbacks_idea);
        $type['other'] = count($feedbacks_other);

        return response()->json([
            'message' => 'Sumário exibido com sucesso',
            'response' => $type
        ]);
    }
}
