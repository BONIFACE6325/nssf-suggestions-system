<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        $regions = Region::all();
        return view('welcome', compact('regions'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to access the dashboard.']);
        }

        // Initialize query
        $query = Feedback::with('region')->latest();

        // Apply region filter for managers
        if ($user->role !== 'admin') {
            $query->where('region_id', $user->region_id);
            $regionName = $user->region->name ?? 'Unknown Region';
        } else {
            $regionName = 'All Regions';
        }

        // Apply date range filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $feedbacks = $query->get();

        // Analytics
        $totalFeedbacks = $feedbacks->count();

        // Distributions (with fallback for empty data)
        $genderDist = $feedbacks->groupBy('gender')->map->count()->toArray() ?: ['ME' => 0, 'MKE' => 0];
        $membershipDist = $feedbacks->groupBy('membership')->map->count()->toArray() ?: [
            'Mwajiriwa' => 0, 'Hiari' => 0, 'Mstaafu' => 0, 'Mtegemezi' => 0, 'Sio Mwanachama' => 0
        ];
        $visitReasonDist = $feedbacks->groupBy('visit_reason')->map->count()->toArray() ?: [
            'Mafao' => 0, 'Usajili' => 0, 'Michango' => 0, 'Nyaraka' => 0
        ];
        $waitingTimeDist = $feedbacks->groupBy('waiting_time')->map->count()->toArray() ?: [
            '0-10' => 0, '10-20' => 0, '20-30' => 0, '30-60' => 0
        ];
        $satisfactionTimeDist = $feedbacks->groupBy('satisfaction_time')->map->count()->toArray() ?: [
            'Nimeridhika sana' => 0, 'Nimeridhika' => 0, 'Sina uhakika' => 0, 'Sijaridhika' => 0, 'Sijaridhika kabisa' => 0
        ];
        $needsMetDist = $feedbacks->groupBy('needs_met')->map->count()->toArray() ?: [
            'Zinakidhi sana' => 0, 'Zinakidhi' => 0, 'Sina hakika' => 0, 'Hazikidhi' => 0, 'Hazikidhi kabisa' => 0
        ];
        $serviceQualityDist = $feedbacks->groupBy('service_quality')->map->count()->toArray() ?: [
            'Zimeboreshwa sana' => 0, 'Zimeboreshwa' => 0, 'Za wastani' => 0, 'Zimedoro' => 0
        ];
        $problemHandlingDist = $feedbacks->groupBy('problem_handling')->map->count()->toArray() ?: [
            'Kwa haraka sana' => 0, 'Kwa haraka' => 0, 'Sina hakika' => 0, 'Taratibu' => 0, 'Taratibu sana' => 0
        ];
        $staffResponsivenessDist = $feedbacks->groupBy('staff_responsiveness')->map->count()->toArray() ?: [
            'Wanawajibika sana' => 0, 'Wanawajibika' => 0, 'Kwa wastani' => 0, 'Hawawajibiki' => 0, 'Hawawajibiki kabisa' => 0
        ];
        $overallSatisfactionDist = $feedbacks->groupBy('overall_satisfaction')->map->count()->toArray() ?: [
            'Ninaridhika sana' => 0, 'Ninaridhika' => 0, 'Sina uhakika' => 0, 'Siridhiki' => 0
        ];

        // Average Satisfaction (mapped to 1-5 scale)
        $satisfactionMap = [
            'Ninaridhika sana' => 5,
            'Ninaridhika' => 4,
            'Sina uhakika' => 3,
            'Siridhiki' => 1, // Assuming typo for 'Sijaridhika'
        ];
        $averageSatisfaction = $feedbacks->avg(function ($feedback) use ($satisfactionMap) {
            return $satisfactionMap[$feedback->overall_satisfaction] ?? 0;
        }) ?: 0;

        // Top Visit Reason
        $topVisitReason = array_key_exists('visit_reason', $visitReasonDist) 
            ? array_keys($visitReasonDist, max($visitReasonDist))[0] 
            : 'None';

        // Recent Feedbacks (last 10)
        $recentFeedbacks = $feedbacks->take(10);

        return view('dashboard', compact(
            'user', 'feedbacks', 'regionName', 'totalFeedbacks', 'genderDist', 'membershipDist',
            'visitReasonDist', 'waitingTimeDist', 'satisfactionTimeDist', 'needsMetDist',
            'serviceQualityDist', 'problemHandlingDist', 'staffResponsivenessDist',
            'overallSatisfactionDist', 'averageSatisfaction', 'topVisitReason', 'recentFeedbacks',
            'startDate', 'endDate'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'gender' => 'required|in:ME,MKE',
            'membership' => 'required|in:Mwajiriwa,Hiari,Mstaafu,Mtegemezi,Sio Mwanachama',
            'visit_reason' => 'required|in:Mafao,Usajili,Michango,Nyaraka',
            'waiting_time' => 'required|in:0-10,10-20,20-30,30-60',
            'satisfaction_time' => 'required|in:Nimeridhika sana,Nimeridhika,Sina uhakika,Sijaridhika,Sijaridhika kabisa',
            'needs_met' => 'required|in:Zinakidhi sana,Zinakidhi,Sina hakika,Hazikidhi,Hazikidhi kabisa',
            'service_quality' => 'required|in:Zimeboreshwa sana,Zimeboreshwa,Za wastani,Zimedoro',
            'problem_handling' => 'required|in:Kwa haraka sana,Kwa haraka,Sina hakika,Taratibu,Taratibu sana',
            'staff_responsiveness' => 'required|in:Wanawajibika sana,Wanawajibika,Kwa wastani,Hawawajibiki,Hawawajibiki kabisa',
            'overall_satisfaction' => 'required|in:Ninaridhika sana,Ninaridhika,Sina uhakika,Siridhiki',
            'suggestions' => 'nullable|string|max:1000',
        ]);

        Feedback::create($validated);

        return redirect()->route('home')->with('success', 'Asante kwa maoni yako!');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $query = Feedback::with('region')->latest();

        if ($user->role !== 'admin') {
            $query->where('region_id', $user->region_id);
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $feedbacks = $query->get();

        $filename = 'feedback_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($feedbacks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Region', 'Gender', 'Membership', 'Visit Reason', 'Waiting Time',
                'Satisfaction Time', 'Needs Met', 'Service Quality', 'Problem Handling',
                'Staff Responsiveness', 'Overall Satisfaction', 'Suggestions', 'Created At'
            ]);

            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $feedback->id,
                    $feedback->region->name ?? 'N/A',
                    $feedback->gender,
                    $feedback->membership,
                    $feedback->visit_reason,
                    $feedback->waiting_time,
                    $feedback->satisfaction_time,
                    $feedback->needs_met,
                    $feedback->service_quality,
                    $feedback->problem_handling,
                    $feedback->staff_responsiveness,
                    $feedback->overall_satisfaction,
                    $feedback->suggestions ?? '',
                    $feedback->created_at->toDateTimeString(),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}