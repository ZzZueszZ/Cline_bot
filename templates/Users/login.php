<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Login');
?>
<div class="users form">
    <h2><?= __('Login') ?></h2>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'login']]) ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('username', ['required' => true]) ?>
        <?= $this->Form->control('password', ['type' => 'password', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Login')) ?>
    <?= $this->Form->end() ?>
</div>
