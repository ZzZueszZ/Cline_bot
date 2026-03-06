<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="categories view content">
    <h3><?= h($category->name) ?></h3>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <h4><?= __('Category Details') ?></h4>
                    <table>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <td><?= $this->Number->format($category->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td><?= h($category->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Description') ?></th>
                            <td><?= h($category->description) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($category->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($category->modified) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="related">
        <h4><?= __('Related Cameras') ?></h4>
        <?php if (!empty($category->cameras)) : ?>
        <div class="table-responsive">
            <table>
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('IP Address') ?></th>
                    <th><?= __('Location') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($category->cameras as $cameras) : ?>
                <tr>
                    <td><?= $this->Number->format($cameras->id) ?></td>
                    <td><?= h($cameras->name) ?></td>
                    <td><?= h($cameras->ip_address) ?></td>
                    <td><?= h($cameras->location) ?></td>
                    <td><?= $cameras->status ? __('Active') : __('Inactive') ?></td>
                    <td>
                        <?= $this->Html->link(__('View'), ['controller' => 'Cameras', 'action' => 'view', $cameras->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Cameras', 'action' => 'edit', $cameras->id]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'button']) ?>
        <?= $this->Form->postLink(
            __('Delete Category'),
            ['action' => 'delete', $category->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'button']
        ) ?>
        <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'button']) ?>
    </div>
</div>
