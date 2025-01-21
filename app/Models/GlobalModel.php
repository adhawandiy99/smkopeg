<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

date_default_timezone_set("Asia/Makassar");

class GlobalModel
{
	public static function getById($table,$condition)
	{
		return DB::table($table)->where($condition)->first();
	}
	public static function getAll($table)
	{
		return DB::table($table)->get();
	}
	public static function getAllCondition($table,$condition)
	{
		$query = DB::table($table);

	    // Loop through each condition
	    foreach ($condition as $field => $value) {
	        if (is_string($value) && strpos($value, '%') !== false) {
	            // If the value contains '%' wildcard, treat it as a LIKE condition
	            $query->where($field, 'like', $value);
	        } else {
	            // Otherwise, treat it as an exact match
	            $query->where($field, $value);
	        }
	    }
		return $query->get();
	}
	public static function getFirstByCondition($table,$condition)
	{
		return DB::table($table)->where($condition)->first();
	}

	public static function insertGetId($table, $insert)
	{
		return DB::table($table)->insertGetId($insert);
	}
	public static function insert($table, $insert)
	{
		DB::table($table)->insert($insert);
	}
	public static function insertOrUpdate($table, array $rows)
    {
        $first = reset($rows);
        $columns = implode(
            ',',
            array_map(function ($value) {
                return "$value";
            }, array_keys($first))
        );
        $values = implode(
            ',',
            array_map(function ($row) {
                return '(' . implode(
                    ',',
                    array_map(function ($value) {
                        return '"' . str_replace('"', '""', $value) . '"';
                    }, $row)
                ) . ')';
            }, $rows)
        );
        $updates = implode(
            ',',
            array_map(function ($value) {
                return "$value = VALUES($value)";
            }, array_keys($first))
        );
        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
        return \DB::statement($sql);
    }
	public static function update($table, $condition, $update)
	{
		DB::table($table)->where($condition)->update($update);
	}
		public static function delete($table,$condition)
	{
		return DB::table($table)->where($condition)->delete();
	}
	public static function count($table,$condition)
	{
		return DB::table($table)->where($condition)->count();
	}
	public static function api_wmpro($table){
		$data = [
	      'table' => $table,
	      'method' => 'getAll'
	    ];
	    $url = 'https://wmpro.tomman.app/API/get?' . http_build_query($data);
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    return json_decode($response)->data;
	}
}
?>