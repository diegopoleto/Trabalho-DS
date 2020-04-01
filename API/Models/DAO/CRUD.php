<?php

	interface CRUD{
		public static function create($obj);
		public static function read($sqlWhere);
		public static function update($obj, $sqlWhere);
		public static function delete($sqlWhere);
	}

?>