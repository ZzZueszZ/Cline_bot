<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accessories Model
 *
 * @method \App\Model\Entity\Accessory newEmptyEntity()
 * @method \App\Model\Entity\Accessory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Accessory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Accessory get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Accessory findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Accessory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Accessory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Accessory|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Accessory saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('accessories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cameras', [
            'foreignKey' => 'assigned_camera_id',
            'joinType' => 'LEFT',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('description')
            ->maxLength('description', 500)
            ->allowEmptyString('description');

        $validator
            ->inList('status', ['Available', 'In Use', 'Damaged', 'Retired'])
            ->notEmptyString('status');

        $validator
            ->integer('assigned_camera_id')
            ->allowEmptyString('assigned_camera_id');

        $validator
            ->date('purchase_date')
            ->allowEmptyString('purchase_date');

        $validator
            ->date('warranty_expiry')
            ->allowEmptyString('warranty_expiry')
            ->add('warranty_expiry', 'custom', [
                'rule' => function ($value, $context) {
                    $purchaseDate = $context['data']['purchase_date'] ?? null;
                    if (empty($value) || empty($purchaseDate)) {
                        return true;
                    }
                    return $value >= $purchaseDate;
                },
                'message' => 'Warranty expiry date must be after purchase date.',
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(\Cake\ORM\RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn('assigned_camera_id', 'Cameras'), ['errorField' => 'assigned_camera_id']);

        // Custom rule: Accessories with status "In Use" must have assigned_camera_id
        $rules->add(function ($entity, $options) {
            if ($entity->status === 'In Use' && empty($entity->assigned_camera_id)) {
                return false;
            }
            return true;
        }, [
            'errorField' => 'status',
            'message' => 'Accessories with status "In Use" must be assigned to a camera.',
        ]);

        return $rules;
    }
}
