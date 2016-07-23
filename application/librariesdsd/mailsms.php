<?php

if (!defined('BASEPATH'))
    exit('No esta permitido el acceso');

include_once("soapclientauth.php");

class Mailsms {
    protected $server;
    function __construct(){
        $this->server = get_settings('WS_SMS');
    }

    function send_mail($correoDestinatario,$tituloMail,$mensajeSend,$html,$correoEmisor,$claveEmisor)
    {
        $soapClient=new SoapClientAuth($this->server);
        return $soapClient->Mail(array('correoDestinatario'=>$correoDestinatario,'tituloMail'=>$tituloMail,'mensajeSend'=>$mensajeSend,
            'html'=>$html,'correoEmisor'=>$correoEmisor,'claveEmisor'=>$claveEmisor)
            );
    }
}