<?php namespace App\Controllers;

class Pedido extends BaseController
{
    public $session;

    public function __construct(){
        $this->session = session();
    }
 
    //link URL/cliente
	public function index($msg=null)
	{
        //se abrir só com "/pedido" na url eu jogo para "/pedido/lista";
        return redirect()->to(base_url("/pedido/lista"));
    }

    //esta página se abre e nela eu consulto a lista de usuários pelo ajax
    public function lista(){
        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();
        
        //vejo se o usuário é administrador
        /*if ($this->session->permissao !='Administrador'){
            return redirect()->to(base_url("/dashboard"));
        }*/

        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;
        $data['msg']        = '';
        return view('pedidolista',$data);
    }
    
    public function lista_ajax(){

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode listar os clientes
        /*if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }*/
        
        if ($this->request->getMethod() =='post'){
 
            $sequencial     = intval($this->request->getPost("draw"));
            $inicio         = intval($this->request->getPost("start"));
            $tamanho        = intval($this->request->getPost("length"));
            $ordem          = $this->request->getPost("order");
            $busca          = $this->request->getPost("search");
            $busca          = $busca['value'];

            //$this->db->limit($tamanho,$inicio);
            $pedidosModel   = new \App\Models\PedidoModel();
            $pedidos       = $pedidosModel->listaPedidosAjax($tamanho,$inicio,$ordem,$busca);
            
            $data = array();
            foreach($pedidos as $rows)
            {
                if ($rows->id_cliente!=$this->session->id_cliente){
                    //se for administrador eu coloco (adm) ao final do nome dele
                    $rows->nr_valor_frete = "R$ ".number_format($rows->nr_valor_frete,2,",",".");
                    $rows->nr_valor_total = "R$ ".number_format($rows->nr_valor_total,2,",",".");
                    
                    //se o produto tiver ativo, eu coloco no grid o link pra ele
                    //se nao eu coloco um tooltip falando que ele foi excluido já
                    if ($rows->id_status_produto==1){
                        $linkProduto    = '<a href="'.base_url('produto/lista').'/'.$rows->id_produto.'">'.$rows->nm_produto.'</a>';
                    } else {
                        $linkProduto = '<span alt="Produto Excluído">'.$rows->nm_produto.'</span>';
                    }

                    $data[]= array(
                        '<a href="'.base_url('pedido/cliente/').'/'.$rows->id_cliente.'"  class="mr-1"><i class="pe-7s-shopbag" aria-hidden="true" title="Listar Pedidos"></i> '.$rows->nm_cliente.'</a>',
                        $linkProduto,
                        $rows->nr_quantidade,
                        $rows->nr_valor_frete,
                        $rows->nr_valor_total,
                        $rows->data_pedido,
                        $rows->nm_pedido_produto_status,
                        '<a href="#"  id="'.$rows->id_pedido_produto.'" class="editar_pedido btn btn_editar mr-1"><i class="fa fa-fw" aria-hidden="true" title="Editar"></i> Editar</a>'
                    );     //href="'.base_url('cliente/editar').'/'.$rows->id_cliente.'"
                }
                
            }
            
            //se ele for administrador eu listo todos os pedidos do sistema
            //se não for, eu listo só os dele;
            if ($this->session->permissao != "Administrador"){
                $totalPedidos = $pedidosModel->totalPedidos($this->session->id_cliente);
            } else {
                $totalPedidos = $pedidosModel->totalPedidos();
            }
            
            $totalClientes = $totalPedidos[0]->total_pedidos;
            $output = array(
                "draw" => $sequencial,
                "recordsTotal" => $totalClientes,
                "recordsFiltered" => $totalClientes,
                "data" => $data
            );
            echo json_encode($output);
            exit();
        } 
        
        $pedido = new \App\Models\PedidoModel();
        //se ele for administrador eu listo todos os pedidos do sistema
        //se não for, eu listo só os dele;
        if ($this->session->permissao != "Administrador"){
            $data = $pedido->listaPedidos($this->session->id_cliente);
        } else {
            $data = $pedido->listaPedidos();
        }

        echo json_encode($data);
    }

    //essa função servirá para o administrador ver todos os pedidos de um cliente
    //ou também um cliente ver todos os seus pedidos
    //se o id_cliente for null é pq é o proprio vendo seus pedidos
    //se eu passar por parâmetro é pq é o admin querendo ver seus pedidos
    public function cliente($id_cliente=null){

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode listar os pedidos se o id for passado
        if ($id_cliente!=null){
            if ($this->session->permissao != "Administrador"){
                return redirect()->to(base_url('dashboard'));
            }
        } else {

            //se eu não passei o id, é pq eu sou o usuário então seto ele pro meu id de sessao
            $id_cliente = $this->session->id_cliente;
        }
        
        
        $data['dados'] = null;
        $pedido = new \App\Models\PedidoModel();
        $pedidos  = $pedido->listaPedidos($id_cliente);
        
        //vou formatar os valores monetarios
        foreach ($pedidos as $pedido){
            $pedido->nr_valor_frete     = "R$ ".number_format($pedido->nr_valor_frete,2,",",".");
            $pedido->nr_valor_total     = "R$ ".number_format($pedido->nr_valor_total,2,",",".");
            $pedido->nr_valor_unitario  = "R$ ".number_format($pedido->nr_valor_unitario,2,",",".");
            $data['dados'][] = $pedido;
            $pedidos = 1;
        }

        //se nao tiver nenhum pedido para o usuário minimamente eu pego o nome dele
        if ($data['dados']==null){
            $cliente        = new \App\Models\ClienteModel();
            $dadosCliente   = $cliente->find($id_cliente);
            
            //$data['dados'][0]$dados[0]->nm_cliente
            $pedidos        = 0;
            $data['dados'][0] = (object) [
                                        'nm_cliente'     => $dadosCliente->nm_cliente
                                        ];
        }

        //echo count($data['dados']);exit;
        $data['pedidos'] = $pedidos;
        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;
        return view('pedidocliente',$data);
    }


    public function inserir_ajax(){

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

         //somente o administrador pode editar o cliente via ajax
         //essa função é usada na área de lista de clientes.
         //entao precisa ser adm para editar
         if ($this->session->permissao != "Administrador"){
             return redirect()->to(base_url('dashboard'));
         }

         if ($this->request->getMethod() =='post'){
            $cliente                = new \App\Models\ClienteModel();
            $administrador          = $this->request->getPost("administrador") ? "1" : "0";
            $clienteController      = new \App\Controllers\Cliente();
            $info = [
                'nm_cliente'     => $this->request->getPost("nome_cliente"),
                'tx_email'       => $this->request->getPost("texto_email"),
                'administrador'  => $administrador,
                'tx_senha'       => $clienteController->criptografar($this->request->getPost("texto_senha"))
            ];

            if ($cliente->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Cliente inserido com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao inserir cliente. Por favor contacte o administrador do sistema!.</div>;'));
            }
            
         }

    }

    //quando for post, o id é nulo pq eu dou o post no caminho sem parametro
    //o id vem no array do post
    public function editar_ajax($id=null) {

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode editar o cliente via ajax
        //essa função é usada na área de lista de clientes.
        //entao precisa ser adm para editar
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }

        //se for post ele está enviando os dados novos
        if ($this->request->getMethod() =='post'){
            $pedido    = new \App\Models\PedidoModel();

            //$id_cliente = $this->request->getPost("id_cliente");
            
            $info = [
                'id_pedido_produto'     => $this->request->getPost("id_pedido_produto"),
                'id_status'             => $this->request->getPost("id_status")
            ];

            if ($pedido->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Pedido Atualizado com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao atualizar. Por favor contacte o administrador do sistema!.</div>;'));
            }
            
        } else {
            //carrego os dados do Pedido
            $pedido            = new \App\Models\PedidoModel();
            $data               = $pedido->find($id);
            echo json_encode($data);
        }

    }

    //quando for post, o id é nulo pq eu dou o post no caminho sem parametro
    //o id vem no array do post
    public function remover_ajax($id) {

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        //somente o administrador pode editar o cliente via ajax
        //essa função é usada na área de lista de clientes.
        //entao precisa ser adm para editar
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }
        
            $cliente            = new \App\Models\ClienteModel();
            $info = [
                'id_cliente'      => $id,
                'id_status'       => 2,
            ];
 
            if ($cliente->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Cliente removido com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao remover cliente. Por favor contacte o administrador do sistema!.</div>;'));
            }
    }

    public function cadastrar(){

        //vejo se ele está logado
        $checaSessao = new \App\Controllers\Cliente();
        $checaSessao->checaSessao();

        $data['msg']        = '';
        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;

        //se for post ele está fazendo um pedido novo
        if ($this->request->getMethod() =='post'){

            //pego as informações atuais do produto (valor e frete)
            $produtoModel           = new \App\Models\ProdutoModel();
            $produto                = $produtoModel->listaProdutos($this->request->getPost("id_produto"));

            //para jogar no pedido
            $info = [
                'id_produto'        => $this->request->getPost("id_produto"),
                'id_cliente'        => $this->session->id_cliente,
                'nr_quantidade'     => $this->request->getPost("quantidade"),
                'nr_valor_frete'    => $produto[0]->nr_frete,
                'nr_valor_total'    => ($produto[0]->nr_valor * $this->request->getPost("quantidade") + $produto[0]->nr_frete),
            ];
            
            $pedidoModel            = new \App\Models\PedidoModel();
            if ($pedidoModel->save($info)){
                return redirect()->to(base_url("pedido/cliente/"));
            }


        //se nao for post é só a lista que vou mostrar
        } else {

            //monto o select de produto
            $produtosModel      = new \App\Models\ProdutoModel();
            $produtos           = $produtosModel->listaProdutos();
            foreach($produtos as $produto){
                $produto->nr_frete      = "R$ ".number_format($produto->nr_frete,2,",",".");
                $produto->nr_valor      = "R$ ".number_format($produto->nr_valor,2,",",".");
                
                $data['produtos'][] = $produto;
            }
            
            return view('pedidocadastrar',$data);
        }


    }
 


    
}