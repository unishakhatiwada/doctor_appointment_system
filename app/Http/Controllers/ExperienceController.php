<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceStoreUpdateRequest;
use App\Models\Doctor;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::with('doctor')->get(); // Eager load doctors

        return view('experiences.index', compact('experiences'));
    }

    public function create()
    {
        $doctors = Doctor::all(); // Get all doctors for the dropdown

        return view('experiences.create', compact('doctors'));
    }

    public function store(ExperienceStoreUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        dd($request->all());
        $validated = $request->validated();
        foreach ($validated['experience'] as $experience) {
            Experience::create($experience + ['doctor_id' => $request->doctor_id]);
        }

        return response()->json(['message' => 'Experience Info Saved Successfully']);
    }

    public function edit(Experience $experience): View
    {
        $doctors = Doctor::all(); // Get all doctors for the dropdown

        return view('experiences.edit', compact('experience', 'doctors'));
    }

    public function update(ExperienceStoreUpdateRequest $request, Experience $experience): RedirectResponse
    {
        $experience->update($request->validated());

        return redirect()->route('experiences.index')->with('success', 'Experience record updated successfully.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('experiences.index')->with('success', 'Experience record deleted successfully.');
    }
}
