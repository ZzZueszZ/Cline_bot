<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCategoriesAndLinkToCameras extends BaseMigration
{
    public function up(): void
    {
        // Create categories table
        $this->table('categories', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('description', 'text', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addPrimaryKey(['id'])
            ->addIndex(['name'], ['unique' => true])
            ->create();

        // Add category_id foreign key to cameras
        $this->table('cameras')
            ->addColumn('category_id', 'integer', [
                'signed' => false,
                'null' => true,
                'default' => null,
                'after' => 'store_id',
            ])
            ->addForeignKey('category_id', 'categories', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION',
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('cameras')
            ->dropForeignKey('category_id')
            ->removeColumn('category_id')
            ->update();

        $this->table('categories')->drop()->save();
    }
}
