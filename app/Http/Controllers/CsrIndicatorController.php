<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsrIndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    $validated = $request->validate([
        'category_id' => 'required|exists:csr_categories,id',
        'code' => 'required|string|max:10|unique:csr_indicators',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'required_documents' => 'required|string',
        'is_iso_26000' => 'boolean'
    ]);

    // Convert required_documents string to array
    $validated['required_documents'] = array_filter(
        explode("\n", str_replace("\r", "", $validated['required_documents']))
    );

    CsrIndicator::create($validated);
    return redirect()->route('csr-indicators.index')
        ->with('success', 'Indikator CSR berhasil ditambahkan');
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
    public function update(Request $request, CsrIndicator $csrIndicator)
    {
    $validated = $request->validate([
        'category_id' => 'required|exists:csr_categories,id',
        'code' => 'required|string|max:10|unique:csr_indicators,code,' . $csrIndicator->id,
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'required_documents' => 'required|string',
        'is_iso_26000' => 'boolean'
    ]);

    // Convert required_documents string to array
    $validated['required_documents'] = array_filter(
        explode("\n", str_replace("\r", "", $validated['required_documents']))
    );

    $csrIndicator->update($validated);
    return redirect()->route('csr-indicators.index')
        ->with('success', 'Indikator CSR berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
