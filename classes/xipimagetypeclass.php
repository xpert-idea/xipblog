<?php

class xipimagetypeclass extends ObjectModel
{
	public $id;
	public $id_xip_image_type;
	public $name;
	public $width;
	public $height;
	public $id_shop;
	public $active;
	public static $definition = array(
		'table' => 'xip_image_type',
		'primary' => 'id_xip_image_type',
		'multilang' => false,
		'fields' => array(
			'name' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'width' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'height' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'id_shop' =>array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'active' =>	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
		),
	);
	public function __construct($id = null, $id_lang = null, $id_shop = null)
	{
                parent::__construct($id, $id_lang, $id_shop);
    }
    public function update($null_values = false)
    {
        if(!parent::update($null_values))
            return false;
        return true;
    }
    public function add($autodate = true, $null_values = false)
    {
    	$this->id_shop = (int)Context::getContext()->shop->id;
        if(!parent::add($autodate, $null_values) || !Validate::isLoadedObject($this))
            return false;
        return true;
    }
    public static function GetAllImageTypes()
    {
       $id_shop = (int)Context::getContext()->shop->id;
       $sql = 'SELECT * FROM `'._DB_PREFIX_.'xip_image_type` ';
       $sql .= ' WHERE active = 1 AND id_shop = '.(int)$id_shop;
       $queryexec = Db::getInstance()->executeS($sql);
       return $queryexec;
    }
}