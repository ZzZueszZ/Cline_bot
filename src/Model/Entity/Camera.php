<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Camera Entity
 *
 * @property int $id
 * @property string $name
 * @property string $ip_address
 * @property string|null $location
 * @property bool $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Camera extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'ip_address' => true,
        'location' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
    ];
}
