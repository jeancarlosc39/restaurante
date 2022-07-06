<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensCardapio extends Model
{
    protected $table = 'itens_cardapios';
    protected $fillable = ['preco','item','codCardapio' ];
}
