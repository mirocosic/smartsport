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