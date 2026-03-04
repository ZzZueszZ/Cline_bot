<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateInitialTables extends BaseMigration
{
    public function up(): void
    {
        $this->table('users', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('username', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('password_reset_token', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('token_expires', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addPrimaryKey(['id'])
            ->create();

        $this->table('cameras', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('ip_address', 'string', ['limit' => 45, 'null' => false])
            ->addColumn('location', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('status', 'boolean', ['null' => false, 'default' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addPrimaryKey(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('cameras')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
