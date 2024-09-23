<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationStoreUpdateRequest;
use App\Models\Doctor;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::with('doctor')->get(); // Eager load doctors

        return view('educations.index', compact('educations'));
    }

    public function create()
    {
        $doctors = Doctor::all(); // Get all doctors for the dropdown

        return view('educations.create', compact('doctors'));
    }

    public function store(Request $request)
    {

        Education::create($request->validated());

        return redirect()->route('educations.index')->with('success', 'Education record added successfully.');
    }

    public function edit(Education $education)
    {
        $doctors = Doctor::all(); // Get all doctors for the dropdown

        return view('educations.edit', compact('education', 'doctors'));
    }

    public function update(EducationStoreUpdateRequest $request, Education $education): RedirectResponse
    {
        $education->update($request->validated());

        return redirect()->route('educations.index')->with('success', 'Education record updated successfully.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return redirect()->route('educations.index')->with('success', 'Education record deleted successfully.');
    }
}
