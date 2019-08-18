<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*   @since 	: Feb 2019
*/
class Halaqoh extends Model
{
    use SoftDeletes;

    protected 	$table 		= "halaqoh";

    public static function getByReference($referenceId) {
        return Halaqoh::where('reference', '=', $referenceId)->first();
    }

    public function getPengajar(){
        return Pengajar::find($this->pengajar_id);
    }

    public function getProgram(){
        return Program::find($this->program_id);
    }

    public function getSemester(){
        return Semester::find($this->semester_id);
    }

    public function getPeserta(){
        return PendidikanSantri::where('halaqoh_id', '=', $this->id)->get();
    }

    public function getView(){
        return View\ViewHalaqoh::where('halaqoh_id', $this->id)->first();
    }

}
