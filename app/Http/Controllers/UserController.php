<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return $this->user->all();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Vérifier si le champ password est présent avant de le hasher
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->user->create($data);
    }

    public function show(string $id)
    {
        return $this->user->find($id);
    }

    public function update(Request $request, string $id)
    {
        $user = $this->user->find($id);

        if (!$user) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $data = $request->all();

        // Vérifier si le mot de passe est présent avant de le hasher
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function destroy(string $id)
    {
        $user = $this->user->find($id);

        if (!$user) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        return $user->delete();
    }
}
