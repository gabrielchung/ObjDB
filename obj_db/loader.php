<?php 
	include dirname(__FILE__) . '/../core/database.php';
	include dirname(__FILE__) . '/class/Obj_sql_comparer.php';
	include dirname(__FILE__) . '/class/Obj_scope.php';
	include dirname(__FILE__) . '/class/Obj_field.php';
	include dirname(__FILE__) . '/class/Obj_db.php';
	
// 	session_destroy();
	session_start();
	$_SESSION['UserID'] = 1;
	
	$odb = new Obj_db('test_ns');
	
	// get id
	//echo $odb->get_obj_id('foo');
	
	// prepare data
	
// 	$obj = json_decode('{"owner_id":[3,4,6,7],"title":"Hello World","content":"Hello! This is the content of this piece of information","modified_timestamp":1407244019,"creation_timestamp":1407244019,"taxonomy_id":[3,4,5,11,15]}');
// 	$obj->id = 11;
	
// 	var_dump(json_encode($obj));
	
	//
	// insert
	//
// 	$odb->insert('info'
// 			,'{"owner_id":[3,4,6,7],"title":"Hello World","content":"Hello! This is the content of this piece of information","modified_timestamp":1407244019,"creation_timestamp":1407244019,"taxonomy_id":[3,4,5,11,15]}'
// 			,array('read'=>'GLOBAL', 'write'=>'GLOBAL')
// 	);
	
// 	$odb->insert('info'
// 				 ,'{"owner_id":[3,4,6,7],"title":"Hello World","content":"Hello! This is the content of this piece of information","modified_timestamp":1407244019,"creation_timestamp":1407244019,"taxonomy_id":[3,4,5,11,15]}'
// 				);
	
	
	//
	// retrieve
	//
	
	//echo var_dump(Obj_db::$ARY_OBJ_TABLE_FIELD_NAMES);
	//echo $odb->retrieve('info', 3);
	
// 	$data_obj = $odb->retrieve('info', 16);
	//$data_obj = $odb->retrieve('info', 3, 'id, obj_json');
	//echo var_dump(array_keys($data_obj));
// 	echo var_dump($data_obj);
	
// 	echo '<br /><br />';
// 	echo var_dump($data_obj['id']);
// 	echo '<br /><br />';
// 	echo var_dump($data_obj[0]);
	//echo var_dump($odb->retrieve_all('info'));
	
// 	echo var_dump($odb->retrieve('info',
// 									array(
// 										new Obj_field('id', 17, '<=')
// 									),
// 									"id, obj_json"
// 				));

// 	echo var_dump($odb->retrieve('info'
// 								  ,array(
// 									new Obj_field('id', 17, '<=')
// 								   )
// 								  ,'id,scope_read,scope_read_id,scope_write,scope_write_id', true));
	
	//
	// delete
	//
	
//  	$odb->delete('info', 16);
//  	$odb->delete('info'
// 				 ,array(
// 					new Obj_field('id', 20, '<=')
// 				  )
// 				);

	//
	// update
	//
	
	//nice trick
	//$odb->update('info', $odb->retrieve('info', 1));
	
// 	$odb->update('info'
// 				,'{"id":24, "owner_id":[3,4,6,7],"title":"Hello World1","content":"Hello1! This is the content of this piece of information","modified_timestamp":1407244040,"creation_timestamp":1407244019,"taxonomy_id":[3,4,5,11,15]}'
// 				,array('read'=>'USER', 'write'=>'USER')
// 				);
	
	$odb->update('info'
				 ,'{"owner_id":[3,4,6,7],"title":"Hello World2","content":"Hello2! This is the content of this piece of information","modified_timestamp":1407244040,"creation_timestamp":1407244019,"taxonomy_id":[3,4,5,11,15]}'
				 ,array('read'=>'GLOBAL', 'write'=>'USER')
				 ,array(
				 	new Obj_field('id', 17, '>')
				 )
				);

	//update by fields
// 	$odb->update('info' 
// 				 ,$odb->retrieve('info', 3)['obj_json']
// 				 ,array(
// 				 	new Obj_field('id', 9, '>')
// 				  )
// 				);
	
?>