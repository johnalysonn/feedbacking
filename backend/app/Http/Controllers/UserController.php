<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();

        return response() -> json([
            'users' => UserResource::collection($users)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);
        $apiKey = Uuid::uuid4();

        $user = User::create([
            'apiKey' => $apiKey,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $currentToken = ($user->tokens)->last();

        return response() -> json([
            'message' => 'Usuário criado com sucesso',
            'apiKey' => $user->apiKey,
            'token' => [
                'value' => $token,
                'db_value' => $currentToken->token
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'message' => 'E-mail ou senha inválidos'
            ]);
        }

        $token = $user->createToken('Usuário Logado')->plainTextToken;

        $currentToken = ($user->tokens)->last();

        return response()->json([
            'message' => 'Usuário logado com sucesso',
            'token' => [
                'value' => $token,
                'db_value' => $currentToken->token
            ]
        ]);

    }

    public function show(Request $request)
    {
        $userAuth = auth()->user();
        $currentTokenName = auth()->user()->currentAccessToken()->token;
        $requestTokenName = $request->token;

        if($currentTokenName === $requestTokenName){
            return response() -> json([
                'message' => 'Usuário encontrado com sucesso',
                'user' => UserResource::make($userAuth),
            ]);
        };

        return response() -> json([
            'message' => 'Erro ao buscar usuário',
            'token' => $request->token
        ]);
    }

    public function generateApiKey(User $user){
        $user -> update([
            'apiKey' => Str::uuid()
        ]);

        return response() -> json([
            'message' => 'ApiKey gerada com sucesso',
            'apiKey' => $user->apiKey
        ]);
    }


}
