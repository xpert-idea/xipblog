<?php
class xippostmetaclass extends ObjectModel
{
	public $id;
	public $id_xippostmeta;
	public $id_xipposts;
	public $meta_key;
	public $meta_value;
	public static $definition = array(
		'table' => 'xippostmeta',
		'primary' => 'id_xippostmeta',
		'multilang' => false,
		'fields' => array(
				'id_xipposts' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
				'meta_key' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString'),
				'meta_value' =>			array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
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
        if(!parent::add($autodate, $null_values) || !Validate::isLoadedObject($this))
            return false;
        return true;
    }
}