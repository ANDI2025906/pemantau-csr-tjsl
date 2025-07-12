<?php

namespace App\Http\Controllers;

use App\Models\CsrCategory;
use Illuminate\Http\Request;

class CsrCategoryController extends Controller
{
    public function index()
    {
        $categories = CsrCategory::with('indicators')->get();
        return view('csr.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('csr.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:csr_categories',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        CsrCategory::create($validated);
        return redirect()->route('csr-categories.index')
            ->with('success', 'Kategori CSR berhasil ditambahkan');
    }

    public function edit(CsrCategory $csrCategory)
    {
        return view('csr.categories.edit', compact('csrCategory'));
    }

    public function update(Request $request, CsrCategory $csrCategory)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:csr_categories,code,' . $csrCategory->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $csrCategory->update($validated);
        return redirect()->route('csr-categories.index')
            ->with('success', 'Kategori CSR berhasil diperbarui');
    }

    public function destroy(CsrCategory $csrCategory)
    {
        if ($csrCategory->indicators()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki indikator');
        }

        $csrCategory->delete();
        return redirect()->route('csr-categories.index')
            ->with('success', 'Kategori CSR berhasil dihapus');
    }
}
