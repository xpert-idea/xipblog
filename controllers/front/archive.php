<?php
class xipblogArchiveModuleFrontController extends xipblogMainModuleFrontController
{
	public $blogpost;
	public $blogcategory;
	public $xiperrors;
	public $id_identity;
	public $rewrite;
    public function init()
	{
        parent::init();
       	$this->rewrite = Tools::getValue('rewrite');
       	$subpage_type = Tools::getValue('subpage_type');
       	$p = Tools::getValue('p');
		$this->p = isset($p) ? $p : 1;
		$id_identity = Tools::getValue('id');
		if(!isset($id_identity) || empty($id_identity)){
			$this->id_identity = (int)xipcategoryclass::get_the_id($this->rewrite,$this->page_type);
		}else{
			$this->id_identity = (int)$id_identity;
		}
		if(isset($this->id_identity) && !empty($this->id_identity) && !xipcategoryclass::CategoryExists($this->id_identity,$this->page_type)){
			$url = xipblog::XipBlogLink();
			Tools::redirect($url);
			$this->xiperrors[] = Tools::displayError($this->l('Blog Category Not Found.'));
		}
        if($this->page_type == 'tag'){
        	$this->blogpost = xippostsclass::GetTagPosts((int)$this->id_identity,(int)$this->p,(int)$this->n,$subpage_type);
        }else{
        	$this->blogpost = xippostsclass::GetCategoryPosts((int)$this->id_identity,(int)$this->p,(int)$this->n,$subpage_type);
        }
        if($this->id_identity || Validate::isUnsignedId($this->id_identity)){
        	$this->blogcategory = new xipcategoryclass($this->id_identity);
        }
		$this->nbProducts = xippostsclass::GetCategoryPostsCount((int)$this->id_identity,$subpage_type);
    }
    public function setMedia()
    {
        parent::setMedia();
        $themename = xipblog::GetThemeName();
        $theme_name = (isset($themename) && !empty($themename)) ? '/'.$themename : '';
        $this->addCSS(xipblog_css_uri.$theme_name.'css/xipblog_archive.css');
        $this->addJS(xipblog_js_uri.$theme_name.'js/xipblog_archive.js');
    }
    public function initContent()
	{
        parent::initContent();
        $id_lang = (int)Context::getContext()->language->id;
		$this->pagination((int)$this->nbProducts);
		$path = xipcategoryclass::getcategorypath($this->id_identity,$this->page_type);
		$this->context->smarty->assign('path',$path);
        if(isset($this->blogpost) && !empty($this->blogpost)){
        	$this->context->smarty->assign('xipblogpost',$this->blogpost);
        }
		if(isset($this->blogcategory->title[$id_lang]) && !empty($this->blogcategory->title[$id_lang])){
			$this->context->smarty->assign('meta_title',$this->blogcategory->title[$id_lang]);
		}else{
			$this->context->smarty->assign('meta_title',Configuration::get(xipblog::$xipblogshortname."meta_title"));
		}
		if(isset($this->blogcategory->meta_description[$id_lang]) && !empty($this->blogcategory->meta_description[$id_lang])){
			$this->context->smarty->assign('meta_description',$this->blogcategory->meta_description[$id_lang]);
		}else{
			$this->context->smarty->assign('meta_description',Configuration::get(xipblog::$xipblogshortname."meta_description"));
		}
		if(isset($this->blogcategory->keyword[$id_lang]) && !empty($this->blogcategory->keyword[$id_lang])){
			$this->context->smarty->assign('meta_keywords',$this->blogcategory->keyword[$id_lang]);
		}else{
			$this->context->smarty->assign('meta_keywords',Configuration::get(xipblog::$xipblogshortname."meta_keyword"));
		}
     	if(isset($this->xiperrors) && !empty($this->xiperrors)){
        	$this->context->smarty->assign('xiperrors',$this->xiperrors);
        }
        $tpl_prefix = '';
        $template = 'archive.tpl';
        if(!empty($this->page_type)){
        	$template1 = $this->page_type.'-'.'archive.tpl';
        	if ($path = $this->getTemplatePath($template1)) {
        		$template = $template1;
        	}else{
        		$template = 'archive.tpl';
        	}
        }
        $this->setTemplate($template);
    }
}