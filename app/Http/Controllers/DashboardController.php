<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\LoginModel;
use App\Models\GlobalModel;

date_default_timezone_set("Asia/Makassar");

class DashboardController extends Controller
{
  public function index(Request $req)
  {
    $isp = GlobalModel::getAll('master_isp');
    $query = DB::table('master_order as a')
    ->select(
        'isp_name',
        'kota',
        DB::raw('SUM(IF(a.status_id=1, 1, 0)) as registered'),
        DB::raw('SUM(IF(a.status_id=2, 1, 0)) as validated'),
        DB::raw('SUM(IF(a.status_id=3, 1, 0)) as order_issued'),
        DB::raw('SUM(IF(a.status_id=7, 1, 0)) as kendala_input'),
        DB::raw('SUM(IF(a.status_id=4, 1, 0)) as kendala_install'),
        DB::raw('SUM(IF(a.status_id=5, 1, 0)) as prosess_install'),
        DB::raw('SUM(IF(a.status_id=6, 1, 0)) as online'),
        DB::raw('SUM(IF(a.status_id=6 and a.status_rekon=1, 1, 0)) as rekon_approve'),
        DB::raw('SUM(IF(a.status_id=6 and a.status_rekon=2, 1, 0)) as rekon_hold'),
        DB::raw('SUM(IF(a.status_id=6 and a.status_rekon=3, 1, 0)) as rekon_reject'),
        DB::raw('SUM(IF(a.tgl_curn is not null, 1, 0)) as curn')
    )
    ->groupBy('isp_name', 'kota');
    if($req->isp != 'ALL'){
      $query->where('isp_name', $req->isp);
    }
    $date = "%";
    if($req->tahun != 'ALL'){
      $date .= $req->tahun;
    }
    $date .= "-";
    if($req->bulan != 'ALL'){
      $date .= $req->bulan;
    }
    $date .= "%";
    $data = $query->where('create_at', 'like', $date)->get();
    return view('desktop.dashboard', compact('data','isp'));
  }
  public function ajax(Request $req)
  {
    $query = DB::table('master_order as a');
    $date = "%";
    if($req->tahun != 'ALL'){
      $date .= $req->tahun;
    }
    $date .= "-";
    if($req->bulan != 'ALL'){
      $date .= $req->bulan;
    }
    $date .= "%";
    if($req->isp_name != 'ALL'){
      $query->where('a.isp_name', $req->isp_name);
    }
    if($req->kota != 'ALL'){
      $query->where('a.kota', $req->kota);
    }
    if($req->col=='registered'){
      $query->where('a.status_id',1);
    }else if($req->col=='validated'){
      $query->where('a.status_id',2);
    }else if($req->col=='order_issued'){
      $query->where('a.status_id',3);
    }else if($req->col=='kendala_input'){
      $query->where('a.status_id',7);
    }else if($req->col=='kendala_install'){
      $query->where('a.status_id',4);
    }else if($req->col=='prosess_install'){
      $query->where('a.status_id',5);
    }else if($req->col=='online'){
      $query->where('a.status_id',6);
    }else if($req->col=='rekon_approve'){
      $query->where('a.status_id',6)->where('a.status_rekon',1);
    }else if($req->col=='rekon_hold'){
      $query->where('a.status_id',6)->where('a.status_rekon',2);
    }else if($req->col=='rekon_reject'){
      $query->where('a.status_id',6)->where('a.status_rekon',3);
    }else if($req->col=='curn'){
      $query->whereNotNull('a.curn');
    }

    $data = $query->where('a.create_at', 'like', $date)->get();
    return view('desktop.ajax.dashboard', compact('data'));
  }
  public function exportToExcel(Request $req)
  {
    // Example data
    $query = DB::table('master_order as a')
    ->select('a.*', 'b.username', 'b.name', 'b.tl', 'b.tl_name', 'b.spv_name','c.nama_status')
    ->leftJoin('master_user as b', 'a.create_by', '=', 'b.id_user')
    ->leftJoin('master_status as c', 'a.status_id', '=', 'c.id_status');
    $date = "%";
    if($req->query('tahun') != 'ALL'){
      $date .= $req->query('tahun');
    }
    $date .= "-";
    if($req->query('bulan') != 'ALL'){
      $date .= $req->query('bulan');
    }
    $date .= "%";
    if($req->query('isp_name') != 'ALL'){
      $query->where('a.isp_name', $req->query('isp_name'));
    }
    $data = $query->get();
    // dd( $req->query('tahun'),$req->query('bulan'),$req->query('isp_name'),$req,$data);
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add data to the spreadsheet
    $columnIndex = 'A';
    $sheet->setCellValue($columnIndex.'1', 'No');
    $sheet->setCellValue(++$columnIndex.'1', 'ID');
    $sheet->setCellValue(++$columnIndex.'1', 'Nama Pelanggan');
    $sheet->setCellValue(++$columnIndex.'1', 'Vendor Name');
    $sheet->setCellValue(++$columnIndex.'1', 'GSM 1');
    $sheet->setCellValue(++$columnIndex.'1', 'GSM 2');
    $sheet->setCellValue(++$columnIndex.'1', 'Koordinat');
    $sheet->setCellValue(++$columnIndex.'1', 'ISP');
    $sheet->setCellValue(++$columnIndex.'1', 'Paket');
    $sheet->setCellValue(++$columnIndex.'1', 'ODP');
    $sheet->setCellValue(++$columnIndex.'1', 'Homepass');
    $sheet->setCellValue(++$columnIndex.'1', 'Status');
    $sheet->setCellValue(++$columnIndex.'1', 'Status Rekon');
    $sheet->setCellValue(++$columnIndex.'1', 'Service');
    $sheet->setCellValue(++$columnIndex.'1', 'No. KTP');
    $sheet->setCellValue(++$columnIndex.'1', 'Tgl. Lahir');
    $sheet->setCellValue(++$columnIndex.'1', 'Kelurahan');
    $sheet->setCellValue(++$columnIndex.'1', 'Kecamatan');
    $sheet->setCellValue(++$columnIndex.'1', 'Kota');
    $sheet->setCellValue(++$columnIndex.'1', 'Jenis Bangunan');
    $sheet->setCellValue(++$columnIndex.'1', 'Building Status');
    $sheet->setCellValue(++$columnIndex.'1', 'Install Date');
    $sheet->setCellValue(++$columnIndex.'1', 'Jam');
    $sheet->setCellValue(++$columnIndex.'1', 'Router');
    $sheet->setCellValue(++$columnIndex.'1', 'STB');
    $sheet->setCellValue(++$columnIndex.'1', 'Tgl. Input');
    $sheet->setCellValue(++$columnIndex.'1', 'Nik Sales');
    $sheet->setCellValue(++$columnIndex.'1', 'Nama Sales');
    $sheet->setCellValue(++$columnIndex.'1', 'Nik TL');
    $sheet->setCellValue(++$columnIndex.'1', 'Nama TL');
    $sheet->setCellValue(++$columnIndex.'1', 'Nama SPV');
    $row = 2;
    foreach ($data as $d) {
        switch ($d->status_rekon) {
            case 1:
                $status_rekon = "Approve";
                break;
            case 2:
                $status_rekon = "Hold";
                break;
            case 3:
                $status_rekon = "Reject";
                break;
            default:
                $status_rekon = "";
        }
        $columnIndex = 'A';
        $sheet->setCellValue($columnIndex. $row, $row-1);
        $sheet->setCellValue(++$columnIndex . $row, $d->relation_id);
        $sheet->setCellValue(++$columnIndex . $row, $d->nama_pelanggan);
        $sheet->setCellValue(++$columnIndex . $row, $d->vendor_name);
        $sheet->setCellValue(++$columnIndex . $row, $d->no_telp_pelanggan);
        $sheet->setCellValue(++$columnIndex . $row, $d->telp_pelanggan_alt);
        $sheet->setCellValue(++$columnIndex . $row, $d->koordinat_pelanggan);
        $sheet->setCellValue(++$columnIndex . $row, $d->isp_name);
        $sheet->setCellValue(++$columnIndex . $row, $d->paket_name);
        $sheet->setCellValue(++$columnIndex . $row, $d->odp_name);
        $sheet->setCellValue(++$columnIndex . $row, $d->homepass);
        $sheet->setCellValue(++$columnIndex . $row, $d->nama_status);
        $sheet->setCellValue(++$columnIndex . $row, $status_rekon);
        $sheet->setCellValue(++$columnIndex . $row, $d->service);
        $sheet->setCellValue(++$columnIndex . $row, $d->no_ktp);
        $sheet->setCellValue(++$columnIndex . $row, $d->tgl_lahir);
        $sheet->setCellValue(++$columnIndex . $row, $d->kelurahan);
        $sheet->setCellValue(++$columnIndex . $row, $d->kecamatan);
        $sheet->setCellValue(++$columnIndex . $row, $d->kota);
        $sheet->setCellValue(++$columnIndex . $row, $d->jenis_bangunan);
        $sheet->setCellValue(++$columnIndex . $row, $d->building_status);
        $sheet->setCellValue(++$columnIndex . $row, $d->install_date);
        $sheet->setCellValue(++$columnIndex . $row, $d->jam);
        $sheet->setCellValue(++$columnIndex . $row, $d->router);
        $sheet->setCellValue(++$columnIndex . $row, $d->stb);
        $sheet->setCellValue(++$columnIndex . $row, $d->create_at);
        $sheet->setCellValue(++$columnIndex . $row, $d->username);
        $sheet->setCellValue(++$columnIndex . $row, $d->name);
        $sheet->setCellValue(++$columnIndex . $row, $d->tl);
        $sheet->setCellValue(++$columnIndex . $row, $d->tl_name);
        $sheet->setCellValue(++$columnIndex . $row, $d->spv_name);
        $row++;
    }

    // Create a file writer and save it to output
    $writer = new Xlsx($spreadsheet);
    $fileName = 'orders.xlsx';
    $filePath = storage_path($fileName);

    $writer->save($filePath);

    // Return file as a download response
    return response()->download($filePath)->deleteFileAfterSend(true);
  }
}
?>