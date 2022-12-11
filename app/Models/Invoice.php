<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function section(){
        return $this->belongsTo(Section::class,'section_id','id');
    }

    public function invoice_details(){
        return $this->hasOne(Invoice_details::class,'invoice_id');
    }
}
