<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Funcionarios;
use App\Models\Mesas;
use App\Models\Cardapios;
use App\Models\ItensCardapio;
use App\Models\Pedido;
use App\Models\ItemPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ApiController extends Controller
{
    //Listar pedidos em andamento garçom
      public function pedidosAndamento() {
      
        $results = DB::select( DB::raw("SELECT pedidos.codMesa, DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') AS dataPedido, itens_cardapios.item,itens_cardapios.preco FROM `pedidos`
        inner join item_pedidos on pedidos.id = item_pedidos.codPedido
        inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
        WHERE pedidos.status = 1  and pedidos.codFuncionario = 1") );
        return  $results;

      }
      //Listar pedidos há fazer e em andamento, (para o cozinheiro).
      public function pedidosCozinheiro() {
      
        $results = DB::select( DB::raw("SELECT pedidos.codMesa, DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') AS dataPedido, itens_cardapios.item,itens_cardapios.preco FROM `pedidos`
        inner join item_pedidos on pedidos.id = item_pedidos.codPedido
        inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
        WHERE pedidos.status in (1,2)  and pedidos.codFuncionario = 2") );
        return  $results;

        
      }//clientes maior pedido
      public function maiorPedido() {
      
        $results = DB::select( DB::raw("SELECT clientes.nome,pedidos.id, itens_cardapios.item,itens_cardapios.preco FROM `pedidos`
        inner join item_pedidos on pedidos.id = item_pedidos.codPedido
        inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
        inner join clientes on pedidos.codCliente = clientes.id
        WHERE pedidos.status in (1,2)  
        order by 2  desc;") );
        return  $results;

        
      }
      //Clientes primeiro pedido
      public function primeiroPedido() {
      
        $results = DB::select( DB::raw("SELECT clientes.nome,pedidos.id, itens_cardapios.item,itens_cardapios.preco FROM `pedidos`
        inner join item_pedidos on pedidos.id = item_pedidos.codPedido
        inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
        inner join clientes on pedidos.codCliente = clientes.id
        WHERE pedidos.status in (1,2)  
        order by 2  asc;") );
        return  $results;
      }
      //Clientes ultimo pedido
      public function ultimoPedido() {
      
        $results = DB::select( DB::raw("SELECT clientes.nome,pedidos.id, itens_cardapios.item,itens_cardapios.preco FROM `pedidos`
        inner join item_pedidos on pedidos.id = item_pedidos.codPedido
        inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
        inner join clientes on pedidos.codCliente = clientes.id
        WHERE pedidos.status in (1,2)  
        order by 2  desc;") );
        return  $results;
      }
      //Listar todos pedidos por mesa
      public function pedidosMesa(Request $request){
        if ($request->codMesa) {
           $sql = "WHERE  mesas.numero = $request->codMesa";
        }else{
          $sql = "";
        }
        
        $results = DB::select( DB::raw("SELECT mesas.numero,clientes.nome,  DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') AS dataPedido,pedidos.id, itens_cardapios.item,itens_cardapios.preco,
        case 
          when pedidos.status = 1 then 'Em andamento'
          when pedidos.status = 2 then 'A fazer'
          else 'Finalizados'
        end as status
        FROM `pedidos`
          inner join item_pedidos on pedidos.id = item_pedidos.codPedido
          inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
          inner join clientes on pedidos.codCliente = clientes.id
          inner join mesas on pedidos.codMesa = mesas.id
          $sql
          order by pedidos.created_at  desc;") );
        return  $results;

      }
      //Listar todos pedidos por cliente
      public function pedidosCliente(Request $request){
    
        if ($request->nome) {
           $sql = "where clientes.nome like '%$request->nome%'   ";
        }else{
          $sql = '';
        }
        
        $results = DB::select( DB::raw("SELECT mesas.numero,clientes.nome,  DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') AS dataPedido,pedidos.id, itens_cardapios.item,itens_cardapios.preco,
        case 
          when pedidos.status = 1 then 'Em andamento'
          when pedidos.status = 2 then 'A fazer'
          else 'Finalizados'
        end as status
        FROM `pedidos`
          inner join item_pedidos on pedidos.id = item_pedidos.codPedido
          inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
          inner join clientes on pedidos.codCliente = clientes.id
          inner join mesas on pedidos.codMesa = mesas.id
          $sql
          order by pedidos.created_at  desc;") );
        return  $results;

      }
      //Lista todos os pedidos do dia
      public function pedidosDia(Request $request){
    
        if ($request->data) {
          $sql = " where DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') = '$request->data'";
       }else{
         $sql = '';
       }
      
      

        $results = DB::select( DB::raw("SELECT mesas.numero,clientes.nome,  DATE_FORMAT(pedidos.created_at,'%d/%m/%Y') AS dataPedido,pedidos.id, itens_cardapios.item,itens_cardapios.preco,
        case 
          when pedidos.status = 1 then 'Em andamento'
          when pedidos.status = 2 then 'A fazer'
          else 'Finalizados'
        end as status
        FROM `pedidos`
          inner join item_pedidos on pedidos.id = item_pedidos.codPedido
          inner join itens_cardapios on item_pedidos.codItem = itens_cardapios.id
          inner join clientes on pedidos.codCliente = clientes.id
          inner join mesas on pedidos.codMesa = mesas.id
          $sql 
          order by pedidos.created_at  desc;") );
        return  $results;
      }
      public function cadCliente(Request $request) {
        
        $cliente = new Cliente;
       
        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
       
        $cliente->save();
      
        return response()->json([
            "message" => "cliente criado"
        ], 201);
    }
    public function cadFuncionario(Request $request) {
        
      $func = new funcionarios;
     
      $func->nome = $request->nome;
      $func->status = $request->status;
     //status 1 - garçom  / 2 cozinheiro
     $func->save();
    
      return response()->json([
          "message" => "funcionario criado"
      ], 201);
  }
  
      public function cadMesa(Request $request) {
         $mesa = new mesas;
     
          $mesa->numero = $request->numero;
          $mesa->save();
        
          return response()->json([
              "message" => "mesa criada"
          ], 201);
      }
      public function cadCardapio(Request $request) {
         
         $cardapios = new cardapios;
         $cardapios->nome = $request->nome;
         $cardapios->save();
       
         return response()->json([
             "message" => "cardapio criado"
         ], 201);
     }
     public function cadItemCardapio(Request $request) {
         
       $cardapios = new ItensCardapio;
        $cardapios->item= $request->item;
        $cardapios->preco= $request->preco;
        $cardapios->codCardapio= $request->codCardapio;
        $cardapios->save();
      
        return response()->json([
            "message" => "cardapio itens criado"
        ], 201);
    }
    public function cadPedido(Request $request) {
      
      $pedido = new pedido;
  
      $pedido->codMesa= $request->codMesa;
      $pedido->codCliente= $request->codCliente;
      $pedido->codFuncionario= $request->codFuncionario;
      $pedido->status = $request->status;
  
      $pedido->save();
       return response()->json([
           "message" => "Pedido criado"
       ], 201);
   }
   public function cadItemPedido(Request $request) {
     
    $pedido = new ItemPedido;

    $pedido->codItem= $request->codItem;
    $pedido->codPedido = $request->codPedido;
 

    $pedido->save();
     return response()->json([
         "message" => "Item Pedido criado"
     ], 201);

     //Listar pedidos em andamento
   
    }
    
      public function fake() {
        $faker = \Faker\Factory::create('pt_BR');
        for ($i=0; $i< 420334; $i++) {
            
            DB::table('item_pedidos')->insert([
                'codPedido' => $i,
                'codItem' => rand(1, 37),
                'updated_at' => date('Y-m-d H:i:s', strtotime($faker->iso8601)),
                'created_at' => date('Y-m-d H:i:s', strtotime($faker->iso8601)),
            ]);
        }
    }
  
      public function updateStudent(Request $request, $id) {
        // logic to update a student record goes here
      }
  
      public function deleteStudent ($id) {
        // logic to delete a student record goes here
      }
}
