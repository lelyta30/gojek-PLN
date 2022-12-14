<?php

namespace App\Http\Controllers\Manager;

use App\Exports\ExportRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserRequest;
use App\Models\FollowedUpRequest;
use App\Models\VerifiedRequest;
use Maatwebsite\Excel\Facades\Excel;

class ManagerDashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $req_today_count                    = UserRequest::where('request_created_date', date('Y-m-d'))
        ->count();
        $req_not_finished_yet_today_count   = FollowedUpRequest::whereHas('user_request', function($query) {
            $query->where([
                ['request_created_date', '=', date('Y-m-d')],
                ['is_done',              '=', 'BELUM SELESAI']
            ]);
        })->count();

        // App\Referential::whereHas('certifications.users', function($query) use($user) {
        //     $query->where('users.id', $user->id);
        //  });
        $req_alltime_count                  = UserRequest::count();
        $req_not_finished_yet_alltime_count = FollowedUpRequest::where('is_done', 'BELUM SELESAI')->count();

        $req_today            = VerifiedRequest::whereHas('followed_up_request', function($query){
            $query->whereHas('user_request', function($query2){
                $query2->where('request_created_date', date('Y-m-d'));
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(3);

        // $req_not_finished_yet = FollowedUpRequest::where('is_done', 'BELUM SELESAI')
        $req_not_finished_yet = VerifiedRequest::whereHas('followed_up_request', function($query){
            $query->where('is_done', 'BELUM SELESAI');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(3);

        return view('pages.manager.dashboard', [
            'req_today_count'                   => $req_today_count,
            'req_not_finished_yet_today_count'  => $req_not_finished_yet_today_count,
            'req_alltime_count'                 => $req_alltime_count,
            'req_not_finished_yet_alltime_count'=> $req_not_finished_yet_today_count,
            'req_today'                         => $req_today,
            'req_not_finished_yet'              => $req_not_finished_yet,
        ]);
    }

    public function getData($awal, $akhir)
    {
        $userrequest = UserRequest::with('user')->orderBy('request_created_date', 'desc')->whereBetween('request_created_date', [$awal, $akhir])->get();

        $data = array();
        $no = 0;
        foreach ($userrequest as $req) {
            $row = array();
            $row['DT_RowIndex'] = ++$no;
            $row['id'] = $req->id;
            $row['tanggal_request'] = $req->request_created_date;
            $row['jenis_permohonan'] = $req->jenis_permintaan;
            $row['nama_penyervis'] = $req->user->name;
            $row['deskripsi'] = $req->description;
            $row['status'] = $req->status;
            $row['rating'] = $req->rating;

            $data[] = $row;
        }

        // dd($data);
        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportExcel($awal, $akhir){
        $data = $this->getData($awal, $akhir);
        $export = new ExportRequest([$data]);

        return Excel::download($export, $awal. '--'. $akhir .'.xlsx');
    }
}
