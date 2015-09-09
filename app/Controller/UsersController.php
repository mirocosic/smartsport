<?php class UsersController extends AppController {
    
    var $uses = ['User'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','logout','view');
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->layout = false;
            
            if ($this->Auth->login()) {
               // return $this->redirect($this->Auth->redirectUrl());
               $response['success'] = true;
               $response['message'] = 'Login successful!';
               $response['redirect'] = $this->Auth->redirectUrl();
               return json_encode($response);
            } else {
                $response['success'] = false;
                $response['message'] = 'Login failed!';
                return json_encode($response);
            }
           // $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    function add(){
        
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        $passwordHasher = new BlowfishPasswordHasher();
         
         
         if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['password'] = $passwordHasher->hash($this->request->data['User']['password']);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'view'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
        
    }
    
    function edit($id = null){
        if ($id == null) {
            $this->Session->setFlash(__('User ID not set.'));
            return $this->redirect(array('action' => 'view'));
        }
        
        $userData = $this->User->find('first',['conditions'=>['User.id'=>$id]]);
        if (!$this->request->data) {
            $this->request->data = $userData;
        } else {
            App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
            $passwordHasher = new BlowfishPasswordHasher();
            
            $this->request->data['User']['password'] = $passwordHasher->hash($this->request->data['User']['password']);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'view'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
    }
    
    function index(){
        $this->layout = false;
        $this->autoRender = false;
        $users = $this->User->find('all',[
            'fields'=>['User.id','User.username','User.name','User.surname','User.mail']
        ]);
        //$this->set('users',$users);
        
        return json_encode($users);
        
    }
    
    function view($id = null){
        if ($id == null){
            throw new NotFoundException;
        }
        
        $user = $this->User->find('first',[
            'conditions'=>['User.id'=>$id]
        ]);
        
        if ($user){
            $this->set('user',$user);
        } else {
            throw new NotFoundException;
        }
    }
    
    function delete(){
        
    }
    
    
}