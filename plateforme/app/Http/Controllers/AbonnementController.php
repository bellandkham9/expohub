<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\TestType;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function index()
    {
        $abonnements = abonnement::with('testType')->get();
        return view('client.paiement', compact('abonnements'));
    }

    public function create()
    {
        $testTypes = TestType::all();
        return view('admin.abonnements.create', compact('testTypes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nom_du_plan' => 'required|string|max:255',
            'examen' => 'required|exists:test_types,examen',
            'prix' => 'required|numeric',
            'duree' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        abonnement::create($request->all());
        return redirect()->route('gestion_test')->with('success', 'Abonnement créé avec succès');
    }

    public function edit(abonnement $abonnement)
    {
        $testTypes = TestType::all();
        return view('admin.abonnements.edit', compact('abonnement', 'testTypes'));
    }

    public function update(Request $request, abonnement $abonnement)
    {
        $request->validate([
            'nom_du_plan' => 'required|string|max:255',
            'examen' => 'required|exists:test_types,examen',
            'prix' => 'required|numeric',
            'duree' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $abonnement->update($request->all());
        return redirect()->route('gestion_test')->with('success', 'Abonnement mis à jour');
    }

    public function destroy(abonnement $abonnement)
    {
        $abonnement->delete();
        return redirect()->route('gestion_test')->with('success', 'Abonnement supprimé');
    }

}