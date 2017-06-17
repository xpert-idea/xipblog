<?php

class xipcategoryclass extends ObjectModel
{
	public $id;
	public $id_xipcategory;
	public $name;
	public $description;
	public $link_rewrite;
	public $category_img;
	public $category_group;
	public $category_type;
	public $title;
	public $meta_description;
	public $keyword;
	public $position;
	public $active;
	public static $definition = array(
		'table' => 'xipcategory',
		'primary' => 'id_xipcategory',
		'multilang' => true,
		'fields' => array(
			'name' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'link_rewrite' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'title' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'description' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'meta_description' =>array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),
			'keyword' =>		array('type' => self::TYPE_STRING, 'validate' => 'isString','lang' => true),

			'category_img' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'category_type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'category_group' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'position' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
		),
	);
	public function __construct($id = null, $id_lang = null, $id_shop = null)
	{
        Shop::addTableAssociation('xipcategory', array('type' => 'shop'));
                parent::__construct($id, $id_lang, $id_shop);
    }
    public static function CategoryExists($id_category = NULL,$category_type = 'post')
    {
		if($id_category == NULL || $id_category == 0)
			return false;
		$sql = 'SELECT xc.`id_xipcategory` FROM `'._DB_PREFIX_.'xipcategory` xc WHERE xc.`category_type` = "'.($category_type ? $category_type : 'category').'" AND xc.active = 1 AND xc.`id_xipcategory` = '.$id_category;
		$rslts = Db::getInstance()->getrow($sql);
			return (isset($rslts['id_xipcategory']) && !empty($rslts['id_xipcategory'])) ? true : false;
    }
    public function update($null_values = false)
    {
    	if (isset($_FILES['category_img']) && isset($_FILES['category_img']['tmp_name']) && !empty($_FILES['category_img']['tmp_name'])) {
    		$this->category_img = xipblog::UploadMedia('category_img');
    	}
        if(!parent::update($null_values))
            return false;
        return true;
    }
    public function add($autodate = true, $null_values = false)
    {
        if($this->position <= 0)
            $this->position = self::getTopPosition() + 1;
        $this->category_img = xipblog::UploadMedia('category_img');
        if(!parent::add($autodate, $null_values) || !Validate::isLoadedObject($this))
            return false;
        return true;
    }
    public static function getTopPosition()
    {
        $sql = 'SELECT MAX(`position`)
                FROM `'._DB_PREFIX_.'xipcategory`';
        $position = DB::getInstance()->getValue($sql);
        return (is_numeric($position)) ? $position : -1;
    }
    public function updatePosition($way, $position)
    {
        if (!$res = Db::getInstance()->executeS('
            SELECT `id_xipcategory`, `position`
            FROM `'._DB_PREFIX_.'xipcategory`
            ORDER BY `position` ASC'
        ))
            return false;
        if(!empty($res))
        foreach($res as $xipcategory)
            if((int)$xipcategory['id_xipcategory'] == (int)$this->id)
        $moved_xipcategory = $xipcategory;
        if(!isset($moved_xipcategory) || !isset($position))
            return false;
        $queryx = ' UPDATE `'._DB_PREFIX_.'xipcategory`
        SET `position`= `position` '.($way ? '- 1' : '+ 1').'
        WHERE `position`
        '.($way
        ? '> '.(int)$moved_xipcategory['position'].' AND `position` <= '.(int)$position
        : '< '.(int)$moved_xipcategory['position'].' AND `position` >= '.(int)$position.'
        ');
        $queryy = ' UPDATE `'._DB_PREFIX_.'xipcategory`
        SET `position` = '.(int)$position.'
        WHERE `id_xipcategory` = '.(int)$moved_xipcategory['id_xipcategory'];
        return (Db::getInstance()->execute($queryx)
        && Db::getInstance()->execute($queryy));
    }
    public static function getcategorypath($id_category = NULL,$category_type = 'category'){
    	$meta_title = Configuration::get(xipblog::$xipblogshortname."meta_title");
    	if($id_category == NULL){
    		return (isset($meta_title) ? $meta_title : "Blog");
    	}
    	$pipe = Configuration::get('PS_NAVIGATION_PIPE');
    	if (empty($pipe)) {
    	    $pipe = '>';
    	}
    	$blog_url = xipblog::XipBlogLink();
    	$full_paths = '<a href="'.$blog_url.'" title="'.$meta_title.'" data-gg="">'.$meta_title.'</a><span class="navigation-pipe">'.$pipe.'</span>';
    	$results = self::get_the_title($id_category,$category_type);
    	$str = (isset($results['name']) ? $results['name'] : $meta_title);
    	return $full_paths.$str;
    }
    public static function get_the_title($id_category = NULL,$category_type = 'category')
    {
		if($id_category == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT xc.`id_xipcategory`,xcl.`name`,xcl.`link_rewrite` FROM `'._DB_PREFIX_.'xipcategory` xc INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.') INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.') ';
		$sql .= ' WHERE xc.`category_type` = "'.($category_type ? $category_type : 'category').'" AND xc.`id_xipcategory` = '.$id_category;
		$rslts = Db::getInstance()->getrow($sql);
			return $rslts;
    }
    public static function get_the_id($rewrite = NULL,$category_type = 'category')
    {
		if($rewrite == NULL)
			return false;
		$id_lang = (int)Context::getContext()->language->id;
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT xc.`id_xipcategory` FROM `'._DB_PREFIX_.'xipcategory` xc INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.') INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.') ';
		$sql .= ' WHERE xc.`category_type` = "'.($category_type ? $category_type : 'category').'" AND xcl.`link_rewrite` = "'.$rewrite.'" ';
		$rslts = Db::getInstance()->getrow($sql);
			return isset($rslts['id_xipcategory']) ? $rslts['id_xipcategory'] : NULL;
    }
    public static function GetCategories($category_type = 'category',$category_group = NULL)
    {
       $id_lang = (int)Context::getContext()->language->id;
       $id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT * FROM `'._DB_PREFIX_.'xipcategory` xc 
               INNER JOIN `'._DB_PREFIX_.'xipcategory_lang` xcl ON (xc.`id_xipcategory` = xcl.`id_xipcategory` AND xcl.`id_lang` = '.$id_lang.')
               INNER JOIN `'._DB_PREFIX_.'xipcategory_shop` xcs ON (xc.`id_xipcategory` = xcs.`id_xipcategory` AND xcs.`id_shop` = '.$id_shop.')
               ';
       $sql .= ' WHERE xc.`active` = 1 AND  category_type = "'.$category_type.'" ';
		if($category_group != NULL){
			$sql .= ' AND category_group = '.$category_group;
		}
       $sql .= ' ORDER BY xc.`position` ASC ';
       return Db::getInstance()->executeS($sql);
    }
    public static function SerializeCategory($brief = true)
    {
    	$results = array();
    	if($brief == true){
    		$results[0]['id'] = 0;
    		$results[0]['name'] = 'Select Category';
    	}
    	$category = self::GetCategories();
    	if(isset($category) && !empty($category)){
    		$i = (int)$brief;
    		foreach ($category as $categoryvalue) {
    			$results[$i]['id'] = $categoryvalue['id_xipcategory'];
    			$results[$i]['name'] = $categoryvalue['name'];
    			$i++;
    		}
    	}
    	return $results;
    }
}
