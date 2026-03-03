<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    /**
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'username'             => true,
        'password'             => true,
        'password_confirm'     => true,
        'email'                => true,
        'password_reset_token' => true,
        'token_expires'        => true,
        'created'              => true,
        'modified'             => true,
    ];

    /**
     * @var list<string>
     */
    protected array $_hidden = ['password', 'password_reset_token'];

    protected function _setPassword(string $password): string
    {
        return (new DefaultPasswordHasher())->hash($password);
    }
}
