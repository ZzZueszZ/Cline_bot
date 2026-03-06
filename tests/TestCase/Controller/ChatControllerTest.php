<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * ChatController integration tests.
 */
class ChatControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures loaded for every test.
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
    ];

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Log in as a valid user so authenticated routes are accessible.
     */
    private function loginAsUser(): void
    {
        $this->session([
            'Auth' => [
                'id'       => 1,
                'username' => 'admin',
            ],
        ]);
    }

    // ── Happy path ────────────────────────────────────────────────────────────

    /**
     * GET /chat returns 200 for authenticated users.
     */
    public function testIndexReturns200(): void
    {
        $this->loginAsUser();
        $this->get('/chat');

        $this->assertResponseOk();
    }

    /**
     * Chat page displays greeting with the user's name.
     */
    public function testIndexDisplaysGreeting(): void
    {
        $this->loginAsUser();
        $this->get('/chat');

        $this->assertResponseOk();
        $this->assertResponseContains('Hello, admin! Welcome to the chat.');
    }

    /**
     * Chat page sets the username view variable.
     */
    public function testIndexSetsUsernameVariable(): void
    {
        $this->loginAsUser();
        $this->get('/chat');

        $this->assertResponseOk();
        $this->assertSame('admin', $this->viewVariable('username'));
    }

    /**
     * Chat page sets the greeting view variable.
     */
    public function testIndexSetsGreetingVariable(): void
    {
        $this->loginAsUser();
        $this->get('/chat');

        $this->assertResponseOk();
        $this->assertSame('Hello, admin! Welcome to the chat.', $this->viewVariable('greeting'));
    }

    /**
     * Chat page contains the Chat heading.
     */
    public function testIndexContainsChatHeading(): void
    {
        $this->loginAsUser();
        $this->get('/chat');

        $this->assertResponseOk();
        $this->assertResponseContains('Chat');
    }

    // ── Authentication ─────────────────────────────────────────────────────

    /**
     * Unauthenticated users are redirected away from /chat.
     */
    public function testIndexRequiresAuthentication(): void
    {
        $this->get('/chat');

        $this->assertRedirect();
    }
}
