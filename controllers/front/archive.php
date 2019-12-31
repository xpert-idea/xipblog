<?php
use PrestaShop\PrestaShop\Core\Product\Search\Pagination;
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
       	$p = Tools::getValue('page');
		$this->p = isset($p) && !empty($p) ? (int)($p) : 1;
		$id_identity = Tools::getValue('id');
		if(!isset($id_identity) || empty($id_identity)){
			$this->id_identity = (int)xipcategoryclass::get_the_id($this->rewrite,$this->page_type);
		}else{
			$this->id_identity = (int)$id_identity;
		}
		if(isset($this->id_identity) && !empty($this->id_identity) && !xipcategoryclass::CategoryExists($this->id_identity,$this->page_type)){
			$url = xipblog::XipBlogLink();
			Tools::redirect($url);
			$this->xiperrors[] = Tools::displayError($this->l('Blog Category Not Found.' ));
		}
        if($this->page_type == 'tag'){
        	$this->blogpost = xippostsclass::GetTagPosts((int)$this->id_identity,(int)$this->p,(int)$this->n,$subpage_type);
        }else{
        	$this->blogpost = xippostsclass::GetCategoryPosts((int)$this->id_identity,(int)$this->p,(int)$this->n,$subpage_type);
        }
        if($this->id_identity || Validate::isUnsignedId($this->id_identity)){
        	$this->blogcategory = new xipcategoryclass($this->id_identity);
        }
		$this->nbProducts = (int)xippostsclass::GetCategoryPostsCount((int)$this->id_identity,$subpage_type);
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
        // print_r($this->getLayout());
        $id_lang = (int)Context::getContext()->language->id;
		$pagination = $this->getXprtPagination();
		$path = xipcategoryclass::getcategorypath($this->id_identity,$this->page_type);
		$this->context->smarty->assign('path',$path);
		$this->context->smarty->assign('pagination',$pagination);
        if(isset($this->blogpost) && !empty($this->blogpost)){
        	$this->context->smarty->assign('xipblogpost',$this->blogpost);
        }
		if(isset($this->blogcategory->title[$id_lang]) && !empty($this->blogcategory->title[$id_lang])){
			$this->context->smarty->assign('meta_title',$this->blogcategory->title[$id_lang]);
			$this->context->smarty->tpl_vars['page']->value['meta']['title'] = $this->blogcategory->title[$id_lang];
		}else{
			$this->context->smarty->assign('meta_title',Configuration::get(xipblog::$xipblogshortname."meta_title",$id_lang));
			$this->context->smarty->tpl_vars['page']->value['meta']['title'] = Configuration::get(xipblog::$xipblogshortname."meta_title",$id_lang);
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
    public function getLayout()
    {
        $entity = 'module-xipblog-archive';
        $layout = $this->context->shop->theme->getLayoutRelativePathForPage($entity);
        if ($overridden_layout = Hook::exec(
            'overrideLayoutTemplate',
            array(
                'default_layout' => $layout,
                'entity' => $entity,
                'locale' => $this->context->language->locale,
                'controller' => $this,
            )
        )) {
            return $overridden_layout;
        }
        if ((int) Tools::getValue('content_only')) {
            $layout = 'layouts/layout-content-only.tpl';
        }
        return $layout;
    }
    public function updateXprtQueryString(array $extraParams = null)
    {
        $uriWithoutParams = explode('?', $_SERVER['REQUEST_URI'])[0];
        $url = Tools::getCurrentUrlProtocolPrefix().$_SERVER['HTTP_HOST'].$uriWithoutParams;
        $params = array();
        parse_str($_SERVER['QUERY_STRING'], $params);

        if (null !== $extraParams) {
            foreach ($extraParams as $key => $value) {
                if (null === $value) {
                    unset($params[$key]);
                } else {
                    $params[$key] = $value;
                }
            }
        }

        ksort($params);

        if (null !== $extraParams) {
            foreach ($params as $key => $param) {
                if (null === $param || '' === $param) {
                    unset($params[$key]);
                }
            }
        } else {
            $params = array();
        }

        $queryString = str_replace('%2F', '/', http_build_query($params));

        return $url.($queryString ? "?$queryString" : '');
    }
    public function getXprtPagination() {

        $pagination = new Pagination();
        $pagination
            ->setPage($this->p)
            ->setPagesCount(
                (int)ceil($this->nbProducts / $this->n)
            )
        ;
        $totalItems = $this->nbProducts;
        $itemsShownFrom = ($this->n * ($this->p - 1)) + 1;
        $itemsShownTo = $this->n * $this->p;
        return array(
            'total_items' => $totalItems,
            'items_shown_from' => $itemsShownFrom,
            'items_shown_to' => ($itemsShownTo <= $totalItems) ? $itemsShownTo : $totalItems,
            'pages' => array_map(function ($link) {
                $link['url'] = $this->updateXprtQueryString(array(
                    'page' => $link['page'],
                ));
                return $link;
            }, $pagination->buildLinks()),
        );
    }
    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $id_lang = (int)$this->context->language->id;

        $blog_title = Configuration::get(xipblog::$xipblogshortname."meta_title",$id_lang);
        $breadcrumb['links'][] = array(
            'title' => $blog_title,
            'url' => xipblog::XipBlogLink(),
        );
        

        if(isset($this->blogcategory->title[$id_lang]) && !empty($this->blogcategory->title[$id_lang])){
        	$category_name = $this->blogcategory->title[$id_lang];
        }elseif(isset($this->blogcategory->name[$id_lang]) && !empty($this->blogcategory->name[$id_lang])){
        	$category_name = $this->blogcategory->name[$id_lang];
        }else{
        	$category_name = '';
        }
        
        if ($category_name != '') {
            $params = array();
            $params['id'] = $this->blogcategory->id_xipcategory ? $this->blogcategory->id_xipcategory : 0;
            $params['rewrite'] = (isset($this->blogcategory->link_rewrite[$id_lang]) && !empty($this->blogcategory->link_rewrite[$id_lang])) ? $this->blogcategory->link_rewrite[$id_lang] : 'category_blog_post';
            $params['page_type'] = 'category';
            $params['subpage_type'] = 'post';
            $category_url = xipblog::XipBlogCategoryLink($params);
            $breadcrumb['links'][] = array(
                'title' => $category_name,
                'url' => $category_url,
            );
        }

        return $breadcrumb;
    }
}
