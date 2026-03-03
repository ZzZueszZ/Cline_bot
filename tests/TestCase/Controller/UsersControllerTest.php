<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Transport\DebugTransport;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Users'];

    /** Valid reset token for user #2 in the fixture (expires 2099). */
    private const VALID_TOKEN = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'; // 64×a

    /** Expired reset token for user #3 in the fixture (expired 2000). */
    private const EXPIRED_TOKEN = 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'; // 64×b

    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Redirect email to the debug transport so no real mail is sent.
        Configure::write('EmailTransport.default', ['className' => DebugTransport::class]);
        Configure::write('Email.default', ['transport' => 'default', 'from' => 'noreply@localhost']);
    }

    // ================================================================== Login

    public function testLoginPageRendered(): void
    {
        $this->get('/login');

        $this->assertResponseOk();
        $this->assertResponseContains('Login');
    }

    public function testLoginSuccessRedirectsToCameras(): void
    {
        $this->post('/login', [
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $this->assertRedirectContains('/cameras');
    }

    public function testLoginFailureShowsError(): void
    {
        $this->post('/login', [
            'username' => 'admin',
            'password' => 'wrongpassword',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Invalid username or password');
    }

    public function testLogoutRedirectsToLogin(): void
    {
        $this->session(['Auth' => ['id' => 1, 'username' => 'admin']]);

        $this->post('/logout');

        $this->assertRedirectContains('/login');
    }

    public function testUnauthenticatedAccessRedirectsToLogin(): void
    {
        $this->get('/cameras');

        $this->assertRedirectContains('/login');
    }

    // ================================================================== Register

    public function testRegisterPageRendered(): void
    {
        $this->get('/register');

        $this->assertResponseOk();
        $this->assertResponseContains('Create an Account');
    }

    public function testRegisterSuccessRedirectsToLogin(): void
    {
        $this->post('/register', [
            'username'         => 'newuser',
            'email'            => 'newuser@example.com',
            'password'         => 'SecurePass1!',
            'password_confirm' => 'SecurePass1!',
        ]);

        $this->assertRedirectContains('/login');
    }

    public function testRegisterSuccessSavesUser(): void
    {
        $this->post('/register', [
            'username'         => 'brandnew',
            'email'            => 'brandnew@example.com',
            'password'         => 'SecurePass1!',
            'password_confirm' => 'SecurePass1!',
        ]);

        $Users = $this->getTableLocator()->get('Users');
        $this->assertTrue($Users->exists(['username' => 'brandnew']));
    }

    public function testRegisterFailsWhenPasswordsMismatch(): void
    {
        $this->post('/register', [
            'username'         => 'mismatch',
            'email'            => 'mismatch@example.com',
            'password'         => 'SecurePass1!',
            'password_confirm' => 'DifferentPass!',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Register');
    }

    public function testRegisterFailsWithEmptyUsername(): void
    {
        $this->post('/register', [
            'username'         => '',
            'email'            => 'nouser@example.com',
            'password'         => 'SecurePass1!',
            'password_confirm' => 'SecurePass1!',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Register');
    }

    public function testRegisterFailsWithDuplicateUsername(): void
    {
        $this->post('/register', [
            'username'         => 'admin', // already in fixture
            'email'            => 'another@example.com',
            'password'         => 'SecurePass1!',
            'password_confirm' => 'SecurePass1!',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Register');
    }

    public function testRegisterFailsWithDuplicateEmail(): void
    {
        $this->post('/register', [
            'username'         => 'uniquename',
            'email'            => 'admin@example.com', // already in fixture
            'password'         => 'SecurePass1!',
            'password_confirm' => 'SecurePass1!',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Register');
    }

    // ================================================================== Forgot Password

    public function testForgotPasswordPageRendered(): void
    {
        $this->get('/forgot-password');

        $this->assertResponseOk();
        $this->assertResponseContains('Forgot Password');
    }

    public function testForgotPasswordWithRegisteredEmailShowsSuccess(): void
    {
        $this->post('/forgot-password', ['email' => 'admin@example.com']);

        $this->assertRedirectContains('/forgot-password');
    }

    public function testForgotPasswordWithUnknownEmailShowsSameSuccessMessage(): void
    {
        // Must NOT reveal whether the email is registered (OWASP A07).
        $this->post('/forgot-password', ['email' => 'nobody@example.com']);

        $this->assertRedirectContains('/forgot-password');
    }

    public function testForgotPasswordSetsTokenForKnownUser(): void
    {
        $this->post('/forgot-password', ['email' => 'admin@example.com']);

        $Users = $this->getTableLocator()->get('Users');
        $user  = $Users->get(1);
        $this->assertNotNull($user->password_reset_token);
        $this->assertNotNull($user->token_expires);
    }

    // ================================================================== Reset Password

    public function testResetPasswordPageRenderedWithValidToken(): void
    {
        $this->get('/reset-password/' . self::VALID_TOKEN);

        $this->assertResponseOk();
        $this->assertResponseContains('Reset Your Password');
    }

    public function testResetPasswordRedirectsWithExpiredToken(): void
    {
        $this->get('/reset-password/' . self::EXPIRED_TOKEN);

        $this->assertRedirectContains('/forgot-password');
    }

    public function testResetPasswordRedirectsWithInvalidToken(): void
    {
        $this->get('/reset-password/' . str_repeat('e', 64));

        $this->assertRedirectContains('/forgot-password');
    }

    public function testResetPasswordSuccessUpdatesPasswordAndRedirectsToLogin(): void
    {
        $this->post('/reset-password/' . self::VALID_TOKEN, [
            'password'         => 'NewSecurePass1!',
            'password_confirm' => 'NewSecurePass1!',
        ]);

        $this->assertRedirectContains('/login');
    }

    public function testResetPasswordSuccessClearsToken(): void
    {
        $this->post('/reset-password/' . self::VALID_TOKEN, [
            'password'         => 'NewSecurePass1!',
            'password_confirm' => 'NewSecurePass1!',
        ]);

        $Users = $this->getTableLocator()->get('Users');
        $user  = $Users->get(2);
        $this->assertNull($user->password_reset_token);
        $this->assertNull($user->token_expires);
    }

    public function testResetPasswordFailsWhenPasswordsMismatch(): void
    {
        $this->post('/reset-password/' . self::VALID_TOKEN, [
            'password'         => 'NewSecurePass1!',
            'password_confirm' => 'Different!',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Reset Your Password');
    }
}
