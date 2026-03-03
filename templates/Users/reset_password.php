<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Reset Password');
?>
<div class="users form">
    <h2><?= __('Reset Your Password') ?></h2>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($user, ['url' => $this->request->getRequestTarget()]) ?>
    <fieldset>
        <legend><?= __('Enter your new password') ?></legend>
        <?= $this->Form->control('password', ['type' => 'password', 'required' => true]) ?>
        <?= $this->Form->control('password_confirm', [
            'type'     => 'password',
            'label'    => __('Confirm New Password'),
            'required' => true,
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Reset Password')) ?>
    <?= $this->Form->end() ?>
    <p><?= $this->Html->link(__('Back to Login'), ['action' => 'login']) ?></p>
</div>
