<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class OrderModel
{
  public static function joinTable()
  {
    return DB::table('master_order')
    ->select('master_order.*', 'source_wmcr.id as wmpro_dispatch_id', 'source_wmcr.status', 'source_wmcr.report_time', 'source_wmcr.assigned_date', 'b.id as wmpro_dispatch_id_2', 'b.status as status_2', 'b.report_time as report_time_2', 'b.assigned_date as assigned_date_2')
    ->leftJoin('source_wmcr', 'master_order.relation_id', '=', 'source_wmcr.order_id')
    ->leftJoin('source_wmcr as b', 'master_order.workorder', '=', 'source_wmcr.order_id');
    
  }
  public static function getActivity()
  {
    return self::joinTable()->get();
  }
  public static function getListByStatus($status){
    return DB::table('master_order as a')
      ->select('a.*', 'b.username as sales_nik', 'b.name as sales_name', 'b.tl as tl_nik', 'b.tl_name', 'b.spv as spv_nik', 'b.spv_name')
      ->leftJoin('master_user as b', 'a.create_by', '=', 'b.id_user')
      ->whereIn('a.status_id', $status)
      ->orderBy('a.id_master_order', 'desc')
      ->get();
  }
  public static function getListByUser($user){
    return DB::table('master_order as a')
      ->select('a.*', 'b.username as sales_nik', 'b.name as sales_name', 'b.tl as tl_nik', 'b.tl_name', 'b.spv as spv_nik', 'b.spv_name')
      ->leftJoin('master_user as b', 'a.create_by', '=', 'b.id_user')
      ->where('a.create_by', $user)
      ->orderBy('a.id_master_order', 'desc')
      ->get();
  }
  public static function getListBySearch($q){
    return DB::table('master_order as a')
      ->select('a.*', 'b.username as sales_nik', 'b.name as sales_name', 'b.tl as tl_nik', 'b.tl_name', 'b.spv as spv_nik', 'b.spv_name')
      ->leftJoin('master_user as b', 'a.create_by', '=', 'b.id_user')
      ->where('a.nama_pelanggan', 'like', "%".$q."%")
      ->orderBy('a.id_master_order', 'desc')
      ->get();
  }

}
?>