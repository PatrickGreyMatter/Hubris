<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Or implement a soft delete if preferred

        return redirect()->route('home')->with('status', 'Utilisateur banni avec succès.');
    }
}

