<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $student = Student::where('email', trim($request->email))->first(); // trim() pour éviter les espaces

    if (!$student) {
        return response()->json(['message' => 'Email non trouvé'], 401);
    }

    dd([
        'input_password' => $request->password,
        'stored_password' => $student->password,
        'hash_check' => Hash::check($request->password, $student->password)
    ]);

    if (!Hash::check($request->password, $student->password)) {
        return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
    }

    $token = $student->createToken('authToken')->plainTextToken;

    return response()->json([
        'message' => 'Connexion réussie',
        'token' => $token
    ], 200);
}
}
