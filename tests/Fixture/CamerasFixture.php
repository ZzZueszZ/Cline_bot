<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CamerasFixture
 */
class CamerasFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'cameras';

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
                'name' => 'Front Door Camera',
                'ip_address' => '192.168.1.10',
                'location' => 'Main Entrance',
                'status' => 1,
                'created' => '2024-01-01 10:00:00',
                'modified' => '2024-01-01 10:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Parking Lot Camera',
                'ip_address' => '192.168.1.11',
                'location' => 'Parking Area B',
                'status' => 1,
                'created' => '2024-01-02 11:00:00',
                'modified' => '2024-01-02 11:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Lobby Camera',
                'ip_address' => '192.168.1.12',
                'location' => null,
                'status' => 0,
                'created' => '2024-01-03 12:00:00',
                'modified' => '2024-01-03 12:00:00',
            ],
        ];

        parent::init();
    }
}
