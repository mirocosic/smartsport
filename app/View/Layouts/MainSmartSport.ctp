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
        
        <!-- load custom css overrides -->
        <link rel="stylesheet" href="/css/styles.css"/>
        
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
    
    <!-- load ext modules -->
    <?= $this->Html->script('/Modules/get/Users');?>
    <?= $this->Html->script('/Modules/get/Clubs');?>
    <?= $this->Html->script('/Modules/get/Permissions');?>
    <?= $this->Html->script('/Modules/get/Competitions');?>
    <?= $this->Html->script('/Modules/get/Events');?>
    <?= $this->Html->script('/Modules/get/Alliances');?>
    
   <script type='text/javascript'>
    
Ext.onReady(function() {
    
    Ext.define('Test', {
        extend: 'Ext.data.Model',
        fields: [{
            name: 'text',
            type: 'string'
        }],
        proxy: {
            type: 'memory',
            data: {
                success: true,
                children: [{
                   
                    text: 'Home',
                     glyph: 'xf1e3@FontAwesome',
                     iconCls: 'fa-building',
                    leaf: false, // this is a branch   
                    expanded: false,
                    children: [{
                        text: 'Mercedes-Benz',
                        leaf: true // this is a leaf node. It can't have children. Sad! :-(   
                    }, {
                        text: 'Audi',
                        leaf: true
                    }, {
                        text: 'Ferrari',
                         glyph: 'xf1e3@FontAwesome',
                        leaf: true
                    }]
                },{
                    text:'Admin',
                    expanded:false,
                    leaf:true,
                    href:'/admin'
                },{
                    text:'Settings',
                    expanded: false,
                    children:[
                        {text:'Miro',leaf:true},
                        {text:'Pero',leaf:true}
                    ]
                }]
            }
        }
    });

    var menuTreeStore = Ext.create('Ext.data.TreeStore', {
        model: 'Test'
    });
  
   
    var mainPanel = new Ext.panel.Panel({
        title: 'Smart Sport',
        glyph: 'xf1e3@FontAwesome',
        width: '100%',
        height: '100%',
        //height: '500px',
       // plugins: 'responsive',
        layout: 'border',
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
        items: [{
            region:'west',
            autoScroll: true,
            width: 250,
             split: true,
            layout: 'fit',
            // scrollable: 'y',
            items: [{
          
                xtype: 'treepanel',
                store: menuTreeStore,
                rootVisible: false,
                bufferedRenderer: false,
                animate: true,
                cls:'menuTree'
                
            }],
        },{
            region:'center'
        }
        ]
        
    });
    
   
    mainPanel.render(Ext.getBody());
});
    </script>
</html>