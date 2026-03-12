<div class="accessories view content">
    <h3><?= h($accessory->name) ?></h3>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <h4><?= __('Accessory Information') ?></h4>
                    <table>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td><?= h($accessory->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td><?= h($accessory->type) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Status') ?></th>
                            <td>
                                <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $accessory->status)) ?>">
                                    <?= h($accessory->status) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?= __('Assigned Camera') ?></th>
                            <td>
                                <?= $accessory->has('camera') ? $this->Html->link($accessory->camera->name, ['controller' => 'Cameras', 'action' => 'view', $accessory->camera->id]) : __('None') ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?= __('Purchase Date') ?></th>
                            <td><?= h($accessory->purchase_date) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Warranty Expiry') ?></th>
                            <td><?= h($accessory->warranty_expiry) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($accessory->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($accessory->modified) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="column">
                    <h4><?= __('Description') ?></h4>
                    <p><?= $this->Text->autoParagraph(h($accessory->description)); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="related">
        <?php if (!empty($accessory->camera)) : ?>
            <h4><?= __('Related Camera') ?></h4>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('IP Address') ?></th>
                        <th><?= __('Location') ?></th>
                        <th><?= __('Status') ?></th>
                        <th><?= __('Actions') ?></th>
                    </tr>
                    <tr>
                        <td><?= h($accessory->camera->name) ?></td>
                        <td><?= h($accessory->camera->ip_address) ?></td>
                        <td><?= h($accessory->camera->location) ?></td>
                        <td><?= $accessory->camera->status ? __('Active') : __('Inactive') ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Cameras', 'action' => 'view', $accessory->camera->id], ['class' => 'button button-outline']) ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accessory->id], ['class' => 'button']) ?>
        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accessory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessory->id), 'class' => 'button button-outline']) ?>
        <?= $this->Html->link(__('List Accessories'), ['action' => 'index'], ['class' => 'button button-outline']) ?>
    </div>
</div>
