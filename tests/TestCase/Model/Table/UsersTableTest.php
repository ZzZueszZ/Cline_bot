<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

class UsersTableTest extends TestCase
{
    protected array $fixtures = ['app.Users'];

    protected UsersTable $Users;

    public function setUp(): void
    {
        parent::setUp();
        $this->Users = $this->getTableLocator()->get('Users');
    }

    public function tearDown(): void
    {
        unset($this->Users);
        parent::tearDown();
    }

    // ================================================================== validationDefault — happy path

    public function testSaveValidUser(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'newuser',
            'password' => 'securepass',
        ]);

        $saved = $this->Users->save($user);

        $this->assertNotFalse($saved);
        $this->assertNotEmpty($saved->id);
        // Password must be hashed by the entity mutator.
        $this->assertNotSame('securepass', $saved->password);
    }

    // ================================================================== validationDefault — failures

    public function testValidationFailsEmptyUsername(): void
    {
        $user = $this->Users->newEntity([
            'username' => '',
            'password' => 'securepass',
        ]);

        $this->assertFalse($this->Users->save($user));
        $this->assertArrayHasKey('username', $user->getErrors());
    }

    public function testValidationFailsShortPassword(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'shortpwd',
            'password' => 'abc',
        ]);

        $this->assertFalse($this->Users->save($user));
        $this->assertArrayHasKey('password', $user->getErrors());
    }

    public function testValidationFailsDuplicateUsername(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'admin', // already in fixture
            'password' => 'securepass',
        ]);

        $this->assertFalse($this->Users->save($user));
        $this->assertArrayHasKey('username', $user->getErrors());
    }

    // ================================================================== validationRegister — happy path

    public function testRegisterValidationPassesWithValidData(): void
    {
        $user = $this->Users->newEntity(
            [
                'username'         => 'newreg',
                'email'            => 'newreg@example.com',
                'password'         => 'SecurePass1!',
                'password_confirm' => 'SecurePass1!',
            ],
            ['validate' => 'register']
        );

        $this->assertEmpty($user->getErrors());
        $saved = $this->Users->save($user);
        $this->assertNotFalse($saved);
    }

    // ================================================================== validationRegister — failures

    public function testRegisterValidationFailsMissingEmail(): void
    {
        $user = $this->Users->newEntity(
            [
                'username'         => 'noemail',
                'password'         => 'SecurePass1!',
                'password_confirm' => 'SecurePass1!',
            ],
            ['validate' => 'register']
        );

        $this->assertArrayHasKey('email', $user->getErrors());
    }

    public function testRegisterValidationFailsInvalidEmail(): void
    {
        $user = $this->Users->newEntity(
            [
                'username'         => 'bademail',
                'email'            => 'not-an-email',
                'password'         => 'SecurePass1!',
                'password_confirm' => 'SecurePass1!',
            ],
            ['validate' => 'register']
        );

        $this->assertArrayHasKey('email', $user->getErrors());
    }

    public function testRegisterValidationFailsPasswordMismatch(): void
    {
        $user = $this->Users->newEntity(
            [
                'username'         => 'mismatch',
                'email'            => 'mismatch@example.com',
                'password'         => 'SecurePass1!',
                'password_confirm' => 'Different!',
            ],
            ['validate' => 'register']
        );

        $this->assertArrayHasKey('password_confirm', $user->getErrors());
    }

    public function testRegisterValidationFailsMissingPasswordConfirm(): void
    {
        $user = $this->Users->newEntity(
            [
                'username' => 'noconfirm',
                'email'    => 'noconfirm@example.com',
                'password' => 'SecurePass1!',
            ],
            ['validate' => 'register']
        );

        $this->assertArrayHasKey('password_confirm', $user->getErrors());
    }

    public function testRegisterValidationFailsDuplicateEmail(): void
    {
        $user = $this->Users->newEntity(
            [
                'username'         => 'uniqueuser',
                'email'            => 'admin@example.com', // already in fixture
                'password'         => 'SecurePass1!',
                'password_confirm' => 'SecurePass1!',
            ],
            ['validate' => 'register']
        );

        $this->assertFalse($this->Users->save($user));
        $this->assertArrayHasKey('email', $user->getErrors());
    }

    // ================================================================== validationResetPassword

    public function testResetPasswordValidationPassesWithMatchingPasswords(): void
    {
        $user = $this->Users->newEntity(
            [
                'password'         => 'NewSecure1!',
                'password_confirm' => 'NewSecure1!',
            ],
            ['validate' => 'resetPassword']
        );

        $this->assertEmpty($user->getErrors());
    }

    public function testResetPasswordValidationFailsShortPassword(): void
    {
        $user = $this->Users->newEntity(
            [
                'password'         => 'short',
                'password_confirm' => 'short',
            ],
            ['validate' => 'resetPassword']
        );

        $this->assertArrayHasKey('password', $user->getErrors());
    }

    public function testResetPasswordValidationFailsMismatch(): void
    {
        $user = $this->Users->newEntity(
            [
                'password'         => 'NewSecure1!',
                'password_confirm' => 'Different!',
            ],
            ['validate' => 'resetPassword']
        );

        $this->assertArrayHasKey('password_confirm', $user->getErrors());
    }
}
