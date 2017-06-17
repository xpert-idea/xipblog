<?php

session_start();
require_once(dirname(__FILE__).'../../../config/config.inc.php');
require_once(dirname(__FILE__).'../../../init.php');
require_once (_PS_MODULE_DIR_.'xipblog/xipblog.php');
if(isset($_POST) && !empty($_POST)){
	$commentobj = new xipcommentclass();
	$results = array();
	if(isset($_POST['name']) && !empty($_POST['name'])){
		$commentobj->name = $_POST['name'];
	}else{
		$results['error'][] = "Name Is Required";	
	}
	if(isset($_POST['email']) && !empty($_POST['email']) && Validate::isEmail($_POST['email'])){
		$commentobj->email = $_POST['email'];
	}else{
		$results['error'][] = "Valid Email Address Is Required";	
	}
    $commentobj->website = (isset($_POST['website']) && !empty($_POST['website'])) ? $_POST['website'] : '#';
    if(isset($_POST['subject']) && !empty($_POST['subject'])){
		$commentobj->subject = $_POST['subject'];
	}else{
		$results['error'][] = "Subject Is Required";
	}
	if(isset($_POST['content']) && !empty($_POST['content'])){
		$commentobj->content = $_POST['content'];
	}else{
		$results['error'][] = "Comment Content Is Required";
	}
    $commentobj->id_parent = (isset($_POST['id_parent']) && !empty($_POST['id_parent'])) ? (int)$_POST['id_parent'] : 0;
   	$commentobj->id_post = (isset($_POST['id_post']) && !empty($_POST['id_post'])) ? (int)$_POST['id_post'] : 0;
	if(isset($results['error']) && !empty($results['error'])){
		die(Tools::jsonEncode($results));
	}else{
		$commentobj->id_customer	=	0; 
		$commentobj->id_guest	=	0; 
		$commentobj->position	=	0; 
		$commentobj->uniqueid	=	'abc'; 
		$commentobj->active	=	1; 
		$commentobj->created	=	date("Y-m-d h:i:s"); 
		$commentobj->updated	=	date("Y-m-d h:i:s"); 
		if($commentobj->add()){
			$results['success'][] = "Successfully Comment Added";
			$results['results'] = $commentobj;
			die(Tools::jsonEncode($results));
		}else{
			$results['error'][] = "Something Wrong Please Try Again ! ";
			die(Tools::jsonEncode($results));	
		}
	}
}