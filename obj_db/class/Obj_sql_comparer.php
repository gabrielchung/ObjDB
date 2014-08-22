<?php 
	class Obj_sql_comparer {
		const EQUAL = '==';
		const NOT_EQUAL = '<>';
		const LARGER = '>';
		const LARGER_OR_EQUAL = '>=';
		const SMALLER = '<';
		const SMALLER_OR_EQUAL = '<=';
		const IS_NULL = 'IS NULL';
		const LIKE = 'LIKE';
		
		static function is_valid($str) {
			return (
					   ($str === Obj_sql_comparer::EQUAL)
					|| ($str === Obj_sql_comparer::NOT_EQUAL)
					|| ($str === Obj_sql_comparer::LARGER)
					|| ($str === Obj_sql_comparer::LARGER_OR_EQUAL)
					|| ($str === Obj_sql_comparer::SMALLER)
					|| ($str === Obj_sql_comparer::SMALLER_OR_EQUAL)
					|| (strtoupper($str) === Obj_sql_comparer::IS_NULL)
					|| (strtoupper($str) === Obj_sql_comparer::LIKE)
				);
		}
	}
?>