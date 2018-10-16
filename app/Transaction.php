<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table="transactions";
    protected $fillable=['transact_date','fee_id','s_fee_id','user_id','student_id','paid','remark','descrption'];
    protected $primaryKey ="transact_id";
    public $timestamps=false;
}
