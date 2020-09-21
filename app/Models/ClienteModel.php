<?php namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model{


    protected $table        = "tb_cliente";
    protected $primaryKey   = "id_cliente";
    protected $allowedFields= ['nm_cliente', 'tx_email', 'tx_senha', 'id_status','administrador','dt_cadastro'];
    protected $returnType   = 'object';


    function listaClientes(){

        $db         = \Config\Database::connect();
        $query = $db->query("   select  c.*
                                        , total_pedidos
                                        , DATE_FORMAT(dt_cadastro,'%d/%m/%Y') AS data_cadastro 
                                from    tb_cliente as c
                                left    join    (   SELECT count(*) total_pedidos
                                                            , id_cliente
                                                    FROM tb_pedido_produto
                                                    GROUP BY id_cliente
                                                ) as pp
                                on      pp.id_cliente = c.id_cliente
                                where   c.id_status = 1  
                            ");

        return $query->getResult();

    }

    function totalClientes($id_cliente){
        
        $db         = \Config\Database::connect();
        $query = $db->query('   select  count(*) as total
                                from    tb_cliente
                                where   id_status = 1
                                and     id_cliente <> '.$id_cliente.'
                            ');
        return $query->getResult();
    }

    function listaClientesAjax($tamanho,$inicio,$ordem,$busca){
 
        $db         = \Config\Database::connect();
        $col = 0;
        $dir = "";

        //valido a ordenação
        if(!empty($ordem))
        {
            foreach($ordem as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            0=>'nm_cliente',
            1=>'tx_email',
            2=>'dt_cadastro',
            3=>'tx_senha',
            4=>'id_status',
            5=>'c.id_cliente',
            6=>'total_pedidos'
        );
        if(!isset($valid_columns[$col]))
        {
            $ordem = null;
        }
        else
        {
            $ordem = $valid_columns[$col];
        }
        if($ordem !=null)
        {
            $ordemQuery = ' order by '. $ordem . ' ' . $dir;
        }

        //valido a busca
        $whereLike = '';
        if(!empty($busca))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $whereLike  .=  ' and  ' . $sterm . " like '%" . $busca . "%'";
                }
                else
                {
                    $whereLike  .= " or " . $sterm . " like '%" .  $busca . "%'";
                }
                $x++;
            }                 
        }

        $query = $db->query("   select  c.*
                                        , DATE_FORMAT(c.dt_cadastro,'%d/%m/%Y') AS data_cadastro 
                                        , case when (pp.total_pedidos ='') or (pp.total_pedidos is null) then 0
                                                else pp.total_pedidos
                                            end  as total_pedidos
                                from    tb_cliente as c
                                left    join    (   SELECT count(*) total_pedidos
                                                    , id_cliente
                                                    FROM tb_pedido_produto
                                                    GROUP BY id_cliente
                                                ) as pp

                                on      pp.id_cliente = c.id_cliente
                                where   c.id_status = 1  
                                ".$whereLike."
                                ".$ordemQuery."
                                LIMIT ".$tamanho." OFFSET ".$inicio."
                            ");

        return $query->getResult();

    }
}