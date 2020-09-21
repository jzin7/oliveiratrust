<?php namespace App\Controllers;

class Produto extends BaseController
{
    public $session;

    public function __construct(){
        $this->session = session();
    }
 
    //link URL/Produto
	public function index($msg=null)
	{
        return redirect()->to(base_url('produto/lista'));
    }


    //esta página se abre e nela eu consulto a lista de produtos pelo ajax
    public function lista($id_produto=null){
        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //vejo se o usuário é administrador. Somente administrador pode acessar
        if ($this->session->permissao !='Administrador'){
            return redirect()->to(base_url("/dashboard"));
        }

        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;
        $data['msg']        = '';
        $data['id_produto'] = $id_produto;
        return view('produtolista',$data);
    }


    
    public function lista_ajax($id_produto=null){

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode listar os produtos
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }
        
        //datatable manda post para listar ou filtrar
        if ($this->request->getMethod() =='post'){
 
            $sequencial     = intval($this->request->getPost("draw"));
            $inicio         = intval($this->request->getPost("start"));
            $tamanho        = intval($this->request->getPost("length"));
            $ordem          = $this->request->getPost("order");
            $busca          = $this->request->getPost("search");
            $busca          = $busca['value'];

            //$this->db->limit($tamanho,$inicio);
            $produtosModel  = new \App\Models\ProdutoModel();
            if ($id_produto!=""){
                $produtos       = $produtosModel->listaprodutosAjax($id_produto,$tamanho,$inicio,$ordem,$busca);
            } else {
                $produtos       = $produtosModel->listaprodutosAjax(null,$tamanho,$inicio,$ordem,$busca);
            }
            
            
            $data = array();
            foreach($produtos as $rows)
            {
                if ($rows->id_produto!=$this->session->id_produto){
                   
                    $rows->nr_valor = "R$ ".number_format($rows->nr_valor,2,",",".");
                    $rows->nr_frete = "R$ ".number_format($rows->nr_frete,2,",",".");
                    $data[]= array(
                        $rows->nm_produto,
                        $rows->nr_valor,
                        $rows->nr_frete,
                        $rows->qt_unidades_disponiveis,
                        $rows->data_cadastro,
                        '<a href="#"  id="'.$rows->id_produto.'" class="editar_produto btn btn_editar mr-1"><i class="fa fa-fw" aria-hidden="true" title="Editar"></i> Editar</a>
                        <a href="#"  id="'.$rows->id_produto.'" class="remover_produto btn btn_remover mr-1"><i class="fa fa-fw" aria-hidden="true" title="Remover"></i> Remover</a>'
                    );    
                }
                
            }
            
            $totalprodutos = $produtosModel->totalprodutos();
            $totalprodutos = $totalprodutos[0]->total_produtos;
            $output = array(
                "draw" => $sequencial,
                "recordsTotal" => $totalprodutos,
                "recordsFiltered" => $totalprodutos,
                "data" => $data
            );
            echo json_encode($output);
            exit();
        } 
        
        
        
    }

    public function inserir_ajax(){

         //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

         //somente o administrador pode editar o produto via ajax
         //essa função é usada na área de lista de produtos.
         //entao precisa ser adm para editar
         if ($this->session->permissao != "Administrador"){
             return redirect()->to(base_url('dashboard'));
         }

         if ($this->request->getMethod() =='post'){
            $produto    = new \App\Models\ProdutoModel();
            //testo se o produto já existe no sistema
            $teste      = $produto->where('nm_produto',$this->request->getPost("nome_produto"))->findAll();
            if ($teste != NULL){
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Já existe um produto no sistema com este nome!.</div>'));
                exit;
            }
            $info = [
                'nm_produto'                => $this->request->getPost("nome_produto"),
                'nr_valor'                  => $this->removerFormatacaoMoeda($this->request->getPost("valor_produto")),
                'nr_frete'                  => $this->removerFormatacaoMoeda($this->request->getPost("frete_produto")),
                'qt_unidades_disponiveis'   => $this->request->getPost("estoque_produto"),
            ];

            if ($produto->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Produto inserido com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao inserir o produto. Por favor contacte o administrador do sistema!.</div>;'));
            }
            
         }

    }

    //quando for post, o id é nulo pq eu dou o post no caminho sem parametro
    //o id vem no array do post
    public function editar_ajax($id=null) {

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode editar o produto via ajax
        //essa função é usada na área de lista de produtos.
        //entao precisa ser adm para editar
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }

        //se for post ele está enviando os dados novos
        if ($this->request->getMethod() =='post'){
            $produto    = new \App\Models\ProdutoModel();
            $info = [
                'id_produto'                => $this->request->getPost("id_produto"),
                'nm_produto'                => $this->request->getPost("nome_produto"),
                'nr_valor'                  => $this->removerFormatacaoMoeda($this->request->getPost("valor_produto")),
                'nr_frete'                  => $this->removerFormatacaoMoeda($this->request->getPost("frete_produto")),
                'qt_unidades_disponiveis'   => $this->request->getPost("estoque_produto")
            ];
 
            if ($produto->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Produto Atualizado com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao atualizar. Por favor contacte o administrador do sistema!.</div>;'));
            }
            
        } else {
            //carrego os dados do produto
            $produto            = new \App\Models\ProdutoModel();
            $data               = $produto->listaProdutos($id);
            $data[0]->nr_valor = "R$ ".number_format($data[0]->nr_valor,2,",",".");
            $data[0]->nr_frete = "R$ ".number_format($data[0]->nr_frete,2,",",".");

            echo json_encode($data[0]);
        }

    }

    //quando for post, o id é nulo pq eu dou o post no caminho sem parametro
    //o id vem no array do post
    public function remover_ajax($id) {

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode editar o produto via ajax
        //essa função é usada na área de lista de produtos.
        //entao precisa ser adm para editar
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }
        
            $produto            = new \App\Models\ProdutoModel();
            $info = [
                'id_produto'      => $id,
                'id_status'       => 2,
            ];
 
            if ($produto->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Produto removido com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao remover produto. Por favor contacte o administrador do sistema!.</div>;'));
            }
            

    }

    
    protected function removerFormatacaoMoeda($valor){

            $valor = explode ("R$",$valor);
            $valor = $valor[1];
            $valor = str_replace (".","",$valor);
            $valor = str_replace (",",".",$valor);
            return $valor;

    }
    
}