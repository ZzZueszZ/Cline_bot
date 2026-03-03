<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string $resetUrl
 */
?>
<p>Hello <?= h($user->username) ?>,</p>

<p>We received a request to reset the password for your account.</p>

<p>Click the link below to set a new password. This link expires in <strong>1 hour</strong>.</p>

<p>
    <a href="<?= h($resetUrl) ?>"><?= h($resetUrl) ?></a>
</p>

<p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>

<p>Thanks,<br>The Team</p>
