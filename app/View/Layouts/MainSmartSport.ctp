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
        
    </head>
    <body>
       <?php echo $this->fetch('content'); ?> 
        <div id="Footer">
            
            <?php echo $this->Html->link('English', array('language'=>'eng')); ?>
            <?php echo $this->Html->link('Hrvatski', array('language'=>'hrv')); ?>
            
            
           
        </div>
    </body>
</html>