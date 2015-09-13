//<script> 
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
                   
                    align: 'center',
                    stopSelection: true,
                    xtype: 'widgetcolumn',
                    width:50,
                    widget: {
                        xtype: 'button',
                        height:30,
                        glyph:'xf040@FontAwesome',
                     //   _btnText: "<?= __('Edit');?>",
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
        },{
            xtype:'button',
            margin: '20 0 0 20',
            text:"<?=__('Create');?>",
            glyph:'xf067@FontAwesome',
            handler:function(){
                var userEditWindow = Ext.create('Ext.window.Window',{
                    title:"<?=__('Create new user');?>",
                    width: 300,
                    items: [{
                        xtype:"form",
                        id:"userDataForm",
                        defaults: {
                            xtype:'textfield',
                            padding: "10 10 0 10",
                            allowBlank: false
                        },
                        items:[{
                            fieldLabel:"<?=__('Name');?>",
                            name: 'User.name'    
                        },{
                            name:'User.surname',
                            fieldLabel:"<?=__('Surname');?>",
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
                            text:"<?=__('Delete');?>"
                        }]

                    }]
                 });

               // userEditWindow.items.get('userDataForm').getForm().loadRecord(record);
                userEditWindow.show();
            }
        }]
    });