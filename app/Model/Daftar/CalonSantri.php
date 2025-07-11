<?php

namespace App\Model\Daftar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalonSantri extends Model
{
    use SoftDeletes;
    
    protected $connection = 'mysql_daftar';
    protected $table = "calon_santri"; 
    
}
