<?php
class AdminxipblogsettingController extends AdminController {
  public function __construct()
  {
    $this->bootstrap = true;
    $this->className = 'Configuration';
    $this->table = 'configuration';
    parent::__construct();
    // This Page Only Used For Parent Conteiner
  }
}
