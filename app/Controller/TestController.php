<?php class TestController extends AppController {
    
    function index(){
       //$this->layout = 'MainSmartSport';
      
    }
    
    public function test(){
        $this->autoRender = false;
    }
}