<?php

namespace App\Http\Controllers;

use App\Models\CsrAssessment;
use App\Models\CsrIndicator;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CsrAssessmentController extends Controller

{
public function __construct()
{
    $this->authorizeResource(CsrAssessment::class, 'assessment');
}
    public function index()
{
    $this->authorize('viewAny', CsrAssessment::class);
    
    $assessments = CsrAssessment::with(['company', 'indicator', 'reviewer'])
        ->when(auth()->user()->role === 'company', function ($query) {
            return $query->where('company_id', auth()->user()->company_id);
        })
        ->latest()
        ->paginate(10);

    return view('csr.assessments.index', compact('assessments'));
    }

    public function create()
    {
        $company = auth()->user()->company;
        $indicators = CsrIndicator::with('category')->get()
            ->groupBy(function($indicator) {
                return $indicator->category->name;
            });

        return view('csr.assessments.create', compact('company', 'indicators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:csr_indicators,id',
            'score' => 'required|integer|between:0,3',
            'notes' => 'required|string',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        $uploadedFiles = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('csr-documents');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path
                ];
            }
        }

        $assessment = CsrAssessment::create([
            'company_id' => auth()->user()->company_id,
            'indicator_id' => $validated['indicator_id'],
            'score' => $validated['score'],
            'notes' => $validated['notes'],
            'uploaded_documents' => $uploadedFiles,
            'status' => 'submitted'
        ]);

        return redirect()->route('csr-assessments.show', $assessment)
            ->with('success', 'Penilaian berhasil disimpan');
    }

    public function show(CsrAssessment $csrAssessment)
    {
        $this->authorize('view', $csrAssessment);
        
        return view('csr.assessments.show', [
            'assessment' => $csrAssessment->load(['company', 'indicator', 'reviewer'])
        ]);
    }

    public function review(CsrAssessment $assessment)
{
    $this->authorize('review', $assessment);
    
    return view('csr.assessments.review', [
        'assessment' => $assessment->load(['company', 'indicator'])
    ]);
}

public function submitReview(Request $request, CsrAssessment $assessment)
{
    $this->authorize('review', $assessment);
    
    $validated = $request->validate([
        'score' => 'required|integer|between:0,3',
        'review_notes' => 'required|string'
    ]);

    $assessment->update([
        'score' => $validated['score'],
        'notes' => $validated['review_notes'],
        'status' => 'reviewed',
        'reviewed_by' => auth()->id(),
        'reviewed_at' => now()
    ]);

    return redirect()->route('csr-assessments.show', $assessment)
        ->with('success', 'Review berhasil disimpan');
}

public function submit(CsrAssessment $assessment)
{
    $this->authorize('submit', $assessment);
    
    $assessment->update(['status' => 'submitted']);
    
    return redirect()->route('csr-assessments.show', $assessment)
        ->with('success', 'Penilaian berhasil disubmit untuk direview');
    }

    public function destroy(CsrAssessment $csrAssessment)
    {
        $this->authorize('delete', $csrAssessment);

        // Delete uploaded files
        if (!empty($csrAssessment->uploaded_documents)) {
            foreach ($csrAssessment->uploaded_documents as $document) {
                Storage::delete($document['path']);
            }
        }

        $csrAssessment->delete();

        return redirect()->route('csr-assessments.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
}
