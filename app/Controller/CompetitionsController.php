<?php class CompetitionsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
    public function index(){
        
        $response = $this->Competition->find('all');
        
        return json_encode($response);
        
    }
}