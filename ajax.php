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
		$results['error'][] = Context::getContext()->getTranslator()->trans("Name Is Required", array(), 'Modules.xipblog.Admin');	
	}
	if(isset($_POST['email']) && !empty($_POST['email']) && Validate::isEmail($_POST['email'])){
		$commentobj->email = $_POST['email'];
	}else{
		$results['error'][] = Context::getContext()->getTranslator()->trans("Valid Email Address Is Required", array(), 'Modules.xipblog.Admin');	
	}
    $commentobj->website = (isset($_POST['website']) && !empty($_POST['website'])) ? $_POST['website'] : '#';
    if(isset($_POST['subject']) && !empty($_POST['subject'])){
		$commentobj->subject = $_POST['subject'];
	}else{
		$results['error'][] = Context::getContext()->getTranslator()->trans("Subject Is Required", array(), 'Modules.xipblog.Admin');
	}
	if(isset($_POST['content']) && !empty($_POST['content'])){
		$commentobj->content = $_POST['content'];
	}else{
		$results['error'][] = Context::getContext()->getTranslator()->trans("Comment Content Is Required", array(), 'Modules.xipblog.Admin');
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
		$comment_approved = Configuration::get(xipblog::$xipblogshortname."comment_approved");
		if($comment_approved == 1){
			$commentobj->active	=	1; 
		}else{
			$commentobj->active	=	1; 
		}
		$commentobj->created	=	date("Y-m-d h:i:s"); 
		$commentobj->updated	=	date("Y-m-d h:i:s"); 
		if($commentobj->add()){
			$url = xipblog::XipBlogPostLink(array('id' => $commentobj->id_post));
			$name = $commentobj->name;
			$email = $commentobj->email;
			$comment = $commentobj->content;
			$comment_approved = Configuration::get(xipblog::$xipblogshortname."comment_approved");
		    $name = Tools::stripslashes($name);
		    if($comment_approved == 1){
		    	$body = 'You have Received a New Comment In Your Blog Post From ' . $name . '. Comment: ' . $comment . ' .Your Can Reply Here : ' . $url . '';
		    }else{
		    	$body = 'You have Received a New Comment In Your Blog Post From ' . $name . '. Comment: ' . $comment . ' . This comment is waiting for approved. Please review this comment.';
		    }
		    $email = Tools::stripslashes($email);
		    $comment = Tools::stripslashes($comment);
		    if($comment_approved == 1){
		    	$subject = 'New Blog Comment Posted';
		    }else{
		    	$subject = 'Pending Review : New Blog Comment';
		    }
		    $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
		    $to = Configuration::get('PS_SHOP_EMAIL');
		    $contactMessage = "
		    				$comment 
		    				Name: $name
		    				IP: " . ((version_compare(_PS_VERSION_, '1.3.0.0', '<')) ? $_SERVER['REMOTE_ADDR'] : Tools::getRemoteAddr());
			Mail::Send($id_lang, 'contact', $subject, array('{message}' => nl2br($body),'{email}' => $email,),$to,null,$email,$name);
			$results['success'][] = Context::getContext()->getTranslator()->trans("Successfully Comment Added", array(), 'Modules.xipblog.Admin');
			$results['results'] = $commentobj;
			die(Tools::jsonEncode($results));
		}else{
			$results['error'][] = Context::getContext()->getTranslator()->trans("Something Wrong Please Try Again ! ", array(), 'Modules.xipblog.Admin');
			die(Tools::jsonEncode($results));	
		}
	}
}