<?php namespace App\Controllers;

class Dashboard extends BaseController
{
    private $sessao;

    public function __construct(){
        $this->sessao = session();
    }
    
	public function index($msg=null)
	{
        //verifico a sessao
        $login  = new \App\Controllers\Cliente();   
        $login->checaSessao(); 

        $data['msg']            = '';
        //envio as informações de sessão para a view
        $data['sessao']         = $this->session;
        
        //pego as estatisticas
        $pedidosModel           = new \App\Models\PedidoModel();
        //se ele for adm eu vejo as estatiticas de todo o sistema
        //se for usuario comum, só os dados dele mesmo
        if ($this->session->permissao != "Administrador"){
            $estatisticas           = $pedidosModel->estatisticas($this->session->id_cliente);
        } else {
            $estatisticas           = $pedidosModel->estatisticas();
        }

        
        
        if (count($estatisticas)>0){
        foreach($estatisticas as $estatistica){
            $estatistica->valor_total      = "R$ ".number_format($estatistica->valor_total,2,",",".");
            $data['estatisticas'][] = $estatistica;
        }
        } else {
            $data['estatisticas'] = null;
        } 
                                
        return view('dashboard',$data);
    }
    
    
}