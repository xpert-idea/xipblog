<?php
class xipblogSingleModuleFrontController extends xipblogMainModuleFrontController
{
	public $blogpost;
	public $xiperrors;
	public $id_identity;
	public $rewrite;
    public function init()
	{
        parent::init();
        $this->rewrite = Tools::getValue('rewrite');
        $id_identity = Tools::getValue('id');
        if(!isset($id_identity) || empty($id_identity)){
        	$this->id_identity = (int)xippostsclass::get_the_id($this->rewrite,$this->page_type);
        }else{
        	$this->id_identity = (int)$id_identity;
        }
        if(!xippostsclass::PostExists($this->id_identity,$this->page_type)){
        	$url = xipblog::XipBlogLink();
			Tools::redirect($url);
        	$this->errors[] = Tools::displayError($this->l('Blog Post Not Found.'));
        }
        if (!$this->id_identity || !Validate::isUnsignedId($this->id_identity)){
        	Tools::redirect('index.php?controller=404');
        	$this->errors[] = Tools::displayError($this->l('Blog Post Not Found.'));
        }else{
        	$this->blogpost = xippostsclass::GetSinglePost($this->id_identity);
        	xippostsclass::PostCountUpdate($this->id_identity);
        }
    }
    public function setMedia()
    {
        parent::setMedia();
        $themename = xipblog::GetThemeName();
        $theme_name = (isset($themename) && !empty($themename)) ? '/'.$themename : '';
        $this->addCSS(xipblog_css_uri.$theme_name.'css/xipblog_single.css');
        $this->addJS(xipblog_js_uri.$theme_name.'js/xipblog_single.js');
    }
    public function initContent()
	{
        parent::initContent();
        if(isset($this->blogpost) && !empty($this->blogpost)){
        		$this->context->smarty->assign('xipblogpost',$this->blogpost);
        		if(isset($this->blogpost['meta_title']) && !empty($this->blogpost['meta_title'])){
	        		$this->context->smarty->assign('meta_title',$this->blogpost['meta_title']);
        		}else{
	        		$this->context->smarty->assign('meta_title',$this->blogpost['post_title']);
        		}
        		if(isset($this->blogpost['meta_description']) && !empty($this->blogpost['meta_description'])){
	        		$this->context->smarty->assign('meta_description',$this->blogpost['meta_description']);
        		}else{
	        		$this->context->smarty->assign('meta_description',$this->blogpost['post_excerpt']);
        		}
        		$this->context->smarty->assign('meta_keywords',$this->blogpost['meta_keyword']);
        }
        if(isset($this->id_identity) && !empty($this->id_identity)){
        	$xipblog_commets = xipcommentclass::getComments($this->id_identity);
        	$this->context->smarty->assign('xipblog_commets',$xipblog_commets);
    	}
        if(isset($this->xiperrors) && !empty($this->xiperrors)){
        	$this->context->smarty->assign('xiperrors',$this->xiperrors);
        }
        $path = xippostsclass::getsinglepath($this->id_identity,$this->page_type);
        $this->context->smarty->assign('path',$path);

		$disable_blog_com = (int)Configuration::get(xipblog::$xipblogshortname."disable_blog_com");

        $this->context->smarty->assign('disable_blog_com',$disable_blog_com);

        $this->context->smarty->assign('xipblog_dir',_PS_MODULE_DIR_.xipblog::$ModuleName);
        $this->context->smarty->assign('xipblog_uri',__PS_BASE_URI__.xipblog::$ModuleName);
        $this->context->smarty->assign('xipblog_img_uri',__PS_BASE_URI__.xipblog::$ModuleName.'/img/');
        $this->context->smarty->assign('xipblog_css_uri',__PS_BASE_URI__.xipblog::$ModuleName.'/css/');
        $this->context->smarty->assign('xipblog_js_uri',__PS_BASE_URI__.xipblog::$ModuleName.'/js/');
        $template = "single.tpl";
        if(!empty($this->page_type)){
        	$post_format = (isset($this->blogpost['post_format']) && !empty($this->blogpost['post_format'])) ? "-".$this->blogpost['post_format'] : ""; 
        	$page_type = (isset($this->page_type) && !empty($this->page_type)) ? $this->page_type."-" : ""; 
        	$template1 = $page_type.'single'.$post_format.'.tpl';
        	$template2 = $page_type.'single.tpl';
        	$template3 = 'single'.$post_format.'.tpl';
        	if($this->getTemplatePath($template1)){
        		$template = $template1;
        	}elseif($this->getTemplatePath($template2)){
        		$template = $template2;
        	}elseif($this->getTemplatePath($template3)){
        		$template = $template3;
        	}else{
        		$template = "single.tpl";
        	}
        }
        $this->setTemplate($template);
    }
}