<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Note;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Erreur email ou mot de passe'], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;



        // Récupérer les notes associées à l'utilisateur
        $notes = Note::where('user_id', $user->id)->get();
        $id = User::where('id', $user->id)->get();

        return response()->json([
            'message' => 'You are logged in',
            'token' => $token,
            'name' => $user ->name,
            'notes'=>$notes,
            'id'=>$id
        ], 200);


    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'You are logged out']);
    }









}
