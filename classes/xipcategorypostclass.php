<?php

class xipcategorypostclass extends ObjectModel
{
	public $id;
	public $id_xip_category_post;
	public $id_post;
	public $id_category;
	public $type;
	public static $definition = array(
		'table' => 'xip_category_post',
		'primary' => 'id_xip_category_post',
		'multilang' => false,
		'fields' => array(
			'id_post' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'id_category' =>	array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isString'),
		),
	);
}