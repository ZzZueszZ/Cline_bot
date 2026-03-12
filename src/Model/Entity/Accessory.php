<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Accessory Entity
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property string $status
 * @property int|null $assigned_camera_id
 * @property \Cake\I18n\Date|null $purchase_date
 * @property \Cake\I18n\Date|null $warranty_expiry
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \App\Model\Entity\Camera|null $camera
 */
class Accessory extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'type' => true,
        'description' => true,
        'status' => true,
        'assigned_camera_id' => true,
        'purchase_date' => true,
        'warranty_expiry' => true,
        'created' => true,
        'modified' => true,
        'camera' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'modified',
    ];
}
