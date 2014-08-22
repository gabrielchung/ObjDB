<?php 
	class Obj_db {
		
		const LIMIT_OBJ_RETRIEVE = 50;
		const FIELD_NAME_CHAR_MAX_LIMIT = 200;
		const FIELD_VALUE_CHAR_MAX_LIMIT = 200;
		
		private static $ARY_OBJ_TABLE_FIELD_NAMES = array('scope_read', 'scope_read_id', 'scope_write', 'scope_write_id', 'namespace', 'obj_name', 'obj_json', 'id');
		
		private $namespace;
		
		function __construct($namespace) {
			$this->namespace = $namespace;
		}
		
		//
		// Scope
		//		
		private static function check_and_fill_ary_scope($ary_scope) {
			
			if ((!isset($ary_scope['read'])) || (!isset($ary_scope['write']))) {
					
				throw new Exception('Scope data are not specified.');
					
			} else {
					
				$scope_read = Obj_db::ensure_obj_scope($ary_scope['read']);
				$scope_write = Obj_db::ensure_obj_scope($ary_scope['write']);
					
				if (($scope_read === null) || ($scope_write === null)) {
					throw new Exception('Scope read or write are not correct');
				}
					
				// Initialize scope read id and write id
				$scope_read_id = null;
				$scope_write_id = null;
					
				// Scope read for USER
					
				if ($scope_read === Obj_scope::S_USER) {
			
					if (!isset($_SESSION['UserID'])) {
						throw new Exception('User is not logged in yet.');
					} else {
						$scope_read_id = $_SESSION['UserID'];
					}
			
				}
					
				// Scope read for USER
			
				if ($scope_write === Obj_scope::S_USER) {
						
					if (!isset($_SESSION['UserID'])) {
						throw new Exception('User is not logged in yet.');
					} else {
						$scope_write_id = $_SESSION['UserID'];
					}
						
				}
					
				// Scope read for GROUP
					
				if ($scope_read === Obj_scope::S_GROUP) {
			
					if (!isset($ary_scope['read_id'])) {
						throw new Exception('Read id is not specified.');
					} else {
						$scope_read_id = $ary_scope['read_id'];
					}

				}
			
				// Scope write for GROUP
					
				if ($scope_write === Obj_scope::S_GROUP) {
						
					if (!isset($ary_scope['write_id'])) {
						throw new Exception('Write id is not specified.');
					} else {
						$scope_read_id = $ary_scope['write_id'];
					}
						
				}
			
			}
			
			return array('read'=>$scope_read, 'read_id'=>$scope_read_id, 'write'=>$scope_write, 'write_id'=>$scope_write_id);
			
		}
		
		
		//
		// Retrieve
		//
		function retrieve($obj_name, $args, $select_field_names='obj_json', $for_write=false) {
			
			$read_or_write = $for_write ? 'write' : 'read';
			
			$finialized_select_field_names = $select_field_names . ',scope_'.$read_or_write.',scope_'.$read_or_write.'_id';
			
			if (!is_array($args)) {
				$result = array($this->retrieve_by_id($obj_name, $args, $finialized_select_field_names));
			} else {
				$result = $this->retrieve_by_fields($obj_name, $args, $finialized_select_field_names);
			}
			
			$result = Obj_db::prune_rows_without_scope_right($result, $for_write);
			
			$result = Obj_db::prune_scope_right_fields($select_field_names, $result, $for_write);
			
			return $result;
		}

		private static function get_obj_table_fields($select_field_names, $obj_table_name='obj') {
			
			$result = array();
			
			foreach (explode(',', $select_field_names) as $field_name) {
				
				if (in_array(trim($field_name), Obj_db::$ARY_OBJ_TABLE_FIELD_NAMES)) {
					array_push($result, $obj_table_name.'.'.trim($field_name));
				}
				
			}
			
			return implode($result, ',');
		}
		
		//
		//TO DO: handles no valid table fields
		//
		private function retrieve_by_id($obj_name, $id, $select_field_names) {
			
			$dbh = connect_db();
			
			//ignore scope at the moment
			$sql  = 'SELECT ';
			$sql .= Obj_db::get_obj_table_fields($select_field_names) . ' ';
			$sql .= 'FROM obj WHERE namespace=:namespace AND obj_name=:obj_name AND ';
			$sql .= 'id=:id';
			
			$sql .= ' LIMIT 1';
			
			//echo $sql;
			
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':namespace', $this->namespace);
			$sth->bindValue(':obj_name', $obj_name);
			$sth->bindValue(':id', $id);
			
			$sth->execute();
			
			if ($row = $sth->fetch()) {
				
				return $row;
				
// 				if (count($row) > 1)
// 					return $row;
// 				else
// 					return $row[0];
			}
			
			return null;
		}
		
		private function retrieve_by_fields($obj_name, $ary_obj_field, $select_field_names, $obj_limit=Obj_db::LIMIT_OBJ_RETRIEVE) {

			$dbh = connect_db();
			
			//ignore scope at the moment
			$sql  = 'SELECT ';
			$sql .= Obj_db::get_obj_table_fields($select_field_names) . ' ';
			$sql .= 'FROM obj ';
			
			foreach(range(1, $ary_obj_field) as $i) {
				$sql .= 'LEFT JOIN obj_field o'.$i.' ON obj.namespace = o'.$i.'.namespace AND obj.obj_name = o'.$i.'.obj_name AND obj.id = o'.$i.'.id ';
				$sql .= 'AND o'.$i.'.field_name = :o'.$i.'_field_name ';
			}

			$sql .= 'WHERE obj.namespace=:namespace AND obj.obj_name=:obj_name ';
			
			if (count($ary_obj_field) > 0) {

				$i = 1;
				foreach($ary_obj_field as $obj_field) {
					
					$sql .= 'AND ';
					
					if (is_numeric($obj_field->field_value)) {
						$sql .= 'o'.$i.'.field_value_num '.$obj_field->get_field_comparer().' '.$obj_field->field_value.' ';
					} else {
						$sql .= 'o'.$i.'.field_value_str '.$obj_field->get_field_comparer().' '.$obj_field->field_value.' ';
					}
							
					$i++;
				}
			}
			
			$sql .= ' LIMIT :obj_limit';
			
// 			echo $sql;
			
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':namespace', $this->namespace);
			$sth->bindValue(':obj_name', $obj_name);
			$sth->bindValue(':obj_limit', $obj_limit, PDO::PARAM_INT);
			
			$i = 1;
			foreach($ary_obj_field as $obj_field) {
				$sth->bindValue(':o'.$i.'_field_name', $obj_field->field_name);
				$i++;
			}
			
			try {

				$sth->execute();
			
			} catch (Exception $e) {
				return null;
			}
			
			$result = array();
			
			while ($row = $sth->fetch()) {
				
				array_push($result, $row);
				
// 				if ($whole_row)
// 					array_push($result, $row);
// 				else
// 					array_push($result, $row[0]);
			}
			
			return $result;
		}
		
		private static function from_data_ary_to_id_and_scope($ary_data) {
			
			$id = (int)$ary_data['id'];
			$scope_read = $ary_data['scope_read'];
			$scope_read_id = $ary_data['scope_read_id'];
			$scope_write = $ary_data['scope_write'];
			$scope_write_id = $ary_data['scope_write_id'];
			
			return array('id'=>$id, 'ary_scope'=>array('read'=>$scope_read, 'read_id'=>$scope_read_id, 'write'=>$scope_write, 'write_id'=>$scope_write_id));
		}
		
		private function retrieve_id_with_scope_by_id($obj_name, $id, $for_write=false) {
		
			$data_ary = $this->retrieve($obj_name, $id, 'id,scope_read,scope_read_id,scope_write,scope_write_id', $for_write);

			if (count($data_ary) === 1)
				return Obj_db::from_data_ary_to_id_and_scope($data_ary[0]);
			else
				return null;
			
		}
		
		private function retrieve_id_with_scope_by_fields($obj_name, $ary_obj_field, $for_write=false) {

			$result = array();
			
			$data_ary = $this->retrieve($obj_name, $ary_obj_field, 'id,scope_read,scope_read_id,scope_write,scope_write_id', $for_write);
			
			foreach ($data_ary as $data_row) {
				array_push($result, Obj_db::from_data_ary_to_id_and_scope($data_row));
			}
				
			return $result;
		}

		private static function prune_rows_without_scope_right($ary_db_rows, $for_write=false) {

			$result = array();
			
			$read_or_write = $for_write ? 'write' : 'read';
			
			foreach ($ary_db_rows as $db_row) {
				
				//echo var_dump(array_keys($db_row));
				
				if ($db_row['scope_'.$read_or_write] === Obj_scope::S_GLOBAL) {
					
					array_push($result, $db_row);
					
				} else if ($db_row['scope_'.$read_or_write] === Obj_scope::S_USER) {
					if (isset($_SESSION['UserID'])) {
						if ($db_row['scope_'.$read_or_write.'_id'] == $_SESSION['UserID']) {
							array_push($result, $db_row);
						}
					}
					
				} else if ($db_row['scope_'.$read_or_write] === Obj_scope::S_GROUP) {

					//
					// TO-DO: implement later
					//
					array_push($result, $db_row);
				}
				
			}
			
			return $result;
		}
		
		private static function prune_scope_right_fields($user_select_field_names, $ary_db_rows, $for_write=false) {
			
			$read_or_write = $for_write ? 'write' : 'read';
			
			$remove_scope_read_flag = true;
			$remove_scope_read_id_flag = true;
			
			//preserve fields that are specified as wanted by the user
			foreach (explode(',', $user_select_field_names) as $field_name) {
				
				if (strtolower(trim($field_name)) == 'scope_'.$read_or_write)
					$remove_scope_read_flag = false;
				
				elseif (strtolower(trim($field_name)) == 'scope_'.$read_or_write.'_id')
					$remove_scope_read_id_flag = false;
				
			}
			
			if (($remove_scope_read_flag === false) && ($remove_scope_read_id_flag === false))
				return $ary_db_rows;
			
			$result = array();
			
			foreach ($ary_db_rows as $db_row) {
				
				if ($remove_scope_read_flag) {
					unset($db_row['scope_'.$read_or_write]);
				}
				if ($remove_scope_read_id_flag) {
					unset($db_row['scope_'.$read_or_write.'_id']);
				}
				
				array_push($result, $db_row);
			}
			
			return $result;
		}
		
		//
		// Insert
		//
