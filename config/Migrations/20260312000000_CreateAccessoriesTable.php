<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateAccessoriesTable extends BaseMigration
{
    public function up(): void
    {
        // Create accessories table
        $this->table('accessories', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('description', 'text', ['null' => true, 'default' => null])
            ->addColumn('status', 'enum', [
                'values' => ['Available', 'In Use', 'Damaged', 'Retired'],
                'null' => false,
                'default' => 'Available',
            ])
            ->addColumn('assigned_camera_id', 'integer', [
                'signed' => false,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('purchase_date', 'date', ['null' => true, 'default' => null])
            ->addColumn('warranty_expiry', 'date', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addPrimaryKey(['id'])
            ->addForeignKey('assigned_camera_id', 'cameras', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION',
            ])
            ->addIndex(['status'])
            ->addIndex(['assigned_camera_id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('accessories')->drop()->save();
    }
}
