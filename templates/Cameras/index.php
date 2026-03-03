<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Camera> $cameras
 */
?>
<div class="cameras index content">
    <h3><?= __('Cameras') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('IP Address') ?></th>
                    <th><?= __('Location') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cameras as $camera): ?>
                <tr>
                    <td><?= $this->Number->format($camera->id) ?></td>
                    <td><?= h($camera->name) ?></td>
                    <td><?= h($camera->ip_address) ?></td>
                    <td><?= h($camera->location) ?></td>
                    <td><?= $camera->status ? __('Active') : __('Inactive') ?></td>
                    <td>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $camera->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $camera->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $camera->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $camera->id)]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->Html->link(__('New Camera'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>
</div>
