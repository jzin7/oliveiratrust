<link rel="stylesheet" id="bs-stylesheet" href="<?php echo base_url('/public/css/jquery-confirm.css') ?>">
<script src="<?php echo base_url('/public/assets/scripts/jquery-confirm.js') ?>"></script>

<script>

$( document ).ready(function() {

    var atualizacao = setInterval(checarSessao, 10000);//a cada 10 segundos eu checo o login
 

    function checarSessao() {
        
        $.get( "<?php echo base_url('cliente/checaSessaoExterno')?>")
                .done(function( data ) {
                          if(data == 0) {
                            
                            $.confirm({
                                
                                title: 'Sessão expirou',
                                icon: 'fa fa-question-circle',
                                content: 'O tempo de sua sessão expirou. Por favor, por segurança, efetue o login novamente.',
                                buttons: {
                                    confirm: {
                                        text: "OK",
                                        btnClass: 'btn-blue',
                                        action:function () {
                                            location.href = '<?php echo base_url('/cliente/2') ?>';
                                            
                                        }
                                    } 
                                }
                            });
                            clearInterval(atualizacao);
                            return false;
                        }
                    });
    }


});
</script>

<script type="text/javascript" src="<?php echo base_url();?>/public/assets/scripts/main.js"></script></body>
</html>