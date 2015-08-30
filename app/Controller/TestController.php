<?php class TestController extends AppController {
    
    function index(){
       $this->layout = 'MainSmartSport';
       Configure::write('Config.language', 'hrv');
    }
}