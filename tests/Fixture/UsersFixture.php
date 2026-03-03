<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public array $records = [];

    public function init(): void
    {
        $hasher = new DefaultPasswordHasher();

        $this->records = [
            [
                'id'                   => 1,
                'username'             => 'admin',
                'email'                => 'admin@example.com',
                'password'             => $hasher->hash('password123'),
                'password_reset_token' => null,
                'token_expires'        => null,
                'created'              => '2025-01-01 00:00:00',
                'modified'             => '2025-01-01 00:00:00',
            ],
            [
                'id'                   => 2,
                'username'             => 'user_with_token',
                'email'                => 'reset@example.com',
                'password'             => $hasher->hash('password123'),
                'password_reset_token' => str_repeat('a', 64), // valid hex token
                'token_expires'        => '2099-12-31 23:59:59', // far future — valid
                'created'              => '2025-01-01 00:00:00',
                'modified'             => '2025-01-01 00:00:00',
            ],
            [
                'id'                   => 3,
                'username'             => 'user_expired_token',
                'email'                => 'expired@example.com',
                'password'             => $hasher->hash('password123'),
                'password_reset_token' => str_repeat('b', 64), // valid hex token
                'token_expires'        => '2000-01-01 00:00:00', // in the past — expired
                'created'              => '2025-01-01 00:00:00',
                'modified'             => '2025-01-01 00:00:00',
            ],
        ];

        parent::init();
    }
}
