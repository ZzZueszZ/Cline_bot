<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AccessoriesFixture
 */
class AccessoriesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Test Cable',
                'type' => 'Power Cable',
                'description' => 'Test power cable for testing purposes',
                'status' => 'Available',
                'assigned_camera_id' => null,
                'purchase_date' => '2024-01-15',
                'warranty_expiry' => '2025-01-15',
                'created' => '2024-01-15 10:00:00',
                'modified' => '2024-01-15 10:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Test Mount',
                'type' => 'Wall Mount',
                'description' => 'Test wall mount for camera',
                'status' => 'In Use',
                'assigned_camera_id' => 1,
                'purchase_date' => '2024-02-20',
                'warranty_expiry' => '2026-02-20',
                'created' => '2024-02-20 14:30:00',
                'modified' => '2024-02-20 14:30:00',
            ],
            [
                'id' => 3,
                'name' => 'Test Storage',
                'type' => 'SD Card',
                'description' => 'Test SD card for camera storage',
                'status' => 'Damaged',
                'assigned_camera_id' => 2,
                'purchase_date' => '2024-03-10',
                'warranty_expiry' => '2025-03-10',
                'created' => '2024-03-10 09:15:00',
                'modified' => '2024-03-10 09:15:00',
            ],
            [
                'id' => 4,
                'name' => 'Old Cable',
                'type' => 'Network Cable',
                'description' => 'Old network cable',
                'status' => 'Retired',
                'assigned_camera_id' => null,
                'purchase_date' => '2022-05-01',
                'warranty_expiry' => '2023-05-01',
                'created' => '2022-05-01 11:00:00',
                'modified' => '2022-05-01 11:00:00',
            ],
        ];
        parent::init();
    }
}
