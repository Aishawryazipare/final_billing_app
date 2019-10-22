<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderFooter extends Model
{
    protected $primaryKey = "id";
    public $table = "tbl_header_footer";
    public $timestamps=false;
    protected $fillable = [
        'cid','LID','h1','h2','h3','h4','h5','f1','f2','f3','f4','f5','is_active'
    ];
}
