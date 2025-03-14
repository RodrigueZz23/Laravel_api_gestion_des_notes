<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\User;

class NoteController extends Controller
{
    protected $note;

    public function __construct()
    {
        $this->note = new Note();
    }

    public function getUsers()
{
    // Récupérer tous les utilisateurs avec leur id et name
    $users = User::select('id', 'name')->get();

    return response()->json([
        'user_ids' => $users
    ], 200);
}

    public function store(Request $request)
    {
        $data = $request->all();

        return $this->note->create($data);
    }






}
