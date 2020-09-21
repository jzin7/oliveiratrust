<?php namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model{


    protected $table        = "tb_produto";
    protected $primaryKey   = "id_produto";
    protected $allowedFields= ['id_produto', 'nm_produto', 'nr_valor', 'nr_frete','id_status','qt_unidades_disponiveis','dt_cadastro'];
    protected $returnType   = 'object';


    function listaProdutos($id_produto=null){

        $db         = \Config\Database::connect();
        if ($id_produto != null){
            $queryProduto = "  and p.id_produto = " . $id_produto . " "; 
        } else {
            $queryProduto = " ";
        }

        $query = $db->query("   select  p.*
                                        , DATE_FORMAT(p.dt_cadastro,'%d/%m/%Y') AS data_cadastro 
                                from    tb_produto          as p
                                        , tb_produto_status as ps
                                where   p.id_status = 1  
                                  and   p.id_status = ps.id_produto_status
                                  $queryProduto
                                order by p.nm_produto
                                "
                            );

        return $query->getResult();

    }

    function totalProdutos(){
        
        $db         = \Config\Database::connect();
        $query = $db->query('   select  count(*) as total_produtos
                                from    tb_produto as p
                                where   p.id_status = 1
                            ');
        return $query->getResult();
    }

    function listaProdutosAjax($id_produto,$tamanho,$inicio,$ordem,$busca){
 
        $db         = \Config\Database::connect();
        $col = 0;
        $dir = "";

        //valido a ordenação
        if(!empty($ordem))
        {
            foreach($ordem as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            0=>'nm_produto',
            1=>'nr_valor',
            2=>'nr_frete',
            3=>'qt_unidades_disponiveis',
            4=>'dt_cadastro'
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
        
        $produto='';
        if ($whereLike==''){
            if ($id_produto!=null){
                $produto = " and  p.id_produto = " . $id_produto;
            }
        }
        $query = $db->query("   select  p.*
                                        , DATE_FORMAT(p.dt_cadastro,'%d/%m/%Y') AS data_cadastro 
                                from    tb_produto          as p
                                        , tb_produto_status as ps
                                where   p.id_status = 1  
                                  and   p.id_status = ps.id_produto_status
                                  ".$produto."
                                ".$whereLike."
                                ".$ordemQuery."
                                LIMIT ".$tamanho." OFFSET ".$inicio."
                            ");

        return $query->getResult();

    }
}