<!DOCTYPE html>
<html>
    <head>
        <title>Main page for SmartSport App</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- load ExtJS -->
        <script src="/js/ext/ext-all.js"></script>
        
        <!-- load Theme Triton -->
        <script src="/ext-themes/theme-triton/theme-triton.js"></script>
        <link rel="stylesheet" href="/ext-themes/theme-triton/resources/theme-triton-all.css"/>
        
        <!-- load fonts -->
        <link rel="stylesheet" href="/css/fonts.css"/>
        
        <style>
            html,body {
                height:100%;
            }
            
        </style>
    </head>
    <body>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            <?php 
              $uid = AuthComponent::user('id');
              if ($uid){
                 //echo "ga('set', '&uid', 'UserID=$uid'); ";// Set the user ID using signed-in user_id.
                 echo "ga('create', 'UA-67040802-1', { 'userId': 'UserID=$uid' });";
                 echo "ga('send', 'pageview');";
              } else {
                  echo "ga('create', 'UA-67040802-1', 'auto');";
                  echo "ga('send', 'pageview');";
              }
            ?>

        </script>
        
      
       
    </body>
    
   <script type='text/javascript'>
    
Ext.onReady(function() {
    
    var usersStore = Ext.create('Ext.data.Store',{
        fields:[
            {name:'User.id',mapping:'User.id'},
            {name:'User.name',mapping:'User.name'},
            {name:'User.surname',mapping:'User.surname'},
            {name:'User.mail',mapping:'User.mail'},
            {name:'User.username',mapping:'User.username'}
            
        ],
        proxy: {
            type:'ajax',
            url:'/users/index'
        },
        reader: {
            type:'json'
        },
         autoLoad: true
    });
    
    var clubsStore = Ext.create('Ext.data.Store',{
        fields: [
            {name:'Club.id',mapping:'Club.id'},
            {name:'Club.name',mapping:'Club.name'}
        ],
        proxy: {
            type:'ajax',
            url:'/clubs/index'
        },
        reader: {
            type:'json'
        },
        autoLoad: true
    });
   
    
    var usersTab = new Ext.panel.Panel({
        title: '<?= __("Users");?>',
        glyph: 'xf0c0@FontAwesome',
        items:[{
            xtype:'grid',
            store:usersStore,
            columns: [
                {header:'Id',dataIndex:'User.id',width:50},
                {header:'<?=__("Name");?>',dataIndex:'User.name'},
                {header:'<?=__("Surname");?>',dataIndex:'User.surname'},
                {header:'<?=__("Mail");?>',dataIndex:'User.mail'},
                {header:'<?=__("Username");?>',dataIndex:'User.username'},
               
                {
                    text: 'Actions',
                    align: 'center',
                    stopSelection: true,
                    xtype: 'widgetcolumn',
                    widget: {
                        xtype: 'button',
                        _btnText: "<?= __('Edit');?>",
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                            var record = widgetColumn.getWidgetRecord();
                            var userEditWindow = Ext.create('Ext.window.Window',{
                                title:'User id = '+record.data.User.id,
                                width: 300,
                                //height: 300,
                                items: [{
                                    xtype:"form",
                                    id:"userDataForm",
                                    defaults: {
                                        xtype:'textfield',
                                        padding: "10 10 0 10",
                                        allowBlank: false,
                                        blankText:"Warning!"
                                    },
                                    items:[{
                                            xtype:"hidden",
                                            name:"User.id"
                                    },{
                                        fieldLabel:"<?=__('Name');?>",
                                        name: 'User.name'    
                                    },{
                                        name:"User.surname",
                                        fieldLabel:"<?=__('Surname');?>"
                                    },{
                                        name:"User.mail",
                                        fieldLabel:"<?=__('Mail');?>"
                                    },{
                                        name:"User.username",
                                        fieldLabel:"<?=__('Username');?>"
                                    }],
                                    buttons:[{
                                        formBind: true,
                                        text:"<?=__('Save');?>",
                                        handler: function(){
                                            userEditWindow.items.get('userDataForm').getForm().submit({
                                                url: '/users/edit',
                                                success: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                    usersStore.load();  
                                                    userEditWindow.close();
                                                },
                                                failure: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                                }
                                            });
                                        }
                                    },{
                                        text:"<?=__('Delete');?>",
                                          handler: function(){
                                            Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete user ');?>"+record.data.User.name+"?",function(){
                                                Ext.Ajax.request({
                                                    url: '/users/delete',
                                                    params: {user_id: record.data.User.id},
                                                    success: function (response, opts) {
                                                        var obj = Ext.decode(response.responseText);
                                                        if (obj.success == true){
                                                            Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                        } else {
                                                            Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                        }
                                                        userEditWindow.close();
                                                        usersStore.load();
                                                    },
                                                    failure: function (response, opts) {
                                                        Ext.Msg.alert("<?=__('Error');?>",response.message);
                                                    }
                                                });
                                            })
                                        }
                                    }]
                                        
                                }]
                             })
                            userEditWindow.items.get('userDataForm').getForm().loadRecord(record);
                            userEditWindow.show();
                        },
                        listeners: {
                              beforerender: function(widgetColumn){
                                  var record = widgetColumn.getWidgetRecord();
                                  widgetColumn.setText( widgetColumn._btnText ); //can be mixed with the row data if needed
                              }
                          }
                    }
                }
                            
            ]
        }]
    });
    
    var clubsTab = new Ext.panel.Panel({
        title:"<?=__('Clubs');?>",
        glyph:"xf1e7@FontAwesome",
        items:[{
            xtype:'grid',
            store:clubsStore,
            columns:[
                {header:'ID',dataIndex:'Club.id',width:50},
                {header:"<?=__('Name');?>",dataIndex:'Club.name'},
                
                { 
                    
                    stopSelection: true,
                    xtype: 'widgetcolumn',
                    widget: {
                        xtype: 'button',
                        text: "<?= __('Edit');?>",
                       
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                          var record = widgetColumn.getWidgetRecord();
                            
                            var clubEditWindow = Ext.create('Ext.window.Window',{
                                title:'Club id = '+record.data.Club.id,
                                width: 300,
                                items: [{
                                    xtype:"form",
                                    id:"clubDataForm",
                                    defaults: {
                                        xtype:'textfield',
                                        padding: "10 10 0 10",
                                        allowBlank: false
                                    },
                                    items:[{
                                        xtype:"hidden",
                                        name:"Club.id"
                                    },{
                                        fieldLabel:"<?=__('Name');?>",
                                        name: 'Club.name'    
                                    }],
                                    buttons:[{
                                        formBind: true,
                                        text:"<?=__('Save');?>",
                                        handler: function(){
                                            clubEditWindow.items.get('clubDataForm').getForm().submit({
                                                url: '/clubs/edit',
                                                success: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                    clubsStore.load();  
                                                    clubEditWindow.close();
                                                },
                                                failure: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                                }
                                            });
                                        }
                                    },{
                                        text:"<?=__('Delete');?>",
                                        handler: function(){
                                            Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete club ');?>"+record.data.Club.name+"?",function(){
                                                Ext.Ajax.request({
                                                    url: '/clubs/delete',
                                                    params: {id: record.data.Club.id},
                                                    success: function (response, opts) {
                                                        var obj = Ext.decode(response.responseText);
                                                        if (obj.success){
                                                            Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                        } else {
                                                            Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                        }
                                                        clubEditWindow.close();
                                                        clubsStore.load();
                                                    },
                                                    failure: function (response, opts) {
                                                        Ext.Msg.alert("<?=__('Error');?>",response.message);
                                                    }
                                                });
                                            })
                                        }
                                    }]
                                        
                                }]
                             });
                             
                            clubEditWindow.items.get('clubDataForm').getForm().loadRecord(record);
                            clubEditWindow.show();
                            
                        }
                    }
                   
                }
                
            ]
        },{
            xtype:'button',
            margin: '20 0 0 20',
            text:"<?=__('Create');?>",
            handler:function(){
                var clubEditWindow = Ext.create('Ext.window.Window',{
                    title:"<?=__('Create new club');?>",
                    width: 300,
                    items: [{
                        xtype:"form",
                        id:"clubDataForm",
                        defaults: {
                            xtype:'textfield',
                            padding: "10 10 0 10",
                            allowBlank: false
                        },
                        items:[{
                            fieldLabel:"<?=__('Name');?>",
                            name: 'Club.name'    
                        }],
                        buttons:[{
                            formBind: true,
                            text:"<?=__('Save');?>",
                            handler: function(){
                                clubEditWindow.items.get('clubDataForm').getForm().submit({
                                    url: '/clubs/edit',
                                    success: function (form, action) {
                                        Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                        clubsStore.load();  
                                        clubEditWindow.close();
                                    },
                                    failure: function (form, action) {
                                        Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                    }
                                });
                            }
                        },{
                            text:"<?=__('Delete');?>"
                        }]

                    }]
                 });

                clubEditWindow.items.get('clubDataForm').getForm().loadRecord(record);
                clubEditWindow.show();
            }
        }]
    });
    
    var permissionsTab = new Ext.panel.Panel({
        title: '<?=__("Permissions");?>',
        glyph: 'xf13e@FontAwesome'
    });
    
    var mainPanel = new Ext.panel.Panel({
        title: 'Smart Sport',
        glyph: 'xf1e3@FontAwesome',
        width: '100%',
        height: '100%',
        plugins: 'responsive',
        layout: 'fit',
        header: {
            titlePosition: 0,
                items:[{
                    xtype:'button',
                    text: 'Eng',
                    handler: function(){
                        window.location.href='<?=$this->Html->url(array('language'=>'eng'));?>';
                    }
                },{
                    xtype:'button',
                    text: 'Hrv',
                    handler: function(){
                        window.location.href='<?=$this->Html->url(array('language'=>'hrv'));?>';
                    }
                },{
                    xtype:'button',
                    text: '<?=__("Login");?>',
                    handler: function(){
                       window.location.href='<?=$this->Html->url(array('controller'=>'users','action'=>'login'));?>';
                    }
                },{
                    xtype:'button',
                    text: '<?=__("Logout");?>',
                    handler: function(){
                       window.location.href='<?=$this->Html->url(array('controller'=>'users','action'=>'logout'));?>';
                    }
                }
            ]    
        },
        items: [
            Ext.create('Ext.tab.Panel',{
            height:'100%',
            //width:'400',
           
            tabPosition: 'left',
            tabRotation: 0,
            tabBar: {
               padding: '10',
               border: false
            },

            defaults: {
                textAlign: 'left',
                bodyPadding: 0,
              
            },

            items:[
                usersTab,
                clubsTab,
                permissionsTab,
                
            {
              glyph: "xf135@FontAwesome",
              //  title: '<?= $this->Html->link(__("Test"),['controller'=>'test','action'=>'index']);?>'
                title: '<?= __("Test");?>'
            },{
                title: 'Nekaj kul',
                glyph: 'xf0c0@FontAwesome',
                html:'Content',
              
            }
                ]
                
        
    } )
        ],
        tools: [
            { type:'pin' },
            { type:'refresh' },
            { type:'search' },
            { type:'save' }
        ]
    });
    
   
    mainPanel.render(Ext.getBody());
});
    </script>
</html>