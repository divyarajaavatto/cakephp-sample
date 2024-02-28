<!-- templates/Users/add.php -->

<div class="users form">
<?= $this->Form->create(null, [
    'url' => [
        'controller' => 'Users',
        'action' => 'add'
    ]
]) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>