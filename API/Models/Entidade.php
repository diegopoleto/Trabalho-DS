<?php

	namespace Models;

	class Entidade{
		private $codigoEntidade; //P.K.
		private $nome;
		private $descricao;
		private $endereco;
		private $codigoCurso; //F.K.

		function __construct($nome, $endereco, $descricao, $codigoCurso = null)
		{
			$this->endereco = $endereco;
			$this->descricao = $descricao;
			$this->nome = $nome;
			$this->codigoCurso = $codigoCurso;
		}
 
	    public function getCodigoEntidade()
	    {
	        return $this->codigoEntidade;
	    }


	    public function setCodigoEntidade($codigoEntidade)
	    {
	        $this->codigoEntidade = $codigoEntidade;
	    }

	 
	    public function getEndereco()
	    {
	        return $this->endereco;
	    }


	    public function setEndereco($endereco)
	    {
	        $this->endereco = $endereco;
	    }

	 
	    public function getDescricao()
	    {
	        return $this->descricao;
	    }


	    public function setDescricao($descricao)
	    {
	        $this->descricao = $descricao;
	    }

	 
	    public function getNome()
	    {
	        return $this->nome;
	    }


	    public function setNome($nome)
	    {
	        $this->nome = $nome;
	    }
	   


	    public function getCodigoCurso()
	    {
	        return $this->codigoCurso;
	    }


	    public function setCodigoCurso($codigoCurso)
	    {
	        $this->codigoCurso = $codigoCurso;
	    }
	}


?>