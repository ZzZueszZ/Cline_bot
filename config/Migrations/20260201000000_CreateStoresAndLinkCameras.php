<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateStoresAndLinkCameras extends BaseMigration
{
    public function up(): void
    {
        // Create stores table
        $this->table('stores', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('name', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('address', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('latitude', 'decimal', ['precision' => 10, 'scale' => 7, 'null' => true, 'default' => null])
            ->addColumn('longitude', 'decimal', ['precision' => 10, 'scale' => 7, 'null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addPrimaryKey(['id'])
            ->create();

        // Add store_id foreign key to cameras
        $this->table('cameras')
            ->addColumn('store_id', 'integer', [
                'signed' => false,
                'null' => true,
                'default' => null,
                'after' => 'id',
            ])
            ->addForeignKey('store_id', 'stores', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION',
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('cameras')
            ->dropForeignKey('store_id')
            ->removeColumn('store_id')
            ->update();

        $this->table('stores')->drop()->save();
    }
}
