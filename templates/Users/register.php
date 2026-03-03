<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Register');
?>
<div class="users form">
    <h2><?= __('Create an Account') ?></h2>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'register']]) ?>
    <fieldset>
        <legend><?= __('Please fill in your details') ?></legend>
        <?= $this->Form->control('username', ['required' => true]) ?>
        <?= $this->Form->control('email', ['type' => 'email', 'required' => true]) ?>
        <?= $this->Form->control('password', ['type' => 'password', 'required' => true]) ?>
        <?= $this->Form->control('password_confirm', [
            'type'     => 'password',
            'label'    => __('Confirm Password'),
            'required' => true,
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Register')) ?>
    <?= $this->Form->end() ?>
    <p><?= $this->Html->link(__('Already have an account? Log in'), ['action' => 'login']) ?></p>
</div>
