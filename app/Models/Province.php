<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*class Province extends Model
{
    use HasFactory;
}*/

class Province
{
    

    public static function all()
    {
        $province = DB::table('provinces')->orderBy('name')->get();
        return collect($province);
    }
}
