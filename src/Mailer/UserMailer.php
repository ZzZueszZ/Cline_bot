<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

class UserMailer extends Mailer
{
    /**
     * Sends a password-reset link to the user.
     *
     * @param \App\Model\Entity\User $user The user requesting a reset.
     * @return void
     */
    public function resetPassword(User $user): void
    {
        $resetUrl = Router::url(
            [
                'controller' => 'Users',
                'action'     => 'resetPassword',
                $user->password_reset_token,
            ],
            true
        );

        $this
            ->setTo((string)$user->email)
            ->setSubject(__('Password Reset Request'))
            ->setViewVars([
                'user'     => $user,
                'resetUrl' => $resetUrl,
            ]);

        $this->viewBuilder()->setTemplate('reset_password');
    }
}
