<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Store Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \App\Model\Entity\Camera[] $cameras
 */
class Store extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'address' => true,
        'latitude' => true,
        'longitude' => true,
        'created' => true,
        'modified' => true,
        'cameras' => true,
    ];
}
