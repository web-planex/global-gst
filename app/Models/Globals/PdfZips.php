<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class PdfZips extends Model
{
    protected $fillable =['user_id','company_id','zip_name','zip_type','status'];
}
