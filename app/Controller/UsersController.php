<?php class UsersController extends AppController {
    
    var $uses = ['User'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
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
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
        
    }
    
    function view(){
        
        $users = $this->User->find('all');
        
        $this->set('response',$this->result);
        $this->set('users',$users);
        
    }
    
    function delete(){
        
    }
    
    function edit(){
        
    }
}