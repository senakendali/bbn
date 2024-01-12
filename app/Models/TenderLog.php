<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TenderLog extends Model
{
    use HasFactory;

    protected $table = 'tender_logs';
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s', // Change your format
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];
}
