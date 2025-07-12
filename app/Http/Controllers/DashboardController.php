<?php

namespace App\Http\Controllers;

use App\Models\CsrAssessment;
use App\Models\CsrIndicator;
use App\Models\CompanyProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
        public function index(Request $request)
    {
        // Validate dates
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Get date range
        $startDate = $request->input('start_date') ? 
            Carbon::parse($request->input('start_date')) : 
            now()->startOfYear();
        
        $endDate = $request->input('end_date') ? 
            Carbon::parse($request->input('end_date')) : 
            now();

        // Get company ID if user is company role
        $companyId = null;
    $userRole = auth()->user()->role;
    
        if ($userRole === 'perusahaan') {
            // Cari profile perusahaan untuk user ini
            $companyProfile = CompanyProfile::where('user_id', auth()->id())->first();
            $companyId = $companyProfile ? $companyProfile->id : null;
        }

        // Dapatkan statistik dasar
        $statistics = $this->getOverviewStatistics($companyId, $startDate, $endDate);
        $categoryScores = $this->getCategoryScores($companyId, $startDate, $endDate);
        $timelineData = $this->getTimelineData($companyId, $startDate, $endDate);
        
        // Data khusus berdasarkan role
        if ($userRole === 'perusahaan') {
            // Data untuk perusahaan
            $recentAssessments = CsrAssessment::where('company_id', $companyId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['indicator', 'reviewer'])
                ->latest()
                ->take(5)
                ->get();
            $isoCompliance = $this->getIsoCompliance($companyId, $startDate, $endDate);
            
        return view('dashboard.index', compact(
            'statistics',
                'categoryScores',
                'recentAssessments',
                'isoCompliance',
                'timelineData',
            'startDate',
            'endDate'
        ));
        } 
        elseif ($userRole === 'admin' || $userRole === 'pemantau') {

            // Tambahkan pengecekan data
    try {
        $recentAssessments = CsrAssessment::whereBetween('created_at', [$startDate, $endDate])
            ->with(['company', 'indicator', 'reviewer'])
            ->latest()
            ->take(10)
            ->get();

        // Pastikan relasi company ada
        $companies = CompanyProfile::whereHas('user')->orderBy('name')->get();
        
        // Tambahkan error handling untuk data yang kosong
        if ($recentAssessments->isEmpty()) {
            $recentAssessments = collect([]);
        }

        return view('dashboard.index', compact(
            'statistics',
            'categoryScores',
            'recentAssessments',
            'isoCompliance',
            'companyRankings',
            'companies',
            'pendingReviews',
            'timelineData',
            'startDate',
            'endDate'
        ));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan dalam memuat data dashboard');
    }


            // Data untuk admin/pemantau
            $recentAssessments = CsrAssessment::whereBetween('created_at', [$startDate, $endDate])
                ->with(['company', 'indicator', 'reviewer'])
                ->latest()
                ->take(10)
                ->get();

            $isoCompliance = $this->getIsoCompliance(null, $startDate, $endDate);
            $companyRankings = $this->getCompanyRankings($startDate, $endDate);
            $companies = CompanyProfile::orderBy('name')->get();
            
            // Data khusus untuk pending review
            $pendingReviews = CsrAssessment::where('status', 'submitted')
                ->with(['company', 'indicator'])
                ->latest()
                ->take(5)
                ->get();
                
    return view('dashboard.index', compact(
        'statistics',
                'categoryScores',
                'recentAssessments',
                'isoCompliance',
                'companyRankings',
                'companies',
                'pendingReviews',
                'timelineData',
        'startDate',
        'endDate'
    ));
}
        elseif ($userRole === 'reviewer') {

            try {
        // Tambahkan with eager loading untuk mengurangi N+1 query
        $recentAssessments = CsrAssessment::with([
                'company:id,name',
                'indicator:id,indicator',
                'reviewer:id,name'
            ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(10)
            ->get();

        // Optimasi query untuk assigned reviews
        $assignedReviews = CsrAssessment::where('status', 'submitted')
            ->with([
                'company:id,name',
                'indicator:id,indicator'
            ])
            ->latest()
            ->take(10)
            ->get();

        // Tambahkan session handling
        session([
            'dashboard_data' => [
                'startDate' => $startDate,
                'endDate' => $endDate
            ]
        ]);

        return view('dashboard.index', compact(
            'statistics',
            'categoryScores',
            'recentAssessments',
            'isoCompliance',
            'companies',
            'pendingReviews',
            'assignedReviews',
            'timelineData',
            'startDate',
            'endDate'
        ))->with('reviewer_id', auth()->id());
    } catch (\Exception $e) {
        \Log::error('Dashboard Reviewer Error: ' . $e->getMessage());
        return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan dalam memuat dashboard reviewer');
    }


            // Data untuk reviewer
            $recentAssessments = CsrAssessment::whereBetween('created_at', [$startDate, $endDate])
                ->with(['company', 'indicator', 'reviewer'])
                ->latest()
            ->take(10)
            ->get();

            $isoCompliance = $this->getIsoCompliance(null, $startDate, $endDate);
            $companies = CompanyProfile::orderBy('name')->get();
            
            // Data khusus untuk pending review
            $pendingReviews = CsrAssessment::where('status', 'submitted')
                ->with(['company', 'indicator'])
                ->latest()
                ->take(5)
                ->get();
                
            // Tambahkan data untuk reviewer: assessments yang perlu direview
            $assignedReviews = CsrAssessment::where('status', 'submitted')
                ->with(['company', 'indicator'])
                ->latest()
                ->take(10)
                ->get();
                
            return view('dashboard.index', compact(
                'statistics',
                'categoryScores',
                'recentAssessments',
                'isoCompliance',
                'companies',
                'pendingReviews',
                'assignedReviews',
                'timelineData',
                'startDate',
                'endDate'
            ));
    }

        // Default view dengan data minimal
        return view('dashboard.index', compact(
            'statistics',
            'categoryScores',
            'timelineData',
            'startDate',
            'endDate'
        ));
}

    // Gunakan method-method yang sudah ada
    private function getOverviewStatistics($companyId, $startDate, $endDate)
    {
        // Query untuk mendapatkan statistik dasar
        $query = CsrAssessment::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($companyId) {
            $query->where('company_id', $companyId);
        }
        
        $totalAssessments = $query->count();
        $averageScore = $query->avg('score') ?: 0;
        $completedReviews = $query->where('status', 'reviewed')->count();
        $pendingReviews = $query->where('status', 'submitted')->count();
        
        return [
            'total_assessments' => $totalAssessments,
            'average_score' => number_format($averageScore, 1),
            'completed_reviews' => $completedReviews,
            'pending_reviews' => $pendingReviews
        ];
    }
    
    private function getCategoryScores($companyId, $startDate, $endDate)
    {
        // Query untuk mendapatkan skor per kategori
        return DB::table('csr_assessments')
            ->join('csr_indicators', 'csr_assessments.indicator_id', '=', 'csr_indicators.id')
            ->join('csr_categories', 'csr_indicators.csr_category_id', '=', 'csr_categories.id')
            ->whereBetween('csr_assessments.created_at', [$startDate, $endDate])
            ->when($companyId, function($query) use ($companyId) {
                return $query->where('csr_assessments.company_id', $companyId);
            })
            ->select(
                'csr_categories.name as category',
                DB::raw('AVG(csr_assessments.score) as average_score')
            )
            ->groupBy('csr_categories.name')
            ->get();
    }
    
    private function getTimelineData($companyId, $startDate, $endDate)
    {
        // Query untuk mendapatkan data timeline
        return DB::table('csr_assessments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($companyId, function($query) use ($companyId) {
                return $query->where('company_id', $companyId);
            })
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('AVG(score) as average_score')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
    
    private function getIsoCompliance($companyId, $startDate, $endDate)
    {
        // Query untuk mendapatkan kepatuhan ISO
        $query = CsrAssessment::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($companyId) {
            $query->where('company_id', $companyId);
        }
        
        $totalAssessments = $query->count();
        $compliantCount = $query->where('score', '>=', 2)->count();
        
        $compliancePercentage = $totalAssessments > 0 
            ? round(($compliantCount / $totalAssessments) * 100) 
            : 0;
        
        return (object)[
            'total_assessments' => $totalAssessments,
            'compliant_count' => $compliantCount,
            'compliance_percentage' => $compliancePercentage
        ];
    }
    
    private function getCompanyRankings($startDate, $endDate)
    {
        // Query untuk mendapatkan peringkat perusahaan
        return DB::table('csr_assessments')
            ->join('company_profiles', 'csr_assessments.company_id', '=', 'company_profiles.id')
            ->whereBetween('csr_assessments.created_at', [$startDate, $endDate])
            ->select(
                'company_profiles.id',
                'company_profiles.name',
                DB::raw('AVG(csr_assessments.score) as average_score'),
                DB::raw('COUNT(csr_assessments.id) as assessment_count')
            )
            ->groupBy('company_profiles.id', 'company_profiles.name')
            ->having('assessment_count', '>', 0)
            ->orderByDesc('average_score')
            ->take(10)
            ->get();
    }
}