<?php
	
	namespace Models;

	class RecoveryPassword{
		private $email; //F.K.
		private $token; //P.K.
		private $dataHoraExpiracao;

    function __construct($email, $token){
            $this->email = $email;
            $this->token = $token;
            $this->dataHoraExpiracao = date("Y/m/d H:i:s");
        }
	
    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function getDataHoraExpiracao(){
        return $this->dataHoraExpiracao;
    }

    public function setDataHoraExpiracao($dataHoraExpiracao){
        $this->dataHoraExpiracao = $dataHoraExpiracao;
    }
}

?>