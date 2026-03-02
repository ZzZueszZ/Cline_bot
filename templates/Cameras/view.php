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
        </div>
    </div>
</div>
