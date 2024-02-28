<!-- templates/Users/add.php -->

<div class="users form">
<?= $this->Form->create(null) ?>
    <fieldset>
        <legend><?= __('User Login') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>