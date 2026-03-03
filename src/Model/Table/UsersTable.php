<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation — used for general entity saves (e.g. seeding, updates).
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->minLength('password', 8)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        return $validator;
    }

    /**
     * Registration validation — requires email and password confirmation.
     */
    public function validationRegister(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);

        $validator
            ->email('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password_confirm')
            ->requirePresence('password_confirm', 'create')
            ->notEmptyString('password_confirm')
            ->sameAs('password_confirm', 'password', __('Passwords do not match.'));

        return $validator;
    }

    /**
     * Forgot-password validation — only requires a valid email address.
     */
    public function validationForgotPassword(Validator $validator): Validator
    {
        $validator
            ->email('email')
            ->requirePresence('email')
            ->notEmptyString('email');

        return $validator;
    }

    /**
     * Reset-password validation — requires a new password and its confirmation.
     */
    public function validationResetPassword(Validator $validator): Validator
    {
        $validator
            ->scalar('password')
            ->minLength('password', 8)
            ->requirePresence('password')
            ->notEmptyString('password');

        $validator
            ->scalar('password_confirm')
            ->requirePresence('password_confirm')
            ->notEmptyString('password_confirm')
            ->sameAs('password_confirm', 'password', __('Passwords do not match.'));

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add(
            $rules->isUnique(['email'], ['allowMultipleNulls' => true]),
            ['errorField' => 'email']
        );

        return $rules;
    }
}
