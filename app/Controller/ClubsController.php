<?php class ClubsController extends AppController {
    
    var $uses = ['Club'];
    
    public function index(){
        $this->layout = false;
        $this->autoRender = false;
        $clubs = $this->Club->find('all',[
            'fields'=>['Club.id','Club.name']
        ]);
      
        return json_encode($clubs);
        
    }
    
    function add(){
        
    }
    
    function edit($id = null){
        
        $this->layout = false;
        $this->autoRender = false;
        
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Club_id'])){
            $this->Club->create();
        } else {
            $saveData['Club']['id'] = $this->request->data['Club_id'];
        }
        
        $saveData['Club']['name'] = trim($this->request->data['Club_name']);
       
        if ($this->Club->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Club successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
    }
    
    function delete(){
        $this->layout = false;
        $this->autoRender = false;
        
        $response['success'] = true;
        $response['message'] = 'Yessss! Gone!';
        return json_encode($response);
    }
}