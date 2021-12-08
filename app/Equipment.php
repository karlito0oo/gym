<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $appends = ['available'];


    public function getAvailableAttribute(){
        $reserved = DB::select("SELECT COUNT(id) as num FROM calendar_user WHERE status = 'approved' AND JSON_CONTAINS(equipments,$this->id,'$')");

        return $this->quantity - $reserved[0]->num;
    }
}
