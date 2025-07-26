<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrijavaIspita;
use App\Http\Resources\PrijavaIspitaResource;

class PrijavaIspitaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'sluzbenik') {
            return response()->json(['error' => 'Pristup dozvoljen samo službenim radnicima.'], 403);
        }

        $prijave = PrijavaIspita::with(['user', 'predmet'])->get();

        return PrijavaIspitaResource::collection($prijave);
    }


    public function updateOcena(Request $request, $id)
    {
        if (auth()->user()->role !== 'sluzbenik') {
            return response()->json(['error' => 'Pristup dozvoljen samo službenim radnicima'], 403);
        }

        $request->validate([
            'ocena' => 'required|integer|between:5,10',
            'status' => 'required|string|in:polozen,nepolozen',
        ]);

        $prijava = PrijavaIspita::findOrFail($id);


        $prijava->ocena = $request->ocena;
        $prijava->status = $request->status;
        $prijava->save();

        return response()->json([
            'message' => "Ocena je uspešno azurirana",
            'prijava' => new PrijavaIspitaResource($prijava->load(['user', 'predmet']))
        ]);
    }
}
