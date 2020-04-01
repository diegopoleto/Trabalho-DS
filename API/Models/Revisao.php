<?php

	namespace Models;

	class Revisao{
		private $emailRemetente; 
		private	$emailDestinatario;
		private	$isAnonima;
		private $emailSolicRevisao; 
		private $emailRevisor;
		private $dataSolicRevisao;

		private $dataRevisao;
		private $comentarioRevisao;
		private $gravidadeInfracao;

		function __construct($emailRemetente, $emailDestinatario, $isAnonima, $emailSolicRevisao){
			$this->emailRemetente = $emailRemetente;
			$this->emailDestinatario = $emailDestinatario;
			$this->isAnonima = $isAnonima;
			$this->emailSolicRevisao = $emailSolicRevisao;
		}

		public function getEmailRemetente()
	    {
	        return $this->emailRemetente;
	    }
	    
	    public function setEmailRemetente($emailRemetente)
	    {
	        $this->emailRemetente = $emailRemetente;
	    }

	    public function getEmailDestinatario()
	    {
	        return $this->emailDestinatario;
	    }
	    
	    public function setEmailDestinatario($emailDestinatario)
	    {
	        $this->emailDestinatario = $emailDestinatario;
	    }

	    public function getIsAnonima()
	    {
	        return $this->isAnonima;
	    }
	    
	    public function setIsAnonima($isAnonima)
	    {
	        $this->isAnonima = $isAnonima;
	    }

	    public function getEmailSolicRevisao()
	    {
	        return $this->emailSolicRevisao;
	    }
	    
	    public function setEmailSolicRevisao($emailSolicRevisao)
	    {
	        $this->emailSolicRevisao = $emailSolicRevisao;
	    }
		
	    public function getEmailRevisor()
	    {
	        return $this->emailRevisor;
	    }
	  
	    public function setEmailRevisor($emailRevisor)
	    {
	        $this->emailRevisor = $emailRevisor;
	    }

	    public function getDataSolicRevisao()
	    {
	        return $this->dataSolicRevisao;
	    }
	    
	    public function setDataSolicRevisao($dataSolicRevisao)
	    {
	        $this->dataSolicRevisao = $dataSolicRevisao;
	    }					

		public function getDataRevisao()
	    {
	        return $this->dataRevisao;
	    }
	    
	    public function setDataRevisao($dataRevisao)
	    {
	        $this->dataRevisao = $dataRevisao;
	    }

	    public function getComentarioRevisao()
	    {
	        return $this->comentarioRevisao;
	    }
	    
	    public function setComentarioRevisao($comentarioRevisao)
	    {
	        $this->comentarioRevisao = $comentarioRevisao;
	    }
	    
	    public function getGravidadeInfracao()
	    {
	        return $this->gravidadeInfracao;
	    }
	    
	    public function setGravidadeInfracao($gravidadeInfracao)
	    {
	        $this->gravidadeInfracao = $gravidadeInfracao;
	    }
	    
    }

?>