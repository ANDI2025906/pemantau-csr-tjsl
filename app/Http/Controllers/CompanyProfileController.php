<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\City;
use App\Models\CompanyProfile;
use App\Models\CompanyDetail;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $user = auth()->user();
        $profile = CompanyProfile::where('user_id', $user->id)->first();
        $details = CompanyDetail::where('user_id', $user->id)->first();

        return view('company-profile.create', compact('provinces', 'profile', 'details'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'category' => 'required|in:BUMN,BUMD,SWASTA',
            'business_type' => 'required|string|max:255',
            'head_office_province' => 'required|exists:provinces,id',
            'head_office_city' => 'required|exists:cities,id',
            'operational_province' => 'required|exists:provinces,id',
            'operational_city' => 'required|exists:cities,id',
            'employee_count' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact_name' => 'required|string|max:255',
            'contact_position' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
        ]);

        $user = auth()->user();

        // Update or create company profile
        CompanyProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => $request->company_name,
                // add other basic profile fields here
            ]
        );

        // Update or create company details
        CompanyDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'category' => $request->category,
                'business_type' => $request->business_type,
                'head_office_province' => $request->head_office_province,
                'head_office_city' => $request->head_office_city,
                'operational_province' => $request->operational_province,
                'operational_city' => $request->operational_city,
                'employee_count' => $request->employee_count,
                'established_year' => $request->established_year,
                'contact_name' => $request->contact_name,
                'contact_position' => $request->contact_position,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
            ]
        );

        return redirect()->route('dashboard')
            ->with('success', 'Data perusahaan berhasil disimpan!');
    }
}
