<?php
class AdminxipcommentController extends ModuleAdminController {

    public function __construct() {
        $this->table = 'xip_comments';
        $this->className = 'xipcommentclass';
        $this->deleted = false;
        $this->module = 'xipblog';
        $this->allow_export = false;
        $this->_defaultOrderWay = 'DESC';
        $this->bootstrap = true;
            parent::__construct();
        $this->fields_list = array(
            'id_xip_comments' => array(
                'title' => $this->l('ID'),
                'width' => 100,
                'type' => 'text',
            ),
            'id_post' => array(
                'title' => $this->l('Post ID'),
                'width' => 100,
                'type' => 'text',
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'width' => 60,
                'type' => 'text',
            ),
            'subject' => array(
                'title' => $this->l('Subject'),
                'width' => 220,
                'type' => 'text',
            ),
            'content' => array(
	            'title' => $this->l('Comment'),
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
    public function renderList()
    {
        // $this->addRowAction('edit');
        // $this->addRowAction('delete');
        return parent::renderList();
    }
}