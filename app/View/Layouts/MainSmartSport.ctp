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
            {name:'id',mapping:'User.id'},
            {name:'name',mapping:'User.name'},
            {name:'surname',mapping:'User.surname'},
            {name:'mail',mapping:'User.mail'}
            
        ],
        proxy: {
            type:'ajax',
           // model: 'User',
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
                {header:'Id',dataIndex:'id'},
                {header:'<?=__("Name");?>',dataIndex:'name'},
                {header:'<?=__("Surname");?>',dataIndex:'surname'},
                {header:'<?=__("Mail");?>',dataIndex:'mail'},
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
                              //var record = widgColumn.getWidgetRecord();
                             // alert("Got data!");
                             Ext.Msg.alert('In Developement...','Sit Tight!');
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
    
    var permissionsTab = new Ext.panel.Panel({
        title: '<?=__("Permissions");?>',
        glyph: 'xf13e@FontAwesome',
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
                bodyPadding: 15,
              
            },

            items:[
                usersTab,
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