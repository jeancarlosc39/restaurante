<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapios extends Model
{
    protected $table = 'cardapios';
    protected $fillable = ['nome'];
}
