<?php class EventsController extends AppController {
    
    var $uses = ['Event'];
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
    public function index(){
        
        $response = $this->Event->find('all');
        
        return json_encode($response);
        
    }
    
    function edit(){
        
       
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Event_id'])){
            $this->Event->create();
        } else {
            $saveData['Event']['id'] = $this->request->data['Event_id'];
        }
        
        $saveData['Event']['title'] = trim($this->request->data['Event_title']);
        $saveData['Event']['competition_id'] = $this->request->data['Event_competition_id'];
        
        $start_time = date_create_from_format('d.m.Y',$this->request->data['Event_start_time']); 
        $saveData['Event']['start_time'] = $start_time->format('Y-m-d');
        
        $end_time = date_create_from_format('d.m.Y',$this->request->data['Event_end_time']); 
        $saveData['Event']['end_time'] = $end_time->format('Y-m-d');
       
        if ($this->Event->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Event successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
  
        
    }
    
    function delete(){
        if (empty($this->request->data['event_id'])){
            $response['success'] = false;
            $response['message'] = 'Empty id sent!';
            return json_encode($response);
        }
       
        if ($this->Event->delete($this->request->data['event_id'])){
            $response['success'] = true;
            $response['message'] = 'Yessss! Gone!';
        } else {
           $response['success'] = false;
            $response['message'] = 'Error deleting competition.'; 
        }
        
        return json_encode($response);
    }
}