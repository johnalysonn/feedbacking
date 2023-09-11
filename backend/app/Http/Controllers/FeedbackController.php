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
        $pagination = [
            'limit' => 0,
            'offset' => 0,
            'total' => 0
        ];

        if($request->type){
            $type = $request->type;

            $feedbacks = Feedback::where('type', $type)->get();

            if($request -> limit){
                $pagination['limit'] = $request -> limit;
                $pagination['offset'] = $request->offset;
                $allFeedbacks =  Feedback::where('type', $type) -> get();
                $feedbacks = Feedback::where('type', $type)->skip($pagination['offset'])->take($pagination['limit'])->get();

                $pagination['total'] = $allFeedbacks->count();
                if($feedbacks->count() <= 0){
                    return response() -> json([
                        'message' => 'Não há mais feedbacks do tipo '.$type.' ou esse tipo não existe',
                    ]);
                }
            }

            if($feedbacks->count() > 0){
                return response() -> json([
                    'message' => 'Feedbacks do tipo '.$type.' exibidos com sucesso',
                    'pagination' => $pagination,
                    'response' => FeedbackResource::collection($feedbacks),
                ]);
            }

            return response() -> json([
                'message' => 'Não há feedbacks do tipo '.$type,
            ]);

        }
        $feedbacks = Feedback::all();

        if($request -> limit){
            $pagination['limit'] = $request -> limit;
            $pagination['offset'] = $request->offset;

            $allFeedbacks = Feedback::all();

            $pagination['total'] = $allFeedbacks->count();
            $feedbacks = Feedback::skip($pagination['offset'])->take($pagination['limit'])->get();

            if($feedbacks->count() <= 0){
                return response() -> json([
                    'message' => 'Não há mais feedbacks',
                ]);
            }
        }

        return response() -> json([
            'request' => $request->all(),
            'message' => 'Feedbacks exibidos com sucesso',
            'pagination' => $pagination,
            'response' => FeedbackResource::collection($feedbacks)
        ]);
    }


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

        if($data['type'] !== 'issue' && $data['type'] !== 'idea' && $data['type'] !== 'other'){
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
