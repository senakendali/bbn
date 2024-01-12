<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regencies extends Model
{
    use HasFactory;

    protected $table = 'regencies';
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];

    

    public static function regencies_by_province($province_id)
    {
        $regencies = DB::table('regencies')
                ->where('province_id', '=', $province_id)
                ->get();

        return $regencies;
    }
}
