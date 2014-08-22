<?php 
	class Obj_field {
		public $field_name;
		public $field_value;
		private $field_comparer=null;
		
		function __construct($field_name, $field_value, $field_comparer=null) {
			$this->field_name = $field_name;
			$this->field_value = $field_value;
			
			if ($field_comparer !== null) {
				if (Obj_sql_comparer::is_valid($field_comparer)) {
					$this->field_comparer = $field_comparer;
				} else {
					throw new Exception('invalid field comparer');
				}
			}
		}
		
		function get_field_comparer() {
			return $this->field_comparer;
		}
	}
?>