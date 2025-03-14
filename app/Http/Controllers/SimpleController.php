<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class SimpleController extends Controller
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

}
