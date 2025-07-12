<?php

namespace App\Exports;

use App\Models\CsrAssessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CsrAssessmentExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $companyId;
    protected $startDate;
    protected $endDate;

    public function __construct($companyId = null, $startDate = null, $endDate = null)
    {
        $this->companyId = $companyId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return CsrAssessment::with(['company', 'indicator.category', 'reviewer'])
            ->when($this->companyId, function ($query) {
                return $query->where('company_id', $this->companyId);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Perusahaan',
            'Kategori',
            'Indikator',
            'Skor',
            'Status',
            'Reviewer',
            'Tanggal Review',
            'Catatan'
        ];
    }

    public function map($assessment): array
    {
        return [
            $assessment->created_at->format('d/m/Y'),
            $assessment->company->name,
            $assessment->indicator->category->name,
            $assessment->indicator->name,
            $assessment->score,
            ucfirst($assessment->status),
            $assessment->reviewer ? $assessment->reviewer->name : '-',
            $assessment->reviewed_at ? $assessment->reviewed_at->format('d/m/Y') : '-',
            $assessment->notes ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
