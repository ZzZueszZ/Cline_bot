<?php
declare(strict_types=1);

namespace App\Controller;

use App\Mailer\UserMailer;
use Cake\I18n\DateTime;

class UsersController extends AppController
{
    /**
     * Allow public (unauthenticated) access to auth-related actions.
     *
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated([
            'login',
            'register',
            'forgotPassword',
            'resetPassword',
        ]);
    }

    // ------------------------------------------------------------------ Login

    /**
     * Login action.
     *
     * @return \Cake\Http\Response|null
     */
    public function login(): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        // If the user is already logged in redirect to cameras.
        if ($result !== null && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Cameras', 'action' => 'index']);

            return $this->redirect($redirect);
        }

        // On POST with failed authentication show an error.
        if ($this->request->is('post') && ($result === null || !$result->isValid())) {
            $this->Flash->error(__('Invalid username or password.'));
        }

        return null;
    }

    // ------------------------------------------------------------------ Logout

    /**
     * Logout action.
     *
     * @return \Cake\Http\Response
     */
    public function logout(): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // ------------------------------------------------------------------ Register

    /**
     * Register a new user account.
     *
     * GET  /register — show the registration form.
     * POST /register — validate, save, redirect to login.
     *
     * @return \Cake\Http\Response|null
     */
    public function register(): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['get', 'post']);

        /** @var \App\Model\Table\UsersTable $Users */
        $Users = $this->fetchTable('Users');
        $user  = $Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $Users->newEntity(
                $this->request->getData(),
                ['validate' => 'register']
            );

            if ($Users->save($user)) {
                $this->Flash->success(__('Account created successfully. Please log in.'));

                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error(__('Registration failed. Please correct the errors below.'));
        }

        $this->set(compact('user'));

        return null;
    }

    // ------------------------------------------------------------------ Forgot password

    /**
     * Forgot-password action.
     *
     * GET  /forgot-password — show the email request form.
     * POST /forgot-password — look up user by email, generate a reset token,
     *                         store it, and e-mail the reset link.
     *
     * Always shows the same success message to prevent email enumeration.
     *
     * @return \Cake\Http\Response|null
     */
    public function forgotPassword(): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            /** @var \App\Model\Table\UsersTable $Users */
            $Users = $this->fetchTable('Users');
            $email = (string)$this->request->getData('email');

            /** @var \App\Model\Entity\User|null $user */
            $user = $Users->findByEmail($email)->first();

            if ($user !== null) {
                $token = bin2hex(random_bytes(32));

                $user->password_reset_token = $token;
                $user->token_expires        = new DateTime('+1 hour');

                $Users->save($user, ['validate' => false]);

                try {
                    $mailer = new UserMailer('default');
                    $mailer->send('resetPassword', [$user]);
                } catch (\Exception $e) {
                    // Log but do not expose the error to the user.
                    $this->log($e->getMessage(), 'error');
                }
            }

            // Generic message prevents email enumeration (OWASP A07).
            $this->Flash->success(__(
                'If that email address is registered, a reset link has been sent.'
            ));

            return $this->redirect(['action' => 'forgotPassword']);
        }

        return null;
    }

    // ------------------------------------------------------------------ Reset password

    /**
     * Reset-password action.
     *
     * GET  /reset-password/{token} — validate token, show new-password form.
     * POST /reset-password/{token} — validate passwords, update user, redirect.
     *
     * @param string $token The reset token embedded in the e-mail link.
     * @return \Cake\Http\Response|null
     */
    public function resetPassword(string $token): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['get', 'post']);

        /** @var \App\Model\Table\UsersTable $Users */
        $Users = $this->fetchTable('Users');

        /** @var \App\Model\Entity\User|null $user */
        $user = $Users->findByPasswordResetToken($token)
            ->where(['token_expires >=' => new DateTime()])
            ->first();

        if ($user === null) {
            $this->Flash->error(__('The password reset link is invalid or has expired.'));

            return $this->redirect(['action' => 'forgotPassword']);
        }

        if ($this->request->is('post')) {
            $user = $Users->patchEntity(
                $user,
                $this->request->getData(),
                ['validate' => 'resetPassword']
            );

            if (!$user->hasErrors()) {
                // Clear the token so the link cannot be reused.
                $user->password_reset_token = null;
                $user->token_expires        = null;

                if ($Users->save($user)) {
                    $this->Flash->success(__('Your password has been reset. Please log in.'));

                    return $this->redirect(['action' => 'login']);
                }
            }

            $this->Flash->error(__('Password reset failed. Please correct the errors below.'));
        }

        $this->set(compact('user'));

        return null;
    }
}
