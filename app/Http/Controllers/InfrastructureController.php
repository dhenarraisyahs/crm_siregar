<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfrastructureRequest;
use App\Models\Infrastructure;
use App\Models\InfraType;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WarrantyExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InfrastructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $types = InfraType::all();
        // dd($types);
        return view('pages.infra_data.index', compact('types'));
    }

    public function data(Request $request)
    {
        // dd('masuk fungsi');
        if ($request->ajax()) {
            $data = Infrastructure::with('InfraType')->get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRecord">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteRecord">Delete</a>';

                    return $btn;
                })
                ->editColumn('condition', function ($row) {

                    $conditions = array("-" => "-", "1" => "Baik", "2" => "Rusak Ringan", "3" => "Rusak Sedang", "4" => "Rusak Berat");
                    $arr_badge = array("-" => "badge-primary", "1" => "badge-success", "2" => "badge-warning", "3" => "badge-danger", "4" => "badge-primary");
                    $status = $row->condition == null ? '-' : $row->condition;

                    // $field = '<span class="badge '. $arr_badge[$status] .'">'. $conditions[$status] .'</span>';
                    $field = $conditions[$status];
                    return $field;
                })
                ->editColumn('type_id', function ($row) {
                    return ucfirst($row->InfraType->type_name ?? "(type_not_found)");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function indexReport()
    {
        $items = Infrastructure::with('InfraType')->orderBy('type_id', 'desc')->get();
        // dd($items);
        return view('pages.infra_data.report_all')->with(['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $today = date("Y-m-d", strtotime(now()));
        $begin_year = date("Y-m-d", strtotime(date("Y") . "-01-01"));
        $end_year = date("Y-m-d", strtotime(date("Y") . "-12-31"));
        $items = Infrastructure::where('warranty', '<', date("Y-m-d", strtotime(now())))->get();
        $items_exp = Infrastructure::with('InfraType')->whereRaw('warranty BETWEEN NOW() AND (NOW() + INTERVAL 8 MONTH)')->get();
        // dd($infras);
        return view('pages.infra_data.report_warranty')->with(['items' => $items, 'items_exp' => $items_exp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InfrastructureRequest $request)
    {
        Infrastructure::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'type_id' => $request->type_id,
                'brand' => $request->brand,
                'function' => $request->function,
                'application' => $request->application,
                'serialnum' => $request->serialnum,
                'location' => $request->location,
                'warranty' => $request->warranty,
                'condition' => $request->condition,
                'ip' => $request->ip,
                'description' => $request->description
            ]
        );

        return response()->json(['success' => 'Data saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infra = Infrastructure::find($id);
        return response()->json($infra);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Infrastructure::find($id)->delete();

        return response()->json(['success' => 'Data deleted!']);
    }

    public function export_excel()
    {
        $begin_year = date("Y-m-d", strtotime(date("Y") . "-01-01"));
        $end_year = date("Y-m-d", strtotime(date("Y") . "-12-31"));
        $data = Infrastructure::where('warranty', '<', date("Y-m-d", strtotime(now())))->get();
        $data_exp = Infrastructure::with('InfraType')->whereRaw('warranty BETWEEN NOW() AND (NOW() + INTERVAL 8 MONTH)')->get();
        $kondisi = 'Baik';
        $sts_warranty = 'Expired';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN INFRASTRUKTUR');
        $sheet->mergeCells("A1:G1");
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);

        $sheet->setCellValue('A2', 'MASA GARANSI');
        $sheet->mergeCells("A2:G2");
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);

        $sheet->setCellValue('A3', 's.d ' . date("M Y", strtotime(now())));
        $sheet->mergeCells("A3:G3");
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getFont()->setBold(true);

        $sheet->setCellValue('A5', 'Data Infrastruktur Yang Telah Habis Masa Garansinya');
        $sheet->getStyle('A5')->getFont()->setBold(true);

        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Merek & Tipe');
        $sheet->setCellValue('C6', 'Fungsi');
        $sheet->setCellValue('D6', 'Serial Number');
        $sheet->setCellValue('E6', 'Masa Aktif Warranty');
        $sheet->setCellValue('F6', 'Kondisi');
        $sheet->setCellValue('G6', 'Status Garansi');

        $i = 7;
        $no = 1;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $value['brand']);
            $sheet->setCellValue('C' . $i, $value['function']);
            $sheet->setCellValue('D' . $i, $value['serialnum']);
            $sheet->setCellValue('E' . $i, $value['warranty']);
            if ($value['condition'] == 4) {
                $kondisi = 'Rusak Berat';
            } else if ($value['condition'] == 3) {
                $kondisi = 'Rusak Sedang';
            } else if ($value['condition'] == 2) {
                $kondisi = 'Rusak Ringan';
            } else {
                $kondisi = 'Baik';
            }
            $sheet->setCellValue('F' . $i, $kondisi);
            if ($value['warranty'] <= date("Y-m-d", strtotime(now()))) {
                $sts_warranty = 'Expired';
            } else {
                $sts_warranty = 'Aktif';
            }
            $sheet->setCellValue('G' . $i, $sts_warranty);
            $i++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $i -= 1;
        $sheet->getStyle('A6:G' . $i)->applyFromArray($styleArray);

        $i += 3;
        $j = $i + 1;
        $sheet->setCellValue('A' . $i, 'Data Infrastruktur Yang Akan Habis Masa Garansinya Tahun Ini');
        $sheet->getStyle('A' . $i)->getFont()->setBold(true);
        $i += 1;
        $sheet->setCellValue('A' . $i, 'No');
        $sheet->setCellValue('B' . $i, 'Merek & Tipe');
        $sheet->setCellValue('C' . $i, 'Fungsi');
        $sheet->setCellValue('D' . $i, 'Serial Number');
        $sheet->setCellValue('E' . $i, 'Masa Aktif Warranty');
        $sheet->setCellValue('F' . $i, 'Kondisi');
        $sheet->setCellValue('G' . $i, 'Status Garansi');
        $i += 1;
        $no = 1;
        foreach ($data_exp as $key => $value) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $value['brand']);
            $sheet->setCellValue('C' . $i, $value['function']);
            $sheet->setCellValue('D' . $i, $value['serialnum']);
            $sheet->setCellValue('E' . $i, $value['warranty']);
            if ($value['condition'] == 4) {
                $kondisi = 'Rusak Berat';
            } else if ($value['condition'] == 3) {
                $kondisi = 'Rusak Sedang';
            } else if ($value['condition'] == 2) {
                $kondisi = 'Rusak Ringan';
            } else {
                $kondisi;
            }
            $sheet->setCellValue('F' . $i, $kondisi);
            if ($value['warranty'] <= date("Y-m-d", strtotime(now()))) {
                $sts_warranty = 'Expired';
            } else {
                $sts_warranty = 'Aktif';
            }
            $sheet->setCellValue('G' . $i, $sts_warranty);
            $i++;
        }
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $i -= 1;
        $sheet->getStyle('A' . $j . ':G' . $i)->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode("Laporan Garansi.xlsx") . '"');
        $writer->save('php://output');
    }

    public function export_report()
    {
        // $begin_year = date("Y-m-d", strtotime(date("Y") . "-01-01"));
        // $end_year = date("Y-m-d", strtotime(date("Y") . "-12-31"));
        $data = Infrastructure::with('InfraType')->orderBy('type_id', 'desc')->get();
        // $data_exp = Infrastructure::where([['warranty', '<', $end_year], ['warranty', '>', $begin_year]])->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN INFRASTRUKTUR');
        $sheet->mergeCells("A1:J1");
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);

        $sheet->setCellValue('A2', 'KESELURUHAN');
        $sheet->mergeCells("A2:J2");
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);

        $sheet->setCellValue('A3', 's.d ' . date("M Y", strtotime(now())));
        $sheet->mergeCells("A3:J3");
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getFont()->setBold(true);


        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Jenis');
        $sheet->setCellValue('C5', 'Merek & Tipe');
        $sheet->setCellValue('D5', 'Fungsi');
        $sheet->setCellValue('E5', 'Serial Number');
        $sheet->setCellValue('F5', 'Lokasi');
        $sheet->setCellValue('G5', 'Masa Aktif Warranty');
        $sheet->setCellValue('H5', 'Alamat  IP');
        $sheet->setCellValue('I5', 'Kondisi');
        $sheet->setCellValue('J5', 'Status Garansi');

        $i = 6;
        $no = 1;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $value->InfraType->type_name);
            $sheet->setCellValue('C' . $i, $value['brand']);
            $sheet->setCellValue('D' . $i, $value['function']);
            $sheet->setCellValue('E' . $i, $value['serialnum']);
            $sheet->setCellValue('F' . $i, $value['location']);
            $sheet->setCellValue('G' . $i, $value['warranty']);
            $sheet->setCellValue('H' . $i, $value['ip'] == null ? '-' : $value['ip']);
            if ($value['condition'] == 4) {
                $kondisi = 'Rusak Berat';
            } else if ($value['condition'] == 3) {
                $kondisi = 'Rusak Sedang';
            } else if ($value['condition'] == 2) {
                $kondisi = 'Rusak Ringan';
            } else {
                $kondisi = 'Baik';
            }
            $sheet->setCellValue('I' . $i, $kondisi);

            if ($value['warranty'] <= date("Y-m-d", strtotime(now()))) {
                $sts_warranty = 'Expired';
            } else {
                $sts_warranty = 'Aktif';
            }
            $sheet->setCellValue('J' . $i, $sts_warranty);
            $i++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $i -= 1;
        $sheet->getStyle('A5:J' . $i)->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode("Laporan Keseluruhan.xlsx") . '"');
        $writer->save('php://output');
    }
}
