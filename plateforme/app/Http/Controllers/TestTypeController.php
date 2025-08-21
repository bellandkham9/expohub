<?php

namespace App\Http\Controllers;

use App\Models\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    public function create()
    {
        $testTypes = TestType::all();
        return view('admin.tests.create', compact('testTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'examen' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TestType::create([
            'examen' => $request->examen,
            'description' => $request->description,
        ]);

        return redirect()->route('gestion_test')->with('success', 'Test créé avec succès');
    }

    public function edit(TestType $test)
    {
        $testTypes = TestType::all();
        return view('admin.tests.edit', compact('test', 'testTypes'));
    }

    public function update(Request $request, TestType $test)
    {
        $request->validate([
            'examen' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update([
            'examen' => $request->examen,
            'description' => $request->description,
        ]);

        return redirect()->route('gestion_test')->with('success', 'Test mis à jour');
    }

    public function destroy(TestType $test)
    {
        $test->delete();
        return redirect()->route('gestion_test')->with('success', 'Test supprimé');
    }
}
