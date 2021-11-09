<?php

namespace App\Http\Controllers;

use App\Models\Infrastructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error\Notice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = date("Y-m-d", strtotime(now()));
        $begin_year = date("Y-m-d", strtotime(date("Y")."-01-01"));
        $end_year = date("Y-m-d", strtotime(date("Y")."-12-31"));
        
        $pass_warranty = Infrastructure::where('warranty','<=',$today)->count();
        $pass_warranty_this_year = Infrastructure::where([['warranty', '<=',$end_year],['warranty', '>=',$begin_year]])->count();
        $notifs = Infrastructure::with('InfraType')->whereRaw('warranty BETWEEN NOW() AND (NOW() + INTERVAL 8 MONTH)')->get();
        // dd($notifs);
        $infra_baik = Infrastructure::where('condition','=',1)->count();
        $rusak_ringan = Infrastructure::where('condition','=',2)->count();
        $rusak_sedang = Infrastructure::where('condition','=',3)->count();
        $rusak_berat = Infrastructure::where('condition','=',4)->count();

        // $warranty_notif = Infrastructure::where('warranty','=', $warranty_days)->get();
        // dd(warranty_notif);
        $infra_datas = DB::select('select infra_types.type_name, count(infra_datas.id) as jmlh from infra_datas inner join infra_types on infra_datas.type_id = infra_types.id group by infra_types.type_name');
        // dd($infra_datas);
        $dataPoints = [];

        foreach ($infra_datas as $infra) {
            
            $dataPoints[] = [
                "name" => $infra->type_name,
                "y" => floatval($infra->jmlh)
            ];
        }
        return view('pages.dashboard') ->with([
            'pass_warranty' => $pass_warranty,
            'pass_warranty_this_year' => $pass_warranty_this_year,
            'infra_baik' => $infra_baik,
            'rusak_ringan' => $rusak_ringan,
            'rusak_sedang' => $rusak_sedang,
            'rusak_berat' => $rusak_berat,
            'data' => json_encode($dataPoints),
            'notifs' => $notifs
        ]);
    }
}
