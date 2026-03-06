<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Chat Controller — greeting and chat functionality.
 */
class ChatController extends AppController
{
    /**
     * Index method — greets the authenticated user.
     *
     * @return void
     */
    public function index(): void
    {
        $identity = $this->Authentication->getIdentity();
        $username = $identity ? $identity->get('username') : 'Guest';
        $greeting = __('Hello, {0}! Welcome to the chat.', $username);

        $this->set(compact('username', 'greeting'));
    }
}
