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

    public function mojePrijave()
    {
        if (auth()->user()->role !== 'student') {
            return response()->json(['error' => 'Pristup dozvoljen samo studentima.'], 403);
        }

        $prijave = PrijavaIspita::with(['predmet', 'student'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return PrijavaIspitaResource::collection($prijave);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'student') {
            return response()->json(['error' => 'Pristup dozvoljen samo studentima.'], 403);
        }

        $request->validate([
            'predmet_id' => 'required|exists:predmeti,id',
            'rok' => 'required|integer|between:1,6',
        ]);

        $user = auth()->user();
        $predmetId = $request->predmet_id;

        // Proveri da li studentsluša taj predmet (pivot)
        $slusa = $user->predmeti()->where('predmet_id', $predmetId)->exists();

        if (! $slusa) {
            return response()->json(['error' => 'Ne možete prijaviti ispit iz predmeta koji ne slušate.'], 403);
        }

        // Broj prijave se generiše na osnovu prethodnih prijava za taj predmet
        $postojecih = PrijavaIspita::where('user_id', $user->id)->where('predmet_id', $predmetId)->count();

        $redosled = PrijavaIspita::where('user_id', $user->id)->where('predmet_id', $predmetId)->count() + 1;
  
        $prijava = PrijavaIspita::create([
            'user_id' => $user->id,
            'predmet_id' => $predmetId,
            'rok' => $request->rok,
            'broj_prijave' => $redosled,
            'status' => 'prijavljen',
            'ocena' => null,
        ]);

        return response()->json([
            'message' => 'Ispit uspešno prijavljen.',
            'prijava' => new PrijavaIspitaResource($prijava->load('user', 'predmet'))
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'student') {
            return response()->json(['error' => 'Pristup dozvoljen samo studentima.'], 403);
        }

        $request->validate([
            'rok' => 'required|integer|between:1,6',
        ]);

        $user = auth()->user();

        $prijava = PrijavaIspita::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'prijavljen')
            ->first();

        if (! $prijava) {
            return response()->json(['error' => 'Prijava ne postoji ili nije moguće izmeniti.'], 404);
        }

        $prijava->rok = $request->rok;
        $prijava->save();

        return response()->json([
            'message' => 'Rok za prijavu uspešno izmenjen.',
            'prijava' => new PrijavaIspitaResource($prijava->load('user', 'predmet'))
        ]);
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'student') {
            return response()->json(['error' => 'Pristup dozvoljen samo studentima.'], 403);
        }

        $user = auth()->user();

        $prijava = PrijavaIspita::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'prijavljen')
            ->first();

        if (! $prijava) {
            return response()->json(['error' => 'Prijava ne postoji ili nije moguće poništiti.'], 404);
        }

        $prijava->delete();

        return response()->json(['message' => 'Prijava uspešno poništena.']);
    }

    


}
