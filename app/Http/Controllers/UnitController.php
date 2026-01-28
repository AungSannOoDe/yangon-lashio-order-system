<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->simplePaginate(5);
        return view('units', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit' => 'required|string'
        ]);
        if($validator->fails()){
            return back()->with('error', 'အချက်အလက်မှားယွင်းနေပါသည်');
        }
        try{
            $unit = new Unit();
            $unit->name = $request->unit;
            $unit->save();
            return back()->with('success', 'အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');
        }catch(\Exception $e){
            return back()->with('error', 'Unitအမည်ထည့်သွင်းရာတွင် အမှားအယွင်းတစ်ခု ဖြစ်နေပါသည်။');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
