<?php

class xippostsclass extends ObjectModel
{
	public $id;
	public $id_xipposts;
	public $post_author;
	public $post_date;
	public $post_modified;
	public $comment_status;
	public $post_password;
	public $post_parent;
	public $post_type;
	public $post_format;
	public $category_default;
	public $comment_count;
	public $post_title;
	public $post_excerpt;
	public $post_content;
	public $post_img;
	public $link_rewrite;
	public $position;
	public $active;
	public $video;
	public $audio;
	public $gallery;
	public $meta_title;
	public $meta_description;
	public $meta_keyword;
	public $related_products;
	public static $definition = array(
		'table' => 'xipposts',
		'primary' => 'id_xipposts',
		'multilang' => true,
		'fields' => array(
			'post_title' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'meta_title' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'post_excerpt' =>       array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'meta_description' =>   array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'meta_keyword' =>       array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'post_content' =>		array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml','lang' => true),
			'link_rewrite' =>       array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'related_products' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'video' =>				array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
			'audio' =>				array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
			'gallery' =>			array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
			'post_password' =>		array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'post_type' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'post_format' =>		array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'category_default' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'post_date' =>			array('type' => self::TYPE_DATE, 'validate' => 'isString'),
			'post_modified' =>		array('type' => self::TYPE_DATE, 'validate' => 'isString'),
			'post_img' =>			array('type' => self::TYPE_DATE, 'validate' => 'isString'),
			'post_author' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'post_parent' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'comment_status' =>		array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'comment_count' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'position' =>			array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'active' =>				array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
		),
	);
	public function __construct($id = null, $id_lang = null, $id_shop = null)
	{
        Shop::addTableAssociation('xipposts', array('type' => 'shop'));
                parent::__construct($id, $id_lang, $id_shop);
    }
    public function update($null_values = false)
    {
    	if (isset($_FILES['post_img']) && isset($_FILES['post_img']['tmp_name']) && !empty($_FILES['post_img']['tmp_name'])) {
    		$this->post_img = xipblog::UploadMedia('post_img');
    	}
    	if(isset($_POST['audio_temp']) && !empty($_POST['audio_temp']) && is_array($_POST['audio_temp'])){
    		$this->audio = @implode(",", $_POST['audio_temp']);
    	}
    	if(isset($_POST['video_temp']) && !empty($_POST['video_temp']) && is_array($_POST['video_temp'])){
    		$this->video = @implode(",", $_POST['video_temp']);
    	}
    	$this->GalleryUploadsUpdated();
    	$tags = Tools::getValue("meta_tag");
    	$tags_ids = self::GetCategoryTypeIds($tags);
    	self::TagPostInsert($this->id,$tags_ids);
    	$this->post_modified = date("Y-m-d H:i:s");
        if(!parent::update($null_values))
            return false;
        return true;
    }
    public function add($autodate = true, $null_values = false)
    {
    	$gallery_temp = xipblog::BulkUploadMedia("gallery_temp");
    	if(isset($gallery_temp) && !empty($gallery_temp) && is_array($gallery_temp)){
    		$this->gallery = @implode(",",$gallery_temp);
    	}
    	if(isset($_POST['audio_temp']) && !empty($_POST['audio_temp']) && is_array($_POST['audio_temp'])){
    		$this->audio = @implode(",", $_POST['audio_temp']);
    	}
    	if(isset($_POST['video_temp']) && !empty($_POST['video_temp']) && is_array($_POST['video_temp'])){
    		$this->video = @implode(",", $_POST['video_temp']);
    	}
    	$this->post_author = (int)Context::getContext()->employee->id;
    	$this->post_date = date("Y-m-d H:i:s");
    	$this->post_modified = date("Y-m-d H:i:s");
        if($this->position <= 0)
            $this->position = self::getTopPosition() + 1;
        if(isset($this->post_img) && !empty($this->post_img)){
			$this->post_img = $this->post_img;
        }else{
        	$this->post_img = xipblog::UploadMedia('post_img');
        }
        $tags = Tools::getValue("meta_tag");
        $tags_ids = self::GetCategoryTypeIds($tags);
        if(!parent::add($autodate, $null_values) || !Validate::isLoadedObject($this)){
            return false;
        }else{
        	self::TagPostInsert($this->id,$tags_ids);
        	return true;
        }
    }
    public function GalleryUploadsUpdated(){
    	$main_update_gallery = '';
    	$gallery_temp = xipblog::BulkUploadMedia("gallery_temp");
    	if(isset($_POST["gallery_temp_delete"]) && !empty($_POST["gallery_temp_delete"])){
    		$gallery_temp_delete = @explode(",",$_POST["gallery_temp_delete"]);
    	}
    	if(isset($this->gallery) && !empty($this->gallery)){
    		$thisgallery = @explode(",",$this->gallery);
    	}else{
    		$thisgallery = array();
    	}
    	$org = array();
    	if(isset($thisgallery) && !empty($thisgallery) && isset($gallery_temp_delete) && !empty($gallery_temp_delete)){

    		foreach ($thisgallery as $galkey => $galvalue) {
    			if(!in_array($galvalue,$gallery_temp_delete)){
    				$org[] = $galvalue;
    			}
    		}
    		if(isset($org) && !empty($org) && isset($gallery_temp) && !empty($gallery_temp)){
    			$main_update_gallery = @array_merge($gallery_temp,$org);
    		}else{
    			if(isset($org) && !empty($org)){
    				$main_update_gallery = $org;
    			}
    			if(isset($gallery_temp) && !empty($gallery_temp)){
    				$main_update_gallery = $gallery_temp;
    			}
    		}
    	}else{
    		if(isset($thisgallery) && !empty($thisgallery) && isset($gallery_temp) && !empty($gallery_temp)){
    			$main_update_gallery = @array_merge($gallery_temp,$thisgallery);
    		}elseif (isset($thisgallery) && !empty($thisgallery)) {
    			$main_update_gallery = $thisgallery;
    		}elseif (isset($gallery_temp) && !empty($gallery_temp)) {
    			$main_update_gallery = $gallery_temp;
    		}
    	}
    	if(isset($main_update_gallery) && !empty($main_update_gallery) && is_array($main_update_gallery)){
    		$this->gallery = @implode(",",$main_update_gallery);
    	}
    }
    public static function getsinglepath($id_post = NULL,$post_type = 'post'){
    	if($id_post == NULL)
    		return false;
    	$pipe = (Configuration::get('PS_NAVIGATION_PIPE') ? Configuration::get('PS_NAVIGATION_PIPE') : '>');
    	$posts = self::get_the_title($id_post,$post_type);
    	$category_default = $posts['category_default'] ? $posts['category_default'] : NULL;
    	$categories = self::get_the_category($category_default);
    	$title = $categories['name'] ? $categories['name'] : "";
    	$name = $posts['post_title'];
    	$params['id'] = $categories['id_xipcategory'] ? $categories['id_xipcategory'] : 0;
    	$params['rewrite'] = $categories['link_rewrite'] ? $categories['link_rewrite'] : '';
    	$params['page_type'] = 'category';
    	$params['subpage_type'] = $post_type ?  $post_type : 'post';
    	$link = xipblog::XipBlogCategoryLink($params);
    	$meta_title = Configuration::get(xipblog::$xipblogshortname."meta_title");
    	$meta_title = (isset($meta_title) ? $meta_title : "Blog");
    	$blog_url = xipblog::XipBlogLink();
    	$full_paths = '<a href="'.$blog_url.'" title="'.$meta_title.'" data-gg="">'.$meta_title.'</a><span class="navigation-pipe">'.$pipe.'</span>';

    	$str = '<a href="'.$link.'" title="'.$title.'" data-gg="">'.$title.'</a><span class="navigation-pipe">'.$pipe.'</span>'.$name;
    	return $full_paths.$str;
    }
    public static function getTopPosition()
    {
        $sql = 'SELECT MAX(`position`)
                FROM `'._DB_PREFIX_.'xipposts`';
        $position = DB::getInstance()->getValue($sql);
        return (is_numeric($position)) ? $position : -1;
    }
    public function updatePosition($way, $position)
    {
        if(!$res = Db::getInstance()->executeS('
            SELECT `id_xipposts`, `position`
            FROM `'._DB_PREFIX_.'xipposts`
            ORDER BY `position` ASC'
        ))
            return false;
        if(!empty($res))
        foreach($res as $xipposts)
            if((int)$xipposts['id_xipposts'] == (int)$this->id)
        $moved_xipposts = $xipposts;
        if(!isset($moved_xipposts) || !isset($position))
            return false;
        $queryx = ' UPDATE `'._DB_PREFIX_.'xipposts`
        SET `position`= `position` '.($way ? '- 1' : '+ 1').'
        WHERE `position`
        '.($way
        ? '> '.(int)$moved_xipposts['position'].' AND `position` <= '.(int)$position
        : '< '.(int)$moved_xipposts['position'].' AND `position` >= '.(int)$position.'
        ');
        $queryy = ' UPDATE `'._DB_PREFIX_.'xipposts`
        SET `position` = '.(int)$position.'
        WHERE `id_xipposts` = '.(int)$moved_xipposts['id_xipposts'];
        return (Db::getInstance()->execute($queryx)
        && Db::getInstance()->execute($queryy));
    }
    public static function GetCategoryTypeIds($values = NULL){
    	if($values == NULL)
    		return false;
    	$results = array();
    	if(isset($values) && !empty($values)){
    		$values = explode(",",$values);
    		if(is_array($values)){
    			foreach ($values as $val) {
    				$results[] = self::TagInsert($val);
    			}
    			return $results;	
    		}
    	}else{
    		return false;
    	}
    }
    public static function TagPostInsert($id_post = NULL,$category_ids = NULL,$tag = 'tag'){
    	if($id_post == NULL || $category_ids == NULL){
    		return false;
    	}else{
    		$queryval = '';
    		self::DeleteTagPost($id_post);
    		if(isset($category_ids) && !empty($category_ids)){
    			foreach ($category_ids as $id_category){
    				$queryval .= '('.(int)$id_post.','.(int)$id_category.',"'.$tag.'"),';
    			}
    			$queryval = rtrim($queryval, ',');
    			if(Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'xip_category_post`(`id_post`, `id_category`,`type`) VALUES '.$queryval)){
    				return true;
    			}else{
    				return false;
    			}
    		}
    	}
    }
    public static function DeleteTagPost($id_post = NULL,$tag = 'tag'){
    	if($id_post == NULL){
    		return false;
    	}
		if(Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'xip_category_post WHERE id_post = '.$id_post.' AND type = "'.$tag.'"')){
			return true;
		}else{
			return false;
		}
    }
    public static function get_the_title($id_post = NULL,$post_type = 'post')
    {
		if($id_post == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT xc.`id_xipposts`,xc.`category_default`,xcl.`post_title`,xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		';
       $sql .= ' WHERE xc.`post_type` = "'.($post_type?$post_type:'post').'" AND xc.`id_xipposts` = '.$id_post;
       $rslts = Db::getInstance()->getrow($sql);
       		return $rslts;
    }
    public static function get_the_id($rewrite = NULL,$post_type = 'post')
    {
		if($rewrite == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT xc.`id_xipposts` FROM `'._DB_PREFIX_.'xipposts` xc INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.') INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.') ';
		$sql .= ' WHERE xc.`post_type` = "'.($post_type ? $post_type : 'post').'" AND xcl.`link_rewrite` = "'.$rewrite.'" ';
		$rslts = Db::getInstance()->getrow($sql);
			return isset($rslts['id_xipposts']) ? $rslts['id_xipposts'] : NULL;
    }
    public static function PostExists($id_post = NULL,$post_type = 'post')
    {
		if($id_post == NULL || $id_post == 0)
			return false;
		$sql = 'SELECT xc.`id_xipposts` FROM `'._DB_PREFIX_.'xipposts` xc WHERE xc.`post_type` = "'.($post_type ? $post_type : 'post').'" AND xc.active = 1 AND xc.`id_xipposts` = '.$id_post;
		$rslts = Db::getInstance()->getrow($sql);
			return (isset($rslts['id_xipposts']) && !empty(isset($rslts['id_xipposts']))) ? true : false;
    }
    public static function get_the_rewrite($id = NULL,$post_type = 'post')
    {
		if($id == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xipposts` xc INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.') INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.') ';
		$sql .= ' WHERE xc.`post_type` = "'.($post_type ? $post_type : 'post').'" AND xc.`id_xipposts` = "'.$id.'" ';
		$rslts = Db::getInstance()->getrow($sql);
			return isset($rslts['link_rewrite']) ? $rslts['link_rewrite'] : NULL;
    }
    public static function get_the_category($id_category = NULL,$category_type = 'category')
    {
		if($id_category == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT xc.`id_xipcategory`,xcl.`name`,xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xipcategory` xc 
		INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
		';
       $sql .= ' WHERE xc.`category_type` = "'.($category_type ? $category_type : 'category').'" AND xc.`id_xipcategory` = '.$id_category;
       $rslts = Db::getInstance()->getrow($sql);
       		return $rslts;
    }
    public static function TagInsert($tag = NULL)
    {
		if($tag == NULL)
			return false;
		$Languages = Language::getLanguages();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT xc.`id_xipcategory` FROM `'._DB_PREFIX_.'xipcategory` xc 
		INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
		';
       $sql .= ' WHERE xc.`category_type` = "tag" AND xcl.`name` = "'.$tag.'"';
       $rslts = Db::getInstance()->getrow($sql);
       if(isset($rslts) && !empty($rslts)){
       		return $rslts['id_xipcategory'];
       }else{
       		$tagobj = new xipcategoryclass();
			foreach($Languages as $lang){
            	$tagobj->name[$lang['id_lang']]	=	$tag;
            	$tagobj->link_rewrite[$lang['id_lang']]	=	Tools::str2url($tag);
            	$tagobj->title[$lang['id_lang']]	=	$tag;
            	$tagobj->description[$lang['id_lang']]	=	$tag;
            	$tagobj->meta_description[$lang['id_lang']]	=	$tag;
            	$tagobj->keyword[$lang['id_lang']]	=	$tag;
            }			
			$tagobj->category_type	=	'tag';
			$tagobj->category_group	=	0;
			$tagobj->position	=	0;
			$tagobj->active	=	1;
       		if($tagobj->add())
       			return $tagobj->id;
       		return false;
       }
    }
    public static function GetPostTags($id_post = NULL,$tag = 'tag')
    {
		if($id_post == NULL)
			return false;
		$results = '';
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT xcl.`name` FROM `'._DB_PREFIX_.'xip_category_post` xcp 
		INNER JOIN `'._DB_PREFIX_.'xipcategory` xc ON (xcp.`id_category` = xc.`id_xipcategory` AND xc.`category_type` = "'.$tag.'")
		INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xcp.`id_category` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_shop.')
		INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xcp.`id_category` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
		';
       $sql .= ' WHERE xcp.`id_post` = '.$id_post.' AND xcp.`type` = "'.$tag.'"';
       $rslts = Db::getInstance()->executeS($sql);
       if(isset($rslts) && !empty($rslts)){
       	$countrslts = count($rslts);
       	$i = 1;
       		foreach ($rslts as $rslt) {
       			if($i == $countrslts){
       				$results .= $rslt['name'];
       			}else{
       				$results .= $rslt['name'].',';
       			}
       		$i++;
       		}
       }
       return $results;
    }
    public static function GetPostTagsResults($id_post = NULL,$tag = 'tag')
    {
		if($id_post == NULL)
			return false;
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT xcp.`id_category`,xcl.`name`,xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xip_category_post` xcp 
		INNER JOIN `'._DB_PREFIX_.'xipcategory` xc ON (xcp.`id_category` = xc.`id_xipcategory` AND xc.`category_type` = "'.$tag.'")
		INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xcp.`id_category` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_shop.')
		INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xcp.`id_category` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
		';
       $sql .= ' WHERE xcp.`id_post` = '.$id_post.' AND xcp.`type` = "'.$tag.'"';
       $rslts = Db::getInstance()->executeS($sql);
       if(isset($rslts) && !empty($rslts)){
       		$i = 0;
       		foreach ($rslts as $rslt) {
       			$results[$i]['name'] = $rslt['name'];
       			if($tag == 'tag'){
       				$results[$i]['id_tag'] = $rslt['id_category'];
       				$results[$i]['link'] = xipblog::XipBlogTagLink(array('id'=>$rslt['id_category'],'rewrite'=>$rslt['link_rewrite'],'page_type'=>'tag','subpage_type'=>'post'));
       			}elseif($tag == 'category'){
       				$results[$i]['id_category'] = $rslt['id_category'];
       				$results[$i]['link'] = xipblog::XipBlogCategoryLink(array('id'=>$rslt['id_category'],'rewrite'=>$rslt['link_rewrite'],'page_type'=>'category','subpage_type'=>'post'));
       			}
       		$i++;
       		}
       }
       return $results;
    }
    public static function GetBlogTags($count = 10,$tag = 'tag')
    {
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT xc.`id_xipcategory`,xcl.`name`,xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xipcategory` xc 
		INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
		';
		$sql .= ' WHERE xc.`category_type` = "'.$tag.'" ';
		$sql .= ' ORDER BY xc.`id_xipcategory` DESC ';
		$sql .= ' LIMIT '.(int)$count;
		$rslts = Db::getInstance()->executeS($sql);
        if(isset($rslts) && !empty($rslts)){
       		$i = 0;
       		foreach ($rslts as $rslt) {
       			$results[$i]['name'] = $rslt['name'];
       			if($tag == 'tag'){
       				$results[$i]['id_tag'] = $rslt['id_xipcategory'];
       				$results[$i]['link'] = xipblog::XipBlogTagLink(array('id'=>$rslt['id_xipcategory'],'rewrite'=>$rslt['link_rewrite'],'page_type'=>'tag','subpage_type'=>'post'));
       			}elseif($tag == 'category'){
       				$results[$i]['id_category'] = $rslt['id_xipcategory'];
       				$results[$i]['link'] = xipblog::XipBlogCategoryLink(array('id'=>$rslt['id_xipcategory'],'rewrite'=>$rslt['link_rewrite'],'page_type'=>'category','subpage_type'=>'post'));
       			}
       		$i++;
       		}
        }
       return $results;
    }
    public static function GetCategoryPostsCount($category_default = NULL,$post_type = 'post'){
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT count(xc.`id_xipposts`) as allxipposts FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		';
		$sql .= ' WHERE xc.`active` = 1 ';
		if((int)$category_default != 0){
			$sql .= ' AND xc.category_default = '.$category_default;
		}
		if($post_type != NULL){
			$sql .= ' AND xc.post_type = "'.$post_type.'" ';
		}
		$sql .= ' ORDER BY xc.`position` DESC ';
		$queryexec = Db::getInstance()->getrow($sql);
        return (int)$queryexec['allxipposts'];
    }
    public static function GetCategoryPosts($category_default = NULL,$p = NULL,$n = NULL,$post_type = 'post',$order_by = 'DESC')
    {
    	if($p == NULL || $p < 1)
    		$p = 1;
    	if($n == NULL)
    		$n = (int)Configuration::get(xipblog::$xipblogshortname."post_per_page");
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$GetAllImageTypes = xipimagetypeclass::GetAllImageTypes();
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		';
		$sql .= ' WHERE xc.`active` = 1 ';
		if((int)$category_default != 0){
			$sql .= ' AND xc.category_default = '.$category_default;
		}
		if($post_type != NULL){
			$sql .= ' AND xc.post_type = "'.$post_type.'" ';
		}
		$sql .= ' ORDER BY xc.`position`  '.$order_by;
		$sql .= ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
		$queryexec = Db::getInstance()->executeS($sql);
        if(isset($queryexec) && !empty($queryexec)){
      		$i = 0;
      		foreach($queryexec as $qlvalue) {
          		if(isset($qlvalue) && !empty($qlvalue))
          		foreach($qlvalue as $qkey => $qvalue) {
          			$results[$i][$qkey] = $qvalue;
	       			// start Image 		
	       			if($qkey == 'post_img'){
	       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
					        foreach ($GetAllImageTypes as $imagetype){
					        	$results[$i]['post_img_'.$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$qvalue;
					        	if(!self::ImageExists($imagetype['name'].'-'.$qvalue)){
					        		$results[$i]['post_img_'.$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
					        	}
					        }
					        if (!self::ImageExists($qvalue)){
					        	$results[$i]['post_img'] =	'noimage.jpg';
					        }
						}
	       			}
	       			// end Image 						
          			if($qkey == 'post_author'){
          				$post_author_arr = new Employee((int)$qvalue);
          				$results[$i]['post_author_arr']['lastname'] = $post_author_arr->lastname;
          				$results[$i]['post_author_arr']['firstname'] = $post_author_arr->firstname;
          			}
          			$results[$i]['link'] = xipblog::XipBlogPostLink(array('id'=>$qlvalue['id_xipposts'],'rewrite'=>$qlvalue['link_rewrite'],'page_type'=>$post_type));
          			$results[$i]['post_tags'] = self::GetPostTagsResults($qlvalue['id_xipposts'],"tag");
          			if(isset($qlvalue['audio']) && !empty($qlvalue['audio'])){
          				$results[$i]['audio_lists'] = @explode(",",$qlvalue['audio']);
          			}
          			if(isset($qlvalue['video']) && !empty($qlvalue['video'])){
          				$results[$i]['video_lists'] = @explode(",",$qlvalue['video']);
          			}
          			if(isset($qlvalue['gallery']) && !empty($qlvalue['gallery'])){
          				$gallery_lists = @explode(",",$qlvalue['gallery']);
          				if(isset($gallery_lists) && !empty($gallery_lists)){
          					$ij = 0;
          					foreach ($gallery_lists as $gall) {
          						$results[$i]['gallery_lists'][$ij]['main'] = xipblog_img_uri.$gall;
			       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
							        foreach ($GetAllImageTypes as $imagetype){
							        	$results[$i]['gallery_lists'][$ij][$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$gall;
							        	if(!self::ImageExists($imagetype['name'].'-'.$gall)){
							        		$results[$i]['gallery_lists'][$ij][$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
							        	}
							        }
								}
          					$ij++;
          					}
          				}
          			}
          			if($qkey == 'category_default'){
          				$category_default_arr = new xipcategoryclass((int)$qvalue);
          				$results[$i]['category_default_arr']['id'] = @$category_default_arr->id;
          				$results[$i]['category_default_arr']['name'] = @$category_default_arr->name[$id_lang];
          				$results[$i]['category_default_arr']['link_rewrite'] = @$category_default_arr->link_rewrite[$id_lang];
          				$results[$i]['category_default_arr']['title'] = @$category_default_arr->title[$id_lang];
          				$results[$i]['category_default_arr']['link'] = xipblog::XipBlogCategoryLink(array('id'=>$category_default_arr->id,'rewrite'=>$category_default_arr->link_rewrite[$id_lang],'page_type'=>'category','subpage_type'=>$post_type));
          			}
          		}
          		$i++;
      		}
        }
        return $results;
    }
    public static function GetPopularPosts($count = 4,$post_type = 'post',$order_by = 'DESC')
    {
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$GetAllImageTypes = xipimagetypeclass::GetAllImageTypes();
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		';
		$sql .= ' WHERE xc.`active` = 1 ';
		if($post_type != NULL){
			$sql .= ' AND xc.post_type = "'.$post_type.'" ';
		}
		$sql .= ' ORDER BY xc.`comment_count` '.$order_by;
		$sql .= ' LIMIT '.(int)$count;
		$queryexec = Db::getInstance()->executeS($sql);
        if(isset($queryexec) && !empty($queryexec)){
      		$i = 0;
      		foreach($queryexec as $qlvalue) {
          		if(isset($qlvalue) && !empty($qlvalue))
          		foreach($qlvalue as $qkey => $qvalue) {
          			$results[$i][$qkey] = $qvalue;
	       			// start Image 		
	       			if($qkey == 'post_img'){
	       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
					        foreach ($GetAllImageTypes as $imagetype){
					        	$results[$i]['post_img_'.$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$qvalue;
					        	if(!self::ImageExists($imagetype['name'].'-'.$qvalue)){
					        		$results[$i]['post_img_'.$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
					        	}
					        }
					        if (!self::ImageExists($qvalue)){
					        	$results[$i]['post_img'] =	'noimage.jpg';
					        }
						}
	       			}
	       			// end Image 						
          			if($qkey == 'post_author'){
          				$post_author_arr = new Employee((int)$qvalue);
          				$results[$i]['post_author_arr']['lastname'] = $post_author_arr->lastname;
          				$results[$i]['post_author_arr']['firstname'] = $post_author_arr->firstname;
          			}
          			$results[$i]['link'] = xipblog::XipBlogPostLink(array('id'=>$qlvalue['id_xipposts'],'rewrite'=>$qlvalue['link_rewrite'],'page_type'=>$post_type));
          			$results[$i]['post_tags'] = self::GetPostTagsResults($qlvalue['id_xipposts'],"tag");
          			if(isset($qlvalue['audio']) && !empty($qlvalue['audio'])){
          				$results[$i]['audio_lists'] = @explode(",",$qlvalue['audio']);
          			}
          			if(isset($qlvalue['video']) && !empty($qlvalue['video'])){
          				$results[$i]['video_lists'] = @explode(",",$qlvalue['video']);
          			}
          			if(isset($qlvalue['gallery']) && !empty($qlvalue['gallery'])){
          				$gallery_lists = @explode(",",$qlvalue['gallery']);
          				if(isset($gallery_lists) && !empty($gallery_lists)){
          					$ij = 0;
          					foreach ($gallery_lists as $gall) {
          						$results[$i]['gallery_lists'][$ij]['main'] = xipblog_img_uri.$gall;
			       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
							        foreach ($GetAllImageTypes as $imagetype){
							        	$results[$i]['gallery_lists'][$ij][$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$gall;
							        	if(!self::ImageExists($imagetype['name'].'-'.$gall)){
							        		$results[$i]['gallery_lists'][$ij][$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
							        	}
							        }
								}
          					$ij++;
          					}
          				}
          			}
          			if($qkey == 'category_default'){
          				$category_default_arr = new xipcategoryclass((int)$qvalue);
          				$results[$i]['category_default_arr']['id'] = @$category_default_arr->id;
          				$results[$i]['category_default_arr']['name'] = @$category_default_arr->name[$id_lang];
          				$results[$i]['category_default_arr']['link_rewrite'] = @$category_default_arr->link_rewrite[$id_lang];
          				$results[$i]['category_default_arr']['title'] = @$category_default_arr->title[$id_lang];
          				$results[$i]['category_default_arr']['link'] = xipblog::XipBlogCategoryLink(array('id'=>$category_default_arr->id,'rewrite'=>$category_default_arr->link_rewrite[$id_lang],'page_type'=>'category','subpage_type'=>$post_type));
          			}
          		}
          		$i++;
      		}
        }
        return $results;
    }
    public static function GetRecentPosts($count = 4,$post_type = 'post',$order_by = 'DESC')
    {
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$GetAllImageTypes = xipimagetypeclass::GetAllImageTypes();
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		';
		$sql .= ' WHERE xc.`active` = 1 ';
		if($post_type != NULL){
			$sql .= ' AND xc.post_type = "'.$post_type.'" ';
		}
		$sql .= ' ORDER BY xc.`id_xipposts` '.$order_by;
		$sql .= ' LIMIT '.(int)$count;
		$queryexec = Db::getInstance()->executeS($sql);
        if(isset($queryexec) && !empty($queryexec)){
      		$i = 0;
      		foreach($queryexec as $qlvalue) {
          		if(isset($qlvalue) && !empty($qlvalue))
          		foreach($qlvalue as $qkey => $qvalue) {
          			$results[$i][$qkey] = $qvalue;
	       			// start Image 		
	       			if($qkey == 'post_img'){
	       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
					        foreach ($GetAllImageTypes as $imagetype){
					        	$results[$i]['post_img_'.$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$qvalue;
					        	if(!self::ImageExists($imagetype['name'].'-'.$qvalue)){
					        		$results[$i]['post_img_'.$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
					        	}
					        }
					        if (!self::ImageExists($qvalue)){
					        	$results[$i]['post_img'] =	'noimage.jpg';
					        }
						}
	       			}
	       			// end Image 						
          			if($qkey == 'post_author'){
          				$post_author_arr = new Employee((int)$qvalue);
          				$results[$i]['post_author_arr']['lastname'] = $post_author_arr->lastname;
          				$results[$i]['post_author_arr']['firstname'] = $post_author_arr->firstname;
          			}
          			$results[$i]['link'] = xipblog::XipBlogPostLink(array('id'=>$qlvalue['id_xipposts'],'rewrite'=>$qlvalue['link_rewrite'],'page_type'=>$post_type));
          			$results[$i]['post_tags'] = self::GetPostTagsResults($qlvalue['id_xipposts'],"tag");
          			if(isset($qlvalue['audio']) && !empty($qlvalue['audio'])){
          				$results[$i]['audio_lists'] = @explode(",",$qlvalue['audio']);
          			}
          			if(isset($qlvalue['video']) && !empty($qlvalue['video'])){
          				$results[$i]['video_lists'] = @explode(",",$qlvalue['video']);
          			}
          			if(isset($qlvalue['gallery']) && !empty($qlvalue['gallery'])){
          				$gallery_lists = @explode(",",$qlvalue['gallery']);
          				if(isset($gallery_lists) && !empty($gallery_lists)){
          					$ij = 0;
          					foreach ($gallery_lists as $gall) {
          						$results[$i]['gallery_lists'][$ij]['main'] = xipblog_img_uri.$gall;
			       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
							        foreach ($GetAllImageTypes as $imagetype){
							        	$results[$i]['gallery_lists'][$ij][$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$gall;
							        	if(!self::ImageExists($imagetype['name'].'-'.$gall)){
							        		$results[$i]['gallery_lists'][$ij][$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
							        	}
							        }
								}
          					$ij++;
          					}
          				}
          			}
          			if($qkey == 'category_default'){
          				$category_default_arr = new xipcategoryclass((int)$qvalue);
          				$results[$i]['category_default_arr']['id'] = @$category_default_arr->id;
          				$results[$i]['category_default_arr']['name'] = @$category_default_arr->name[$id_lang];
          				$results[$i]['category_default_arr']['link_rewrite'] = @$category_default_arr->link_rewrite[$id_lang];
          				$results[$i]['category_default_arr']['title'] = @$category_default_arr->title[$id_lang];
          				$results[$i]['category_default_arr']['link'] = xipblog::XipBlogCategoryLink(array('id'=>$category_default_arr->id,'rewrite'=>$category_default_arr->link_rewrite[$id_lang],'page_type'=>'category','subpage_type'=>$post_type));
          			}
          		}
          		$i++;
      		}
        }
        return $results;
    }
    public static function ImageExists($file = NULL){
    	if($file == NULL){
    		return false;
    	}
    	$image = xipblog_img_dir.$file;
    	if(file_exists($image)){
    		return true;
    	}else{
    		return false;
    	}
    }
    public static function PostCountUpdate($id = NULL){
    	if($id == NULL || $id == 0)
    		return false;
	    $sql = 'UPDATE '._DB_PREFIX_.'xipposts as xc SET xc.comment_count = (xc.comment_count+1) where xc.id_xipposts = '.$id;
		if(Db::getInstance()->execute($sql))
			return true;
		else
			return false;
	}
    public static function GetSinglePost($id_post = NULL,$post_type = 'post')
    {
    	if($id_post == NULL)
    		return false;
       $results = array();
       $id_lang = (int)Context::getContext()->language->id;
       $id_shop = (int)Context::getContext()->shop->id;
       $GetAllImageTypes = xipimagetypeclass::GetAllImageTypes();
       $sql = 'SELECT * FROM `'._DB_PREFIX_.'xipposts` xc 
               INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
               INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
               ';
       $sql .= ' WHERE xc.`active` = 1 AND xc.post_type = "'.$post_type.'" AND xc.id_xipposts = '.(int)$id_post;
       $queryexec = Db::getInstance()->getrow($sql);
       if(isset($queryexec) && !empty($queryexec)){
       		foreach ($queryexec as $qkey => $qvalue) {
       			$results[$qkey] = $qvalue;
       			// start Image
       			if($qkey == 'post_img'){
       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
				        foreach($GetAllImageTypes as $imagetype){
				        	$results['post_img_'.$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$qvalue;
				        	if(!self::ImageExists($imagetype['name'].'-'.$qvalue)){
				        		$results['post_img_'.$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
				        	}
				        }
				        if(!self::ImageExists($qvalue)){
				        	$results['post_img'] =	'noimage.jpg';
				        }
					}
       			}
       			// end Image
       			if($qkey == 'post_author'){
       				$post_author_arr = new Employee((int)$qvalue);
       				$results['post_author_arr']['lastname'] = $post_author_arr->lastname;
       				$results['post_author_arr']['firstname'] = $post_author_arr->firstname;
       			}
      			if($qkey == 'audio'){
      				$results['audio_lists'] = @explode(",",$qvalue);
      			}
      			if($qkey == 'video'){
      				$results['video_lists'] = @explode(",",$qvalue);
      			}
      			if($qkey == 'gallery'){
      				$gallery_lists = @explode(",",$qvalue);
      				if(isset($gallery_lists) && !empty($gallery_lists)){
      					$ij = 0;
      					foreach ($gallery_lists as $gall) {
      						$results['gallery_lists'][$ij]['main'] = xipblog_img_uri.$gall;
		       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
						        foreach ($GetAllImageTypes as $imagetype){
						        	$results['gallery_lists'][$ij][$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$gall;
						        	if(!self::ImageExists($imagetype['name'].'-'.$gall)){
						        		$results['gallery_lists'][$ij][$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
						        	}
						        }
							}
							$ij++;
      					}
      				}
      			}
       			$results['link'] = xipblog::XipBlogPostLink(array('id'=>$queryexec['id_xipposts'],'rewrite'=>$queryexec['link_rewrite'],'page_type'=>$post_type));
       			$results['post_tags'] = self::GetPostTagsResults($queryexec['id_xipposts'],"tag");
       			if($qkey == 'category_default'){
       				$category_default_arr = new xipcategoryclass((int)$qvalue);
       				$results['category_default_arr']['id'] = @$category_default_arr->id;
       				$results['category_default_arr']['name'] = @$category_default_arr->name[$id_lang];
       				$results['category_default_arr']['title'] = @$category_default_arr->title[$id_lang];
       				$results['category_default_arr']['link_rewrite'] = @$category_default_arr->link_rewrite[$id_lang];
       				$results['category_default_arr']['link'] = xipblog::XipBlogCategoryLink(array('id'=>$category_default_arr->id,'rewrite'=>$category_default_arr->link_rewrite[$id_lang],'subpage_type'=>$post_type,'page_type'=>'category'));
       			}
       		}
       }
       return $results;
    }
    public static function GetTagPosts($id_tag = NULL,$p = NULL,$n = NULL,$post_type = 'post',$order_by = 'DESC')
    {
    	if($id_tag == NULL || $id_tag == 0)
    		return false;
    	if($p == NULL || $p < 1)
    		$p = 1;
    	if($n == NULL)
    		$n = (int)Configuration::get(xipblog::$xipblogshortname."post_per_page");
		$results = array();
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$GetAllImageTypes = xipimagetypeclass::GetAllImageTypes();
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'xipposts` xc 
		INNER JOIN `'._DB_PREFIX_.'xipposts_lang` xcl ON (xc.`id_xipposts` = xcl.`id_xipposts` AND xcl.`id_lang` = '.$id_lang.')
		INNER JOIN `'._DB_PREFIX_.'xipposts_shop` xcs ON (xc.`id_xipposts` = xcs.`id_xipposts` AND xcs.`id_shop` = '.$id_shop.')
		INNER JOIN `'._DB_PREFIX_.'xip_category_post` xcp ON (xcp.`id_post` = xc.`id_xipposts` AND xcp.`id_category` = '.(int)$id_tag.' ) 
		';
		$sql .= ' WHERE xc.`active` = 1 ';
		if($post_type != NULL){
			$sql .= ' AND xc.post_type = "'.$post_type.'" ';
		}
		$sql .= ' ORDER BY xc.`position`  '.$order_by;
		$sql .= ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
		$queryexec = Db::getInstance()->executeS($sql);
        if(isset($queryexec) && !empty($queryexec)){
      		$i = 0;
      		foreach($queryexec as $qlvalue) {
          		if(isset($qlvalue) && !empty($qlvalue))
          		foreach($qlvalue as $qkey => $qvalue) {
          			$results[$i][$qkey] = $qvalue;
	       			// start Image 		
	       			if($qkey == 'post_img'){
	       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
					        foreach ($GetAllImageTypes as $imagetype){
					        	$results[$i]['post_img_'.$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$qvalue;
					        	if(!self::ImageExists($imagetype['name'].'-'.$qvalue)){
					        		$results[$i]['post_img_'.$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
					        	}
					        }
					        if (!self::ImageExists($qvalue)){
					        	$results[$i]['post_img'] =	'noimage.jpg';
					        }
						}
	       			}
	       			// end Image 						
          			if($qkey == 'post_author'){
          				$post_author_arr = new Employee((int)$qvalue);
          				$results[$i]['post_author_arr']['lastname'] = $post_author_arr->lastname;
          				$results[$i]['post_author_arr']['firstname'] = $post_author_arr->firstname;
          			}
          			$results[$i]['link'] = xipblog::XipBlogPostLink(array('id'=>$qlvalue['id_xipposts'],'rewrite'=>$qlvalue['link_rewrite'],'page_type'=>$post_type));
          			$results[$i]['post_tags'] = self::GetPostTagsResults($qlvalue['id_xipposts'],"tag");
          			if(isset($qlvalue['audio']) && !empty($qlvalue['audio'])){
          				$results[$i]['audio_lists'] = @explode(",",$qlvalue['audio']);
          			}
          			if(isset($qlvalue['video']) && !empty($qlvalue['video'])){
          				$results[$i]['video_lists'] = @explode(",",$qlvalue['video']);
          			}
          			if(isset($qlvalue['gallery']) && !empty($qlvalue['gallery'])){
          				$gallery_lists = @explode(",",$qlvalue['gallery']);
          				if(isset($gallery_lists) && !empty($gallery_lists)){
          					$ij = 0;
          					foreach ($gallery_lists as $gall) {
          						$results[$i]['gallery_lists'][$ij]['main'] = xipblog_img_uri.$gall;
			       				if(isset($GetAllImageTypes) && !empty($GetAllImageTypes)){
							        foreach ($GetAllImageTypes as $imagetype){
							        	$results[$i]['gallery_lists'][$ij][$imagetype['name']] = xipblog_img_uri.$imagetype['name'].'-'.$gall;
							        	if(!self::ImageExists($imagetype['name'].'-'.$gall)){
							        		$results[$i]['gallery_lists'][$ij][$imagetype['name']] =	xipblog_img_uri.$imagetype['name'].'-noimage.jpg';
							        	}
							        }
								}
          					$ij++;
          					}
          				}
          			}
          			if($qkey == 'category_default'){
          				$category_default_arr = new xipcategoryclass((int)$qvalue);
          				$results[$i]['category_default_arr']['id'] = @$category_default_arr->id;
          				$results[$i]['category_default_arr']['name'] = @$category_default_arr->name[$id_lang];
          				$results[$i]['category_default_arr']['link_rewrite'] = @$category_default_arr->link_rewrite[$id_lang];
          				$results[$i]['category_default_arr']['title'] = @$category_default_arr->title[$id_lang];
          				$results[$i]['category_default_arr']['link'] = xipblog::XipBlogCategoryLink(array('id'=>$category_default_arr->id,'rewrite'=>$category_default_arr->link_rewrite[$id_lang],'page_type'=>'category','subpage_type'=>$post_type));
          			}
          		}
          		$i++;
      		}
        }
        return $results;
    }
}