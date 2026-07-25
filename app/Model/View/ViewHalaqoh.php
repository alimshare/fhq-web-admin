<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Peserta;
use App\Model\ActivityReport;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class ViewHalaqoh extends Model
{
    protected 	$table 		= "view_halaqoh";

    protected static function booted()
    {
        static::addGlobalScope('exclude_soft_deletes', function (Builder $builder) {
            $builder->whereExists(function ($query) {
                $query->selectRaw(1)
                    ->from('halaqoh')
                    ->whereRaw('halaqoh.id = view_halaqoh.halaqoh_id')
                    ->whereNull('halaqoh.deleted_at');
            });
        });
    }

    public function peserta(){
        return $this->hasMany(Peserta::class, 'halaqoh_id', 'halaqoh_id');
    }

    public function getPeserta(){
        return Peserta::where('halaqoh_id', '=', $this->id)->get();
    }

    public function kbm()
    {
        return $this->hasMany(ActivityReport::class, 'halaqoh_id', 'halaqoh_id')->orderBy('tgl', 'asc');
    }

}
