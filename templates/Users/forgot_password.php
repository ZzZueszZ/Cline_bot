<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Forgot Password');
?>
<div class="users form">
    <h2><?= __('Forgot Password') ?></h2>
    <?= $this->Flash->render() ?>
    <p><?= __('Enter your email address and we will send you a link to reset your password.') ?></p>
    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'forgotPassword']]) ?>
    <fieldset>
        <legend><?= __('Enter your email address') ?></legend>
        <?= $this->Form->control('email', ['type' => 'email', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Send Reset Link')) ?>
    <?= $this->Form->end() ?>
    <p><?= $this->Html->link(__('Back to Login'), ['action' => 'login']) ?></p>
</div>
