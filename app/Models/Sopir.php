<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sopir extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sopirs';
    protected $fillable = ['nik','nama','alamat','no_hp','no_hp_lain','pekerjaan'];
}
