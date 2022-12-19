<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    use HasFactory;
    protected $table = 'sopirs';
    protected $fillable = ['nik','nama','alamat','no_hp','no_hp_lain','pekerjaan'];
}
