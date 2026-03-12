<div class="accessories index content">
    <?= $this->Html->link(__('New Accessory'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Accessories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('assigned_camera_id', 'Assigned Camera') ?></th>
                    <th><?= $this->Paginator->sort('purchase_date') ?></th>
                    <th><?= $this->Paginator->sort('warranty_expiry') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accessories as $accessory): ?>
                <tr>
                    <td><?= $this->Number->format($accessory->id) ?></td>
                    <td><?= h($accessory->name) ?></td>
                    <td><?= h($accessory->type) ?></td>
                    <td>
                        <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $accessory->status)) ?>">
                            <?= h($accessory->status) ?>
                        </span>
                    </td>
                    <td><?= $accessory->has('camera') ? $this->Html->link($accessory->camera->name, ['controller' => 'Cameras', 'action' => 'view', $accessory->camera->id]) : '' ?></td>
                    <td><?= h($accessory->purchase_date) ?></td>
                    <td><?= h($accessory->warranty_expiry) ?></td>
                    <td><?= h($accessory->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accessory->id], ['class' => 'button button-outline']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accessory->id], ['class' => 'button button-outline']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accessory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessory->id), 'class' => 'button button-outline']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
