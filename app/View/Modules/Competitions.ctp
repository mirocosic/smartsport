//<script>
    
var competitionsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Competition.id',mapping:'Competition.id'},
        {name:'Competition.title',mapping:'Competition.title'},
    ],
    proxy: {
        type:'ajax',
        url:'/competitions/index'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});
    
var competitionsTab = Ext.create('Ext.panel.Panel',{
    title:"<?=__('Competitions');?>",
    glyph:'xf091@FontAwesome',
    items:[{
        xtype:"grid",
        store: competitionsStore,
        columns:[
            {header:'ID',dataIndex:'Competition.id',width:50},
            {header:"<?=__('Title');?>",dataIndex:'Competition.title'},
        ]
    },{
        xtype:'button',
        margin: '20 0 0 20',
        text:"<?=__('Create');?>",
        glyph:'xf067@FontAwesome',
        handler:function(){
            var competitionEditWindow = Ext.create('Ext.window.Window',{
                title:"<?=__('Create new competition');?>",
                width: 300,
                items: [{
                    xtype:"form",
                    id:"competitionDataForm",
                    defaults: {
                        xtype:'textfield',
                        padding: "10 10 0 10",
                        allowBlank: false
                    },
                    items:[{
                        fieldLabel:"<?=__('Title');?>",
                        name: 'Competition.title'    
                    }],
                    buttons:[{
                        formBind: true,
                        text:"<?=__('Save');?>",
                        handler: function(){
                            competitionEditWindow.items.get('competitionDataForm').getForm().submit({
                                url: '/competitions/edit',
                                success: function (form, action) {
                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                    competitionsStore.load();  
                                    competitionEditWindow.close();
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

           // clubEditWindow.items.get('clubDataForm').getForm().loadRecord(record);
            competitionEditWindow.show();
        }
    }]
    
});