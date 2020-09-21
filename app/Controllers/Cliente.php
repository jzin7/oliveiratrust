<?php namespace App\Controllers;

class Cliente extends BaseController
{
    public $session;

    public function __construct(){
        $this->session = session();
    }
 
    //link URL/cliente
	public function index($msg=null)
	{
    
        $data['msg']    = ''; //crio vazio para na view eu não ter que testar nada. Só imprimir.
        $msgErro        =  '<div class="alert alert-warning" role="alert">Seu login expirou. Por favor efetue o cliente novamente.</div>';      
        //mensagem que vem de dentro do sistema quando um usuário tem sua sessão expirada
        if ($msg==2){
            $data['msg'] = $msgErro;
        }
        
        //este é o envio do post de cliente
        if ($this->request->getMethod() =='post'){
            $tx_email   = trim( $this->request->getPost("email") );
            $tx_senha   = trim( $this->request->getPost("senha") );
            $data['msg'] = '';
             
            
            if ( ($tx_email=='') or ($tx_senha=='') ){
                $data['msg'] = $msgErro;
                return view('clientelogin',$data);
            }

            //vejo se os dados de cliente digitado existem.
            $ClienteModel   = new \App\Models\ClienteModel();
            $cliente        = $ClienteModel     ->where('tx_email',$tx_email)
                                                ->where('tx_senha',$this->criptografar($tx_senha))
                                                ->where('id_status', 1)
                                                ->findAll();

            //se nao existir eu seto a variavel de mensagem de erro e mostro a view
            if ($cliente == null){
                $data['msg'] = '<div class="alert alert-danger" role="alert">Desculpe, dados inseridos não conferem.</div>';
                return view('clientelogin',$data);
            } else {
                
                // se os dados de cliente conferem eu já seto as variáveis de sessão
                $this->session->set('id_cliente', $cliente[0]->id_cliente);
                $this->session->set('id_status', $cliente[0]->id_status);
                $this->session->set('tx_email', $cliente[0]->tx_email);
                $this->session->set('nm_cliente', $cliente[0]->nm_cliente);
                $this->session->set('logado', '3xat@men3');
                $this->session->markAsTempdata('logado', 900);//15minutos
                if ($cliente[0]->administrador==1){
                    $permissao = 'Administrador';
                } else {
                    $permissao = 'Usuario';
                }
                $this->session->set('permissao', $permissao);
                //redireciono ele para a página de pedidos
                return redirect()->to(base_url('dashboard'));
            }
        } else {
            return view('clientelogin',$data);
        }
    }
    
    public function lista_ajax(){

        //vejo se ele está logado
        $this->checaSessao();

        //somente o administrador pode listar os clientes
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }
        
        if ($this->request->getMethod() =='post'){
 
            $sequencial     = intval($this->request->getPost("draw"));
            $inicio         = intval($this->request->getPost("start"));
            $tamanho        = intval($this->request->getPost("length"));
            $ordem          = $this->request->getPost("order");
            $busca          = $this->request->getPost("search");
            $busca          = $busca['value'];

            //$this->db->limit($tamanho,$inicio);
            $clientesModel  = new \App\Models\ClienteModel();
            $clientes       = $clientesModel->listaClientesAjax($tamanho,$inicio,$ordem,$busca);
            
            $data = array();
            foreach($clientes as $rows)
            {
                if ($rows->id_cliente!=$this->session->id_cliente){
                    //se for administrador eu coloco (adm) ao final do nome dele
                    if ($rows->administrador ==1){
                        $rows->nm_cliente .= ' <Strong style="color:#d40001">(Adm)</strong>';
                    }

                    if ($rows->total_pedidos>0){
                        $pedidos = '<a href="' . base_url('pedido/cliente/') . '/' . $rows->id_cliente . '">' . $rows->total_pedidos . '</a>';
                    } else {
                        $pedidos = $rows->total_pedidos;
                    }
                    $data[]= array(
                        $rows->nm_cliente,
                        $rows->tx_email,
                        $pedidos,
                        $rows->data_cadastro,
                        '<a href="#"  id="'.$rows->id_cliente.'" class="editar_cliente btn btn_editar mr-1"><i class="fa fa-fw" aria-hidden="true" title="Editar"></i> Editar</a>
                        <a href="#"  id="'.$rows->id_cliente.'" class="remover_cliente btn btn_remover mr-1"><i class="fa fa-fw" aria-hidden="true" title="Copy to use times-circle"></i> Remover</a>'
                    );     //href="'.base_url('cliente/editar').'/'.$rows->id_cliente.'"
                }
                
            }
            
            $totalClientes = $clientesModel->totalClientes($this->session->id_cliente);
            $totalClientes = $totalClientes[0]->total;
            $output = array(
                "draw" => $sequencial,
                "recordsTotal" => $totalClientes,
                "recordsFiltered" => $totalClientes,
                "data" => $data
            );
            echo json_encode($output);
            exit();
        } 
       
    }

    public function inserir_ajax(){

         //vejo se ele está logado
         $this->checaSessao();

         //somente o administrador pode editar o cliente via ajax
         //essa função é usada na área de lista de clientes.
         //entao precisa ser adm para editar
         if ($this->session->permissao != "Administrador"){
             return redirect()->to(base_url('dashboard'));
         }

         if ($this->request->getMethod() =='post'){
            $cliente    = new \App\Models\ClienteModel();
            $administrador       = $this->request->getPost("administrador") ? "1" : "0";
            $info = [
                'nm_cliente'     => $this->request->getPost("nome_cliente"),
                'tx_email'       => $this->request->getPost("texto_email"),
                'administrador'  => $administrador,
                'tx_senha'       => $this->criptografar($this->request->getPost("texto_senha"))
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
        $this->checaSessao();

        //somente o administrador pode editar o cliente via ajax
        //essa função é usada na área de lista de clientes.
        //entao precisa ser adm para editar
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }

        //se for post ele está enviando os dados novos
        if ($this->request->getMethod() =='post'){
            $cliente    = new \App\Models\ClienteModel();

            //$id_cliente = $this->request->getPost("id_cliente");
            $administrador        = $this->request->getPost("administrador") ? "1" : "0";
            $info = [
                'id_cliente'      => $this->request->getPost("id_cliente"),
                'nm_cliente'      => $this->request->getPost("nome_cliente"),
                'administrador'   => $administrador,
                'tx_senha'        => $this->criptografar($this->request->getPost("texto_senha"))
            ];
 
            if ($cliente->save($info)){
                echo json_encode(array("status" => TRUE, "msg" => '<div class="alert alert-success" role="alert">Cliente Atualizado com sucesso!.</div>'));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => '<div class="alert alert-danger" role="alert">Ocorreu um erro ao atualizar. Por favor contacte o administrador do sistema!.</div>;'));
            }
            
        } else {
            //carrego os dados do cliente
            $cliente            = new \App\Models\ClienteModel();
            $data               = $cliente->find($id);
            $data->tx_senha     = $this->decriptografar($data->tx_senha);
            echo json_encode($data);
        }

    }

    //quando for post, o id é nulo pq eu dou o post no caminho sem parametro
    //o id vem no array do post
    public function remover_ajax($id) {

        //vejo se ele está logado
        $this->checaSessao();

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

    /*  
        É CHAMADO DA "url/cadastro"
    */

    public function cadastro(){

        $data['msg'] = '';
        if ($this->request->getMethod() =='post'){
            
            //FAÇO A PROTEÇÃO de posts vindo de outro local que nao seja a nossa página
            if(stripos($_SERVER["REQUEST_URI"],'cadastro') == TRUE)
            {

                $ClienteModel = new \App\Models\ClienteModel();

                /*VEJO SE ESTE EMAIL JÁ EXISTE NO SISTEMA com status ativo*/
                //STATUS: removido (3). Se não for removido será Ativo(1) ou pendente(2).
                //Então só deixo cadastrar se ele não tiver um cliente ativo ou pendente
                $clientes = $ClienteModel ->where('tx_email', $this->request->getPost("email"))
                                        ->where('id_status !=', 3) 
                                        ->findAll();
                 
                $linhas = sizeof($clientes);
                //JÁ TENHO EMAIL ASSIM. RETORNO DIZENDO QUE NÃO PODE CADASTRAR
                if ($linhas >0){
                    $data['msg'] = '<div class="alert alert-danger" role="alert">Email já cadastrado no sistema.</div>';
                } else {
                    $ClienteModel->set("nm_cliente",$this->request->getPost("nome"));
                    $ClienteModel->set("tx_email",$this->request->getPost("email"));
                    $ClienteModel->set("tx_senha",$this->criptografar($this->request->getPost("senha")));

                    if ($ClienteModel->insert()){
                        //inseri ok no banco
                        $data['msg'] = '<div class="alert alert-success" role="alert">cliente Cadastrado com sucesso. Você receberá um email assim que ela for ativada.<br> <a class="oliveira" href="'.base_url('/').'">Efetuar o cliente</a></div>';
    
                    } else {
                        //ocorreu algum erro no sistema
                        $data['msg'] = '<div class="alert alert-danger" role="alert">Ocorreu um erro ao realizar o cadastro. Por favor entre em contato com o administrador</div>';
                    }
                }

               
            }
            else // alguem tá tentando entrar de forma errada
            {
                return redirect()->to(base_url());
                
            }
        }

        return view('logincadastro',$data);

    }


    /*PÁGINA DE FORMULÁRIO PARA EDITAR INTERNAMENTE UM CADASTRO*/

    public function form($id_cliente=null){
        
        //vejo se ele está logado
        $this->checaSessao();

        //se ele entrar no form sem o codigo eu redireciono ele pro dashboard
        //isso evita que ocorra algum erro na tela
        if ($id_cliente==null){
            return redirect()->to(base_url('dashboard'));
        }

        //somente usuário administrador pode editar qualquer usuário
        if ( ($this->session->id_cliente != $id_cliente) and ($this->session->permissao != "Administrador") ){
            return redirect()->to(base_url('dashboard'));
        }


        $data['sessao']         = $this->session;
        $data['msg']            = '';
        $ClienteModel             = new \App\Models\ClienteModel();

        //se mandou um post
        if ($this->request->getMethod() =='post'){
            $id_cliente     = $this->request->getPost("id_cliente");
            //pego o registro
            $cliente        = $ClienteModel->find($id_cliente);
         
            $cliente->nm_cliente = $this->request->getPost("nome");
            $cliente->tx_senha = $this->criptografar($this->request->getPost("senha"));
            
            //se o usuário for administrador ele vai ter um campo pra ativar ou desativar.
            //neste caso eu altero o status do usuário. Se for usuário comum eu não mexo no status
            if ($this->session->permissao=="Administrador"){
                if ($this->request->getPost("id_status")=='on'){
                    $id_status = 1;
                } else {
                    $id_status = 2;
                }
                $cliente->id_status = $id_status;
            }

            //VEJO SE ALGUM VEIO VAZIO
            if (    (trim($cliente->nm_cliente)=='') or
                    (trim($cliente->tx_senha)=='')
                ) {
                    $data['msg'] = '<div class="alert alert-warning" role="alert">Nenhum campo pode ficar em branco! Atualização Cancelada</div>';
                } else {

                    //SE NADA ESTAVA VAZIO EU FAÇO O UPDATE
                    if ($ClienteModel->update($id_cliente,$cliente)){

                        //atualizo a sessao também se for ele
                        if ($this->session->id_cliente==$id_cliente){
                            
                            $this->session->nm_cliente    = $cliente->nm_cliente;
                            $this->session->id_status   = $cliente->id_status;
                             
                        }

                        $data['msg'] = '<div class="alert alert-success" role="alert">cliente Atualizado com sucesso!</div>';
                    } else {
                        $data['msg'] = '<div class="alert alert-danger" role="alert">Ops, ocorreu um problema ao atualizar este registro!</div>';
                    }

                }

        } // se ele acessou a página diretamente sem post
         
            $data['cliente']         = $ClienteModel    ->where('id_cliente', $id_cliente)
                                                        ->findAll();
            $data['cliente'][0]->tx_senha = $this->decriptografar($data['cliente'][0]->tx_senha);
            if ($data['cliente'][0]->id_status==1) {$data['cliente'][0]->id_status='checked="checked"';} else {$data['cliente'][0]->id_status='';}
        
        return view('clienteForm',$data);
    }

    //esta página se abre e nela eu consulto a lista de usuários pelo ajax
    public function lista(){
        //vejo se ele está logado
        $this->checaSessao();

        //vejo se o usuário é administrador
        if ($this->session->permissao !='Administrador'){
            return redirect()->to(base_url("/dashboard"));
        }

        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;
        $data['msg']        = '';
        return view('clientelista',$data);
    }

    /* FUNÇÃO PARA ATIVAR OS USUÁRIOS RECEM CADASTRADOS */
    public function ativar($id_cliente=null){
        
        //vejo se ele está logado
        $this->checaSessao();

        //vejo se o usuário é administrador
        if ($this->session->administrador!=1){
            return redirect()->to(base_url("/dashboard"));
        }
        
        $ClienteModel = new \App\Models\ClienteModel();
        $cliente      = $ClienteModel->find($id_cliente);

        if ( (is_null($id_cliente)) or (is_null($cliente)) ){
            return redirect()->to(base_url("/cliente/lista/0"));
        }

        $cliente->id_status = 1;
        if ($ClienteModel->update($id_cliente,$cliente)){
            return redirect()->to(base_url("/cliente/lista/1"));
        } else {
            return redirect()->to(base_url("/cliente/lista/0"));
            //
        }
    }

    /* FUNÇÃO PARA ATIVAR OS USUÁRIOS RECEM CADASTRADOS */
    public function remover($id_cliente){
         
        $ClienteModel = new \App\Models\ClienteModel();
        $cliente      = $ClienteModel->find($id_cliente);
        $cliente->id_status = 2;
        if ($ClienteModel->update($id_cliente,$cliente)){
            return redirect()->to(base_url("/cliente/lista/2"));
        } else {
            return redirect()->to(base_url("/cliente/lista/0"));
        }
    }
	

    /*CRIPTOGRAFO AS SENHAS NO SISTEMA*/
    function criptografar($senha){
        // Store a string into the variable which 
        // need to be Encrypted 
        $simple_string = $senha; 
        // Store cipher method 
        $ciphering = "BF-CBC"; 
        // Use OpenSSl encryption method 
        
        $options = 0; 
        // Use random_bytes() function which gives 
        // randomly 16 digit values 
        $encryption_iv = 22002312; 
        // Alternatively, we can use any 16 digit 
        // characters or numeric for iv 
        $encryption_key = openssl_digest(php_uname(), 'sha256', TRUE); 

        // Encryption of string process starts 
        $encryption = openssl_encrypt($simple_string, $ciphering, 
        $encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    /*DESENCRIPTOGRAFO A INFORMAÇÃO DA SENHA*/
    function decriptografar($senha){
            $options = 0; 
            $ciphering = "BF-CBC";
            // Decryption of string process starts 
            // Used random_bytes() which gives randomly 
            // 16 digit values 
            $iv_length = openssl_cipher_iv_length($ciphering); 
            //$decryption_iv = random_bytes($iv_length); 
            $encryption_iv = 22002312; 
            // Store the decryption key 
            $decryption_key = openssl_digest(php_uname(), 'sha256', TRUE); 
            
            // Descrypt the string 
            $decryption = openssl_decrypt ($senha, $ciphering, 
                        $decryption_key, $options, $encryption_iv); 
                        //echo $decryption;
            return $decryption;
            // Display the decrypted string 
    }

    public function checaSessao(){
     
        if (    ($this->session->logado=='') or //se não exister
                (
                    ($this->session->logado != '') and //ou se existir mas nao for igual
                    ($this->session->logado != '3xat@men3')  //ao meu código eu saio da página
                )
            ){
                
                $caminhoHome = "location:".base_url('cliente/2');
                header($caminhoHome);
                exit;
            }
            

    }

    public function checaSessaoExterno(){
       
        if (    ($this->session->has('logado')==false) or //se não exister
                (
                    ($this->session->has('logado')==true) and //ou se existir mas nao for igual
                    ($this->session->logado != '3xat@men3')  //ao meu código eu saio da página
                )
            ){
            echo 0;
        } else {
            echo 1;
        }
    }

    public function sair(){
        $this->session->destroy();
        return redirect()->to(base_url());

    }

    /*PÁGINA DE FORMULÁRIO PARA EDITAR INTERNAMENTE UM CADASTRO*/

    public function regras(){

        //somente o administrador pode ver as regras do sistema
        if ($this->session->permissao != "Administrador"){
            return redirect()->to(base_url('dashboard'));
        }

        //envio as informações de sessão para a view
        $data['sessao']     = $this->session;
        $data['msg']        = '';
        return view('regrasgerais',$data);

    }
    
}