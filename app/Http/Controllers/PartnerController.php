<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPartner;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type = request()->query('type');
        $partners = BusinessPartner::query()->when($type, function ($query, $type) {
            $query->where('type', $type);
        })->orderBy('id')->get();
        return view('partners.index', compact('partners', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'billing_postal' => 'required|string|max:20',
            'billing_address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        BusinessPartner::create($validated);

        return redirect()->route('home')->with('status', '取引先を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
