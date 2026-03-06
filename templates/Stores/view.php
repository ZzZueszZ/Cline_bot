<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Store $store
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Store'), ['action' => 'edit', $store->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Store'), ['action' => 'delete', $store->id], ['confirm' => __('Are you sure you want to delete # {0}?', $store->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Stores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Store'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="stores view content">
            <h3><?= h($store->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($store->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($store->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($store->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Latitude') ?></th>
                    <td><?= $store->latitude === null ? '' : $this->Number->format($store->latitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Longitude') ?></th>
                    <td><?= $store->longitude === null ? '' : $this->Number->format($store->longitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($store->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($store->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cameras') ?></h4>
                <?php if (!empty($store->cameras)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Store Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($store->cameras as $camera) : ?>
                        <tr>
                            <td><?= h($camera->id) ?></td>
                            <td><?= h($camera->name) ?></td>
                            <td><?= h($camera->store_id) ?></td>
                            <td><?= h($camera->created) ?></td>
                            <td><?= h($camera->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Cameras', 'action' => 'view', $camera->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Cameras', 'action' => 'edit', $camera->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cameras', 'action' => 'delete', $camera->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camera->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
