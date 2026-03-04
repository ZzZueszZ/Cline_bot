<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StoresFixture
 */
class StoresFixture extends TestFixture
{
    public string $table = 'stores';

    public function init(): void
    {
        $this->records = [
            [
                'id'        => 1,
                'name'      => 'Store Bangkok Central',
                'address'   => '123 Sukhumvit Rd, Bangkok',
                'latitude'  => 13.7563,
                'longitude' => 100.5018,
                'created'   => '2024-01-01 09:00:00',
                'modified'  => '2024-01-01 09:00:00',
            ],
            [
                'id'        => 2,
                'name'      => 'Store Chiang Mai',
                'address'   => '456 Nimman Rd, Chiang Mai',
                'latitude'  => 18.7883,
                'longitude' => 98.9853,
                'created'   => '2024-01-02 09:00:00',
                'modified'  => '2024-01-02 09:00:00',
            ],
        ];

        parent::init();
    }
}
