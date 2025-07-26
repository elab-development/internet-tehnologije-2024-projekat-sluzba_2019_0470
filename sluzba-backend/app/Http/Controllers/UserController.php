<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        // Dozvoljeno samo službenom radniku
        if (auth()->user()->role !== 'sluzbenik') {
            return response()->json(['error' => 'Pristup dozvoljen samo službenim radnicima.'], 403);
        }

        $studenti = User::where('role', 'student')->get();

        return UserResource::collection($studenti);
    }
}
