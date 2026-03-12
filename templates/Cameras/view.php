<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camera $camera
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Camera'), ['action' => 'edit', $camera->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(
                __('Delete Camera'),
                ['action' => 'delete', $camera->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $camera->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cameras'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Camera'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cameras view content">
            <h3><?= h($camera->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($camera->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('IP Address') ?></th>
                    <td><?= h($camera->ip_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($camera->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $camera->status ? __('Active') : __('Inactive') ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($camera->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($camera->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($camera->modified) ?></td>
                </tr>
            </table>

            <div class="related">
                <h4><?= __('Related Accessories') ?></h4>
                <?php if (!empty($camera->accessories)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Type') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Purchase Date') ?></th>
                                <th><?= __('Warranty Expiry') ?></th>
                                <th><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($camera->accessories as $accessory) : ?>
                            <tr>
                                <td><?= h($accessory->name) ?></td>
                                <td><?= h($accessory->type) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $accessory->status)) ?>">
                                        <?= h($accessory->status) ?>
                                    </span>
                                </td>
                                <td><?= h($accessory->purchase_date) ?></td>
                                <td><?= h($accessory->warranty_expiry) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Accessories', 'action' => 'view', $accessory->id], ['class' => 'button button-outline']) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Accessories', 'action' => 'edit', $accessory->id], ['class' => 'button button-outline']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else : ?>
                    <p><?= __('No accessories assigned to this camera.') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
