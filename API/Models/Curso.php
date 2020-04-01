<?php

	namespace Models;

	class Curso{
		private $codCurso; //P.K.
		private $nome;

		function __construct($codCurso, $nome){
			$this->codCurso = $codCurso;
			$this->nome = $nome;
		}

		public function getCodigoCurso()
	    {
	        return $this->codCurso;
	    }

	    public function setCodigoCurso($codCurso)
	    {
	        $this->codCurso = $codCurso;
	    }
	    public function getNome()
	    {
	        return $this->nome;
	    }

	    public function setNome($nome)
	    {
	        $this->nome = $nome;
	    }
	}
?>