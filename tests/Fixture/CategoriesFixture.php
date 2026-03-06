<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 */
class CategoriesFixture extends TestFixture
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
                'name' => 'Indoor',
                'description' => 'Cameras designed for indoor use',
                'created' => '2026-03-06 21:30:00',
                'modified' => '2026-03-06 21:30:00',
            ],
            [
                'id' => 2,
                'name' => 'Outdoor',
                'description' => 'Cameras designed for outdoor use',
                'created' => '2026-03-06 21:30:00',
                'modified' => '2026-03-06 21:30:00',
            ],
            [
                'id' => 3,
                'name' => 'PTZ',
                'description' => 'Pan-Tilt-Zoom cameras',
                'created' => '2026-03-06 21:30:00',
                'modified' => '2026-03-06 21:30:00',
            ],
        ];
        parent::init();
    }
}
