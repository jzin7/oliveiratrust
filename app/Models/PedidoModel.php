<?php namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model{


    protected $table        = "tb_pedido_produto";
    protected $primaryKey   = "id_pedido_produto";
    protected $allowedFields= ['id_pedido_produto', 'id_cliente', 'id_produto', 'nr_quantidade','nr_valor_total','nr_valor_frete','id_status','dt_cadastro'];
    protected $returnType   = 'object';


    function listaPedidos($id_cliente=null){

        $db         = \Config\Database::connect();
        $sql        = "     select  *
                                    , DATE_FORMAT(pp.dt_cadastro,'%d/%m/%Y') AS data_pedido 
                                    , ((nr_valor_total - nr_valor_frete) / nr_quantidade) as nr_valor_unitario
                            from    tb_pedido_produto   as pp
                                    , tb_cliente        as c
                                    , tb_produto        as p
                            where   pp.id_cliente = c.id_cliente
                            and     p.id_produto = pp.id_produto
                            ";
        if ($id_cliente !=null){
            $sql        .= " and c.id_cliente = " . $id_cliente;
        }
        
        $query = $db->query($sql);

        return $query->getResult();

    }

    function totalPedidos($id_cliente = null){
        
        $db         = \Config\Database::connect();
        $sql        = '   select  count(*)    as total_pedidos
                            from    tb_pedido_produto   as pp
                                    , tb_cliente        as c
                                    , tb_produto        as p
                            where   pp.id_cliente = c.id_cliente
                            and   p.id_produto = pp.id_produto
                        ';
        if ($id_cliente !=null){
            $sql        .= " and c.id_cliente = " . $id_cliente;
        }
        
        $query = $db->query($sql);
        return $query->getResult();
    }

    function listaPedidosAjax($tamanho,$inicio,$ordem,$busca){
 
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
            1=>'nm_produto',
            2=>'nr_valor_frete',
            3=>'nr_quantidade',
            4=>'pp.id_status',
            5=>'c.id_cliente',
            6=>'pp.id_pedido_produto',
            7=>'pp.id_produto',
            8=>'pp.data_pedido',
            8=>'ps.nm_pedido_produto_status',
            
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
            foreach($valid_columns as $termo)
            {
                if($x==0)
                {
                    $whereLike  .=  '  ' . $termo . " like '%" . $busca . "%'";
                }
                else
                {
                    $whereLike  .= " or " . $termo . " like '%" .  $busca . "%'";
                }
                $x++;
            }                 
        } else {
            $whereLike = '1=1';
        }
 

        $query = $db->query("   select  *
                                        , DATE_FORMAT(pp.dt_cadastro,'%d/%m/%Y') AS data_pedido
                                        , p.id_status   as id_status_produto
                                from    tb_pedido_produto           as pp
                                        , tb_cliente                as c
                                        , tb_produto                as p
                                        , tb_pedido_produto_status  as ps
                                where   pp.id_cliente = c.id_cliente
                                  and   ps.id_pedido_produto_status = pp.id_status
                                  and   p.id_produto = pp.id_produto
                                  and (".$whereLike.")
                                ".$ordemQuery."
                                LIMIT ".$tamanho." OFFSET ".$inicio."
                            ");

        return $query->getResult();

    }

    function estatisticas ($id_cliente=null){

        if ($id_cliente !=null){
            $cliente = ' and pp.id_cliente = ' . $id_cliente;
        } else {
            $cliente = '';
        }

        $db         = \Config\Database::connect();
        $sql        = '   SELECT sum(pp.nr_valor_total)         as valor_total
                                    , pps.nm_pedido_produto_status
                                    , count(*)                  as pedidos
                            FROM    tb_pedido_produto	        as pp
                                    , tb_pedido_produto_status  as pps
                            WHERE	pp.id_status = pps.id_pedido_produto_status
                            '.$cliente.'
                            group by pp.id_status
                        ';
        
        $query = $db->query($sql);
        return $query->getResult();
        

    }
}