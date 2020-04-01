<?php

	namespace Models;
	
	class Mensagem{
		
		private $dtCriacao; //P.K.
		private $texto;
		private $emailRemetente; //F.K.
		private $emailDestinatario; //F.K.
		private $isAnonima; //F.K.
		private $autor;


		function __construct($dtCriacao, $texto, $emailRemetente, $emailDestinatario, $isAnonima, $autor)
		{
			$this->dtCriacao = $dtCriacao;
			$this->texto = $texto;
			$this->emailRemetente = $emailRemetente;
			$this->emailDestinatario = $emailDestinatario;
			$this->isAnonima = $isAnonima;
			$this->autor = $autor;
		}
	    
		public function getAutor()
	    {
	        return $this->autor;
	    }

	    
	    public function setAutor($autor)
	    {
	        $this->autor = $autor;
	    }

	    public function getdtCriacao()
	    {
	        return $this->dtCriacao;
	    }

	    
	    public function setdtCriacao($dtCriacao)
	    {
	        $this->dtCriacao = $dtCriacao;
	    }

	    
	    public function getTexto()
	    {
	        return $this->texto;
	    }

	    
	    public function setTexto($texto)
	    {
	        $this->texto = $texto;
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
	}
?>