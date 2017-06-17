<?php
class AdminxipimagetypeController extends ModuleAdminController {

    public function __construct() {
        $this->table = 'xip_image_type';
        $this->className = 'xipimagetypeclass';
        $this->deleted = false;
        $this->module = 'xipblog';
        $this->allow_export = false;
        $this->_defaultOrderWay = 'DESC';
        $this->bootstrap = true;
            parent::__construct();
        $this->fields_list = array(
            'id_xip_image_type' => array(
                'title' => $this->l('ID'),
                'width' => 100,
                'type' => 'text',
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'width' => 60,
                'type' => 'text',
            ),
            'width' => array(
                'title' => $this->l('Width'),
                'width' => 220,
                'type' => 'text',
            ),
            'height' => array(
	            'title' => $this->l('Height'),
				'width' => 100,
				'type' => 'text',
        	),
            'active' => array(
				'title' => $this->l('Status'), 
				'active' => 'status',
				'type' => 'bool', 
				'orderby' => false,
            )
        );
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            )
        );
        parent::__construct();
    }
    public function init()
    {
        parent::init();
        $id_shop = (int)Context::getContext()->shop->id;
        $this->_select = ' a.id_shop = '.$id_shop;
    }
    public function renderForm()
    {
		$this->fields_form = array(
            'legend' => array(
				'title' => $this->l('Xip Blog Image Type'),
			),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'desc' => $this->l('Enter Your Image Type Name'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'desc' => $this->l('Enter Your Width'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Height'),
                    'name' => 'height',
                    'desc' => $this->l('Enter Your Height'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Status'),
                    'name' => 'active',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );  
        if(!($xipimagetypeclass = $this->loadObject(true)))
            return;
        return parent::renderForm();
    }
    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        return parent::renderList();
    }
}