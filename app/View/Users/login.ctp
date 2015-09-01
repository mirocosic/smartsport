<script type='text/javascript'>
    
Ext.onReady(function() {
    var loginPanel = new Ext.form.Panel({
        title:"<?=__('Login');?>",
        width: 320,
        url: 'login',
        defaultType: 'textfield',
        pollForChanges: true,
        padding: 10,
        items: [{
                fieldLabel: "<?=__('Username');?>",
                name: 'data[User][username]',
                hasFocus: true,
                itemId: 'username_field',
                allowBlank: false,
                margin: '30 10 10 10'
            }, {
                fieldLabel: "<?=__('Password');?>",
                name: 'data[User][password]',
                inputType: 'password',
                allowBlank: false,
                margin: '10 10 30 10'
            }, {
                name: '_method',
                value: 'POST',
                hidden: true,
                allowBlank: false
            }
        ],
        buttons: [{
            text: "<?=__('Log In');?>",
            formBind: true,
            // Function that fires when user clicks the button 
            handler: function() {
                submitFormAndLogin();
            }
        }],
        listeners: {
            afterRender: function(thisForm, options){
                this.keyNav = Ext.create('Ext.util.KeyNav', this.el, {
                    enter: submitFormAndLogin,
                    scope: this
                });
                Ext.defer(function(){
                    thisForm.down('#username_field').getEl().query('input')[0].focus();
                }, 500);
            }
        }
    });
    
     function submitFormAndLogin() {
     
        loginPanel.getForm().submit({
            method: 'POST',
            waitTitle: 'Connecting',
            waitMsg: 'Authenticating...',
            success: function() {
                Ext.Msg.alert('Status', 'Login Successful!', function(btn, text) {
                    if (btn == 'ok') {
                        var redirect = 'logincomplete';
                        window.location = redirect;
                    }
                });
            },
            failure: function(form, action) {
                if (action.failureType == 'server') {
                    var obj = Ext.decode(action.response.responseText);
                    Ext.Msg.alert('Login Failed!', obj.errors.reason);
                } else {
                    Ext.Msg.alert('Warning!', 'Authentication server is unreachable : ' + action.response.responseText);
                }
                loginPanel.getForm().reset();
            }
        });
        
    }
    
    loginPanel.render(Ext.get('content'));
});

</script>








<!--

<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <h3 class="form-signin-heading text-center"><?=__('Log In');?></h3>
        <div class="form-group">
            
        <?php echo $this->Form->input('username', ['class'=>'form-control','placeholder'=>__('Username'),'label'=>__('Username')]);
              echo $this->Form->input('password', ['class'=>'form-control','placeholder'=>__('Password'),'label'=>__('Password')]);
       
        ?>
        </div>
        <?= $this->Form->submit(__('Log In'));?>
    </fieldset>
   
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->element('sql_dump'); ?>

-->