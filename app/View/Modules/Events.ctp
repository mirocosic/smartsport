//<script>
    
var eventsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Event.id',mapping:'Event.id'},
        {name:'Event.title',mapping:'Event.title'},
        {name:'Event.competition_id',mapping:'Event.competition_id'},
        {name:'Event.start_time',mapping:'Event.start_time'},
        {name:'Event.end_time',mapping:'Event.end_time'},
    ],
    proxy: {
        type:'ajax',
        url:'/events/index'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});

var competitionsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Competition.id',mapping:'Competition.id'},
        {name:'Competition.title',mapping:'Competition.title'},
        {name:'Competition.type_id',mapping:'Competition.type_id'},
        {name:'Competition.start_date',mapping:'Competition.start_date'},
        {name:'Competition.end_date',mapping:'Competition.end_date'},
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
    
var eventsTab = Ext.create('Ext.panel.Panel',{
    title:"<?=__('Events');?>",
    glyph:'xf073@FontAwesome',
    items:[{
        xtype:"grid",
        store: eventsStore,
        columns:[
            {header:'ID',dataIndex:'Event.id',width:50},
            {header:"<?=__('Title');?>",dataIndex:'Event.title'},
            {header:"<?=__('Competition');?>",dataIndex:'Event.competition_id'},
            {
                header:"<?=__('Starts');?>",dataIndex:'Event.start_time',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{
                header:"<?=__('Ends');?>",dataIndex:'Event.end_time',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{  
                xtype: 'widgetcolumn',
                stopSelection: true,
                width:120,
                widget: {
                    xtype: 'button',
                    width:50,
                    //text: "<?= __('Edit');?>",
                    glyph:'xf040@FontAwesome',
                    defaultBindProperty: null, //important
                    handler: function(widgetColumn) {
                      var record = widgetColumn.getWidgetRecord();

                        var eventEditWindow = Ext.create('Ext.window.Window',{
                            title:'Event id = '+record.data.Event.id,
                            width: 300,
                            items: [{
                                xtype:"form",
                                id:"eventDataForm",
                                defaults: {
                                    xtype:'textfield',
                                    padding: "10 10 0 10",
                                    allowBlank: false
                                },
                                items:[{
                                    xtype:"hidden",
                                    name:"Event.id"
                                },{
                                    fieldLabel:"<?=__('Title');?>",
                                    name: 'Event.title'    
                                },{
                                    xtype:'combobox',
                                    name:'Event.competition_id',
                                    minChars: 2,
                                    store:competitionsStore,
                                    displayField:"Competition.title",
                                    valueField:'Competition.id',
                                    fieldLabel:"<?=__('Competition');?>",
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Starts');?>",
                                    name: 'Event.start_time',
                                    format:'d.m.Y',
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Ends');?>",
                                    name: 'Event.end_time',
                                    format:'d.m.Y',
                                }],
                                buttons:[{
                                    formBind: true,
                                    text:"<?=__('Save');?>",
                                    handler: function(){
                                        eventEditWindow.items.get('eventDataForm').getForm().submit({
                                            url: '/events/edit',
                                            success: function (form, action) {
                                                Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                eventsStore.load();  
                                                eventEditWindow.close();
                                            },
                                            failure: function (form, action) {
                                                Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                            }
                                        });
                                    }
                                },{
                                    text:"<?=__('Delete');?>",
                                    handler: function(){
                                        Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete event ');?>"+record.data.Event.name+"?",function(){
                                            Ext.Ajax.request({
                                                url: '/events/delete',
                                                params: {event_id: record.data.Event.id},
                                                success: function (response, opts) {
                                                    var obj = Ext.decode(response.responseText);
                                                    if (obj.success){
                                                        Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                    } else {
                                                        Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                    }
                                                    eventEditWindow.close();
                                                    eventsStore.load();
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

                        eventEditWindow.items.get('eventDataForm').getForm().loadRecord(record);
                        eventEditWindow.show();

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
            var eventEditWindow = Ext.create('Ext.window.Window',{
                title:"<?=__('Create new event');?>",
                width: 300,
                items: [{
                    xtype:"form",
                    id:"eventDataForm",
                    defaults: {
                        xtype:'textfield',
                        padding: "10 10 0 10",
                        allowBlank: false
                    },
                    items:[{
                        fieldLabel:"<?=__('Title');?>",
                        name: 'Event.title'    
                    },{
                        xtype:'combobox',
                        name:'Event.competition_id',
                        minChars: 2,
                        store:competitionsStore,
                        displayField:"Competition.title",
                        valueField:'Competition.id',
                        fieldLabel:"<?=__('Competition');?>",
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Starts');?>",
                        name: 'Event.start_time',
                        format:'d.m.Y'
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Ends');?>",
                        name: 'Event.end_time',
                        format:'d.m.Y'
                    }],
                    buttons:[{
                        formBind: true,
                        text:"<?=__('Save');?>",
                        handler: function(){
                            eventEditWindow.items.get('eventDataForm').getForm().submit({
                                url: '/events/edit',
                                success: function (form, action) {
                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                    eventsStore.load();  
                                    eventEditWindow.close();
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
            eventEditWindow.show();
        }
    }]
    
});