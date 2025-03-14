<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    public function index()
    {
        return $this->student->all();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Vérifier si le champ password est présent avant de le hasher
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->student->create($data);
    }

    public function show(string $id)
    {
        return $this->student->find($id);
    }

    public function update(Request $request, string $id)
    {
        $student = $this->student->find($id);

        if (!$student) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $data = $request->all();

        // Vérifier si le mot de passe est présent avant de le hasher
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $student->update($data);

        return $student;
    }

    public function destroy(string $id)
    {
        $student = $this->student->find($id);

        if (!$student) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        return $student->delete();
    }
}
