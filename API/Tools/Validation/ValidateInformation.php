<?php
	namespace Tools;

	class ValidateInformation{

		public static function IsNullOrEmptyString($str){
    		
    		return (!isset($str) || trim($str) === '');

		}


	}

?>