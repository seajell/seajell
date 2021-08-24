<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\LoginActivity;
use App\Http\Controllers\Controller;
use App\Models\CertificateViewActivity;
use App\Models\CertificateCollectionHistory;

class StatisticController extends Controller
{
    public function getStatisticToday(Request $request){
        $today = Carbon::now()->format('Y-m-d');
        $totalAdminLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereDate('login_activities.created_at', $today)->where('users.role', 'admin')->orWhere('users.role', 'superadmin')->get()->count();
        $totalParticipantLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereDate('login_activities.created_at', $today)->where('users.role', 'participant')->get()->count();
        $totalCertificateAdded = Certificate::select('id')->whereDate('created_at', $today)->get()->count();
        $certificateCollectionHistory = CertificateCollectionHistory::select('certificates_total')->whereDate('created_at', $today)->get();
        $certificateCollectionHistoryTotal = 0;
        foreach ($certificateCollectionHistory as $key => $value) {
            $certificateCollectionHistoryTotal = $certificateCollectionHistoryTotal + $value['certificates_total'];
        }
        $certificateViewActivityTotal = CertificateViewActivity::select('id')->whereDate('created_at', $today)->get()->count();
        $totalCertificateViewed = $certificateViewActivityTotal + $certificateCollectionHistoryTotal;
        return response()->json([
            'totalParticipantLogin' => $totalParticipantLogin,
            'totalAdminLogin' => $totalAdminLogin,
            'totalLogin' => $totalParticipantLogin + $totalAdminLogin,
            'totalCertificateViewed' => $totalCertificateViewed,
            'totalCertificateAdded' => $totalCertificateAdded,
        ]);
    }

    public function getStatisticMonth(Request $request){
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $totalAdminLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereMonth('login_activities.created_at', $month)->whereYear('login_activities.created_at', $year)->where('users.role', 'admin')->orWhere('users.role', 'superadmin')->get()->count();
        $totalParticipantLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereMonth('login_activities.created_at', $month)->whereYear('login_activities.created_at', $year)->where('users.role', 'participant')->get()->count();
        $totalCertificateAdded = Certificate::select('id')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
        $certificateCollectionHistory = CertificateCollectionHistory::select('certificates_total')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        $certificateCollectionHistoryTotal = 0;
        foreach ($certificateCollectionHistory as $key => $value) {
            $certificateCollectionHistoryTotal = $certificateCollectionHistoryTotal + $value['certificates_total'];
        }
        $certificateViewActivityTotal = CertificateViewActivity::select('id')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
        $totalCertificateViewed = $certificateViewActivityTotal + $certificateCollectionHistoryTotal;
        return response()->json([
            'totalParticipantLogin' => $totalParticipantLogin,
            'totalAdminLogin' => $totalAdminLogin,
            'totalLogin' => $totalParticipantLogin + $totalAdminLogin,
            'totalCertificateViewed' => $totalCertificateViewed,
            'totalCertificateAdded' => $totalCertificateAdded,
        ]);
    }

    public function getStatisticYear(Request $request){
        $year = Carbon::now()->format('Y');

        $totalAdminLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereYear('login_activities.created_at', $year)->where('users.role', 'admin')->orWhere('users.role', 'superadmin')->get()->count();
        $totalParticipantLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->whereYear('login_activities.created_at', $year)->where('users.role', 'participant')->get()->count();
        $totalCertificateAdded = Certificate::select('id')->whereYear('created_at', $year)->get()->count();
        $certificateCollectionHistory = CertificateCollectionHistory::select('certificates_total')->whereYear('created_at', $year)->get();
        $certificateCollectionHistoryTotal = 0;
        foreach ($certificateCollectionHistory as $key => $value) {
            $certificateCollectionHistoryTotal = $certificateCollectionHistoryTotal + $value['certificates_total'];
        }
        $certificateViewActivityTotal = CertificateViewActivity::select('id')->whereYear('created_at', $year)->get()->count();
        $totalCertificateViewed = $certificateViewActivityTotal + $certificateCollectionHistoryTotal;
        return response()->json([
            'totalParticipantLogin' => $totalParticipantLogin,
            'totalAdminLogin' => $totalAdminLogin,
            'totalLogin' => $totalParticipantLogin + $totalAdminLogin,
            'totalCertificateViewed' => $totalCertificateViewed,
            'totalCertificateAdded' => $totalCertificateAdded,
        ]);
    }

    public function getStatisticAll(Request $request){ 
        $totalAdminLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->where('users.role', 'admin')->orWhere('users.role', 'superadmin')->get()->count();
        $totalParticipantLogin = LoginActivity::select('login_activities.id')->join('users', 'login_activities.user_id', '=', 'users.id')->where('users.role', 'participant')->get()->count();
        $totalCertificateAdded = Certificate::select('id')->get()->count();
        $certificateCollectionHistory = CertificateCollectionHistory::select('certificates_total')->get();
        $certificateCollectionHistoryTotal = 0;
        foreach ($certificateCollectionHistory as $key => $value) {
            $certificateCollectionHistoryTotal = $certificateCollectionHistoryTotal + $value['certificates_total'];
        }
        $certificateViewActivityTotal = CertificateViewActivity::select('id')->get()->count();
        $totalCertificateViewed = $certificateViewActivityTotal + $certificateCollectionHistoryTotal;
        return response()->json([
            'totalParticipantLogin' => $totalParticipantLogin,
            'totalAdminLogin' => $totalAdminLogin,
            'totalLogin' => $totalParticipantLogin + $totalAdminLogin,
            'totalCertificateViewed' => $totalCertificateViewed,
            'totalCertificateAdded' => $totalCertificateAdded,
        ]);
    }
}