// 		function insert($obj_name, $obj_json, $ary_obj_key_fields_name, $dbh=null) {
		function insert($obj_name, $obj_json, $ary_scope=array('read'=>Obj_scope::S_USER, 'write'=>Obj_scope::S_USER), $dbh=null, $gen_id_for_obj=true) {
			
			$json_obj = json_decode($obj_json);
			
			if ($json_obj !== null) {
				
				//scope
				$ary_scope = Obj_db::check_and_fill_ary_scope($ary_scope);

				if ($gen_id_for_obj) {
				
					if (isset($json_obj->id)) {
						throw new Exception('id field is system generated. It cannot be present in the object for insert unless specified.');
					}
					
					//get id from sequence and insert the id into the json obj 
					
					$obj_id = $this->get_obj_id_from_seq($obj_name);
					
					$json_obj->id = $obj_id;
					
					$obj_json = json_encode($json_obj);
				
				} else {
					
					//make sure there is id if we are not generating id for the object
					if (!isset($json_obj->id)) {
						throw new Exception('id is not present while insert() has been specified not to generate id for the object.');
					} else {
						$obj_id = $json_obj->id;
					}
					
				}
				
				if ($dbh === null)
					$dbh = connect_db();
				
				// insert the object into database
				
				if ($this->insert_obj_row_with_db_conn(
							 $dbh
							,$obj_name
							,$obj_json
							,$obj_id
							,$ary_scope['read']
							,$ary_scope['read_id']
							,$ary_scope['write']
							,$ary_scope['write_id']
						)
				) {

					if ($this->insert_obj_fields($dbh, $obj_name, $json_obj)) {
						
						return $obj_id;
						
					} else {
						
						return false;
						
					}
						
				} else {
					
					return false;
					
				}
			}
			
			return false;
		}
				
		private function insert_obj_row_with_db_conn(
				$dbh
				,$obj_name
				,$obj_json
				,$id_value
				,$scope_read
				,$scope_read_id
				,$scope_write
				,$scope_write_id
			) {

			try {
				
				$sql = 'INSERT INTO obj (scope_read, scope_read_id, scope_write, scope_write_id, namespace, obj_name, obj_json, id'
						. ') VALUES (:scope_read, :scope_read_id, :scope_write, :scope_write_id, :namespace, :obj_name, :obj_json, :id'
						. ')';
			
				//echo $sql;
					
				$sth = $dbh->prepare($sql);
				
				$sth->bindValue(':scope_read', $scope_read);
				$sth->bindValue(':scope_read_id', $scope_read_id);
				$sth->bindValue(':scope_write', $scope_write);
				$sth->bindValue(':scope_write_id', $scope_write_id);
				
				$sth->bindValue(':namespace', $this->namespace);
				$sth->bindValue(':obj_name', $obj_name);
				$sth->bindValue(':obj_json', $obj_json);
				$sth->bindValue(':id', $id_value);
							
				$sth->execute();
					
				return true;
			
			} catch (Exception $e) {
				return false;
			}
		}
		
		private function insert_obj_fields($dbh, $obj_name, $json_obj) {
			
			if (isset($json_obj->id)) {
			
				$result_flag = true;
				
				foreach ($json_obj as $field_name => $field_value) {
	
					// ignore nested data type for now
					if ((!is_array($field_value)) 
						&& (strlen($field_name) <= Obj_db::FIELD_NAME_CHAR_MAX_LIMIT)
						&& (strlen($field_value) <= Obj_db::FIELD_VALUE_CHAR_MAX_LIMIT)
					) {
						
						$result_flag = $result_flag && $this->insert_obj_field($dbh, $obj_name, $json_obj->id, $field_name, $field_value);
						
					}
					
				}
				
				return $result_flag;
			
			} else {
				
				return false;
				
			}
			
		}
		
		private function insert_obj_field($dbh, $obj_name, $id, $field_name, $field_value) {
			try {
					
				$sql = 'INSERT INTO obj_field (namespace, obj_name, id, field_name, field_value_str, field_value_num'
						. ') VALUES (:namespace, :obj_name, :id, :field_name, :field_value_str, :field_value_num'
						. ')';
					
				//echo $sql;
					
				$sth = $dbh->prepare($sql);
					
				$sth->bindValue(':namespace', $this->namespace);
				$sth->bindValue(':obj_name', $obj_name);
				$sth->bindValue(':id', $id);
				$sth->bindValue(':field_name', $field_name);
				$sth->bindValue(':field_value_str', ( is_numeric($field_value)? null : $field_value));
				$sth->bindValue(':field_value_num', (!is_numeric($field_value)? null : $field_value));
					
				$sth->execute();
					
				return true;
					
			} catch (Exception $e) {
				
				error_log($e->getMessage());
				
				return false;
			}
		}

		private static function ensure_obj_scope($scope) {
			switch ($scope) {
				case Obj_scope::S_USER:
				case Obj_scope::S_GLOBAL:
				case Obj_scope::S_GROUP:
					return $scope;
					
				default:
					return null; 
			}
		}
		
		//
		// Update
		//
		function update($obj_name, $obj_json, $new_ary_scope=null, $args=null) {
			
			//echo var_dump($ary_obj_key_fields_name);

			//make sure ary_scope is in correct format and with proper values
			if ($new_ary_scope !== null)
				$new_ary_scope = Obj_db::check_and_fill_ary_scope($new_ary_scope);
			
			if (!is_array($args)) {
				return $this->update_by_id($obj_name, $obj_json, $new_ary_scope);
			} else {
				return $this->update_by_fields($obj_name, $obj_json, $new_ary_scope, $args);
			}
		}
		
		private function update_by_id($obj_name, $obj_json, $new_ary_scope) {
			
			//echo var_dump($ary_obj_key_fields_name);
			
			$json_obj = json_decode($obj_json);
			
			if (isset($json_obj->id)) {
			
				$id_with_scope = $this->retrieve_id_with_scope_by_id($obj_name, $json_obj->id, true);
				
				if ($id_with_scope !== null) {
				
					$id = $json_obj->id;
					
					$dbh = connect_db();
						
					try {
							
						$dbh->beginTransaction();
						
						$ary_scope = $new_ary_scope !== null ? $new_ary_scope : $id_with_scope['ary_scope'];
					
						//Please do not compare it directly because it can returns a key of 0. It will be evaluated as false.
						if ($this->update_by_id_with_db_conn($dbh, $obj_name, $id, $obj_json, $ary_scope) !== false) {

							$dbh->commit();
							
						} else {
							
							$dbh->rollBack();
							
						}
					
					} catch (Exception $e) {
						$dbh->rollBack();
					}
			
				}
				
			}
			
		}
		
		private function update_by_id_with_db_conn($dbh, $obj_name, $id, $obj_json, $ary_scope) {
			
			$this->delete_by_id_with_db_conn($dbh, $obj_name, $id);
			
			$this->delete_obj_fields_by_id_with_db_conn($dbh, $obj_name, $id);
			
			return $this->insert($obj_name, $obj_json, $ary_scope, $dbh, false);
		}
		
		private function update_by_fields($obj_name, $obj_json, $new_ary_scope, $ary_obj_field) {
			
			$rolledBack = false;
			
			$dbh = connect_db();
			
			$dbh->beginTransaction();
			
			$json_obj = json_decode($obj_json);
			
			foreach ($this->retrieve_id_with_scope_by_fields($obj_name, $ary_obj_field, true) as $data_ary) {
			
				//clone the array
				$json_obj_tmp = $json_obj;
				
				$json_obj_tmp->id = $data_ary['id'];
				
				try {

					$ary_scope = $new_ary_scope !== null ? $new_ary_scope : $id_with_scope['ary_scope'];
					
					//Please do not compare it directly because it can returns a key of 0. It will be evaluated as false.
					if ($this->update_by_id_with_db_conn($dbh, $obj_name, $data_ary['id'], json_encode($json_obj_tmp), $ary_scope) === false) {

						$rolledBack = true;
						
						if ($dbh->inTransaction())
							$dbh->rollBack();
						
					}
				
				} catch (Exception $e) {
					
					$rolledBack = true;
					
					if ($dbh->inTransaction())
						$dbh->rollBack();
				}

			}
			
			if (!$rolledBack) {
				$dbh->commit();
			}

		}
		
		//		
		// Delete
		//
		function delete($obj_name, $args) {
			if (!is_array($args))
				return $this->delete_by_id($obj_name, $args);
			else
				return $this->delete_by_fields($obj_name, $args);
		}
		
		private function delete_by_id($obj_name, $id) {

			$dbh = connect_db();
			
			try {
					
				$id_with_scope = $this->retrieve_id_with_scope_by_id($obj_name, $id, true);
				
				if ($id_with_scope !== null) {
				
					$dbh->beginTransaction();
					
					$this->delete_by_id_with_db_conn($dbh, $obj_name, $id);
					
					$this->delete_obj_fields_by_id_with_db_conn($dbh, $obj_name, $id);
					
					$dbh->commit();
					
				}
				
			} catch (Exception $e) {
				
				error_log($e->getMessage());
				
				$dbh->rollBack();
			}
			
		}
		
		private function delete_by_id_with_db_conn($dbh, $obj_name, $id, $save_in_obj_delete_table=true) {

				//this flag is set to false when it is used by update object
				if ($save_in_obj_delete_table) {
					
					$sql  = 'INSERT INTO obj_deleted ';
					$sql .= 'SELECT * FROM obj WHERE namespace=:namespace AND obj_name=:obj_name AND ';
					$sql .= 'id=:id ';
					$sql .= 'LIMIT 1';
						
					$sth = $dbh->prepare($sql);
					$sth->bindValue(':namespace', $this->namespace);
					$sth->bindValue(':obj_name', $obj_name);
					$sth->bindValue(':id', $id);
						
					$sth->execute();
					
				}
				
				$sql  = 'DELETE FROM obj WHERE namespace=:namespace AND obj_name=:obj_name AND ';
				$sql .= 'id=:id ';
				$sql .= 'LIMIT 1';
					
				$sth = $dbh->prepare($sql);
				$sth->bindValue(':namespace', $this->namespace);
				$sth->bindValue(':obj_name', $obj_name);
				$sth->bindValue(':id', $id);
				
				$sth->execute();

		}
		
		private function delete_obj_fields_by_id_with_db_conn($dbh, $obj_name, $id) {
		
			$sql  = 'DELETE FROM obj_field WHERE namespace=:namespace AND obj_name=:obj_name AND ';
			$sql .= 'id=:id ';

			$sth = $dbh->prepare($sql);
			$sth->bindValue(':namespace', $this->namespace);
			$sth->bindValue(':obj_name', $obj_name);
			$sth->bindValue(':id', $id);
		
			$sth->execute();
		
		}
		
		private function delete_by_fields($obj_name, $ary_obj_field) {
			
			$dbh = connect_db();
				
			try {
					
				$dbh->beginTransaction();

				foreach ($this->retrieve_id_with_scope_by_fields($obj_name, $ary_obj_field, true) as $id_with_scope) {
						
					$this->delete_by_id_with_db_conn($dbh, $obj_name, $id_with_scope['id']);
			
					$this->delete_obj_fields_by_id_with_db_conn($dbh, $obj_name, $id_with_scope['id']);
						
				}
				
				$dbh->commit();
			
			} catch (Exception $e) {
			
				error_log($e->getMessage());
			
				$dbh->rollBack();
			}
			
		}
		
		private static function gen_text_sequence($text, $start_number, $end_number) {
			
			$ary_text = array();
			 
			foreach (range($start_number, $end_number) as $number) {
				array_push($ary_text, $text.$number);
			}
			
			return implode(', ', $ary_text);
			
		}
		
		private function get_obj_id_from_seq($obj_name) {
			
			$dbh = connect_db();
				
			$sql  = 'select fn_get_seq_value(:seq_name) as `seq_number`;';
				
			//echo $sql;
				
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':seq_name', $this->namespace . '\\' . $obj_name);
				
			$sth->execute();
			
			if ($row = $sth->fetch()) {
				return (int)$row['seq_number'];
			} else {
				throw new Exception('Cannot get sequence value!');
			}
		} 
	}
?>