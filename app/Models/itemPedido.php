<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemPedido extends Model
{
    protected $table = 'item_Pedidos';
    protected $fillable = ['codPedido', 'codItem'];
}
