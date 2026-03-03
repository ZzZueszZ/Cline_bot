<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string $resetUrl
 */
?>
Hello <?= h($user->username) ?>,

We received a request to reset the password for your account.

Click the link below to set a new password. This link expires in 1 hour.

<?= $resetUrl ?>

If you did not request a password reset, please ignore this email.
Your password will remain unchanged.

Thanks,
The Team
