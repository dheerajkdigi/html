<?php

function debug($var){
    echo "<pre>";print_r($var);echo "</pre>";
}

function dbResultToArrayById($object,$id='ID'){
	
	$res = array();
	foreach($object as $obj){
		$res[$obj->$id] = $obj;
	}
	return $res;
	//debug($res);die;
}

function dbResultToArrayByGroup($object,$id='ID'){
	
	$res = array();
	foreach($object as $obj){
		$res[$obj->$id][] = $obj;
	}
	return $res;
	//debug($res);die;
}
function isAuthorized(){
    $CI = & get_instance();
    $controller = $CI->router->fetch_class();
    $action = $CI->router->fetch_method();
    $u = $CI->session->userdata['user'];
    if(isset($u->authFor[$controller]) && in_array($action, $u->authFor[$controller]) ){
        return true;
    }
    else
        show_404();
}

function dd($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	exit;
}
?>
