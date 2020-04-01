<?php

	namespace Models;

	class UsuarioEntidade{
		private $codigoEntidade; //F.K.
		private $emailResponsavel; //F.K.
		private $dataPosse; //P.K.

		function __construct($codigoEntidade, $emailResponsavel){
			$this->codigoEntidade = $codigoEntidade;
			$this->emailResponsavel = $emailResponsavel;
		}
	
    
    public function getCodigoEntidade()
    {
        return $this->codigoEntidade;
    }

    
    public function setCodigoEntidade($codigoEntidade)
    {
        $this->codigoEntidade = $codigoEntidade;

        return $this;
    }

    
    public function getEmailResponsavel()
    {
        return $this->emailResponsavel;
    }

    
    public function setEmailResponsavel($emailResponsavel)
    {
        $this->emailResponsavel = $emailResponsavel;

        return $this;
    }

    
    public function getDataPosse()
    {
        return $this->dataPosse;
    }

    
    public function setDataPosse($dataPosse)
    {
        $this->dataPosse = $dataPosse;

        return $this;
    }
}


?>