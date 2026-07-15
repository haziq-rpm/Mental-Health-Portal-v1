<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::all();

        return view(
            'admin.specializations.index',
            compact('specializations')
        );
    }

    public function create()
    {
        return view('admin.specializations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'SpecializationName' => 'required|max:100',
            'Description' => 'nullable|max:500'
        ]);

        Specialization::create($request->all());

        return redirect()
            ->route('specializations.index')
            ->with('success','Specialization added.');
    }

    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);

        return view(
            'admin.specializations.edit',
            compact('specialization')
        );
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'SpecializationName'=>'required|max:100',
            'Description'=>'nullable|max:500'
        ]);

        $specialization = Specialization::findOrFail($id);

        $specialization->update($request->all());

        return redirect()
            ->route('specializations.index')
            ->with('success','Updated successfully.');
    }

    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);

        $specialization->delete();

        return redirect()
            ->route('specializations.index')
            ->with('success','Deleted successfully.');
    }
}