<?php class HomepageController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        $this->layout = 'MainSmartSport';
       // $this->autoRender = false;
        
        //echo 'This is Homepage!';
    }
}