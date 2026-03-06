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
            <?= $this->Form->postLink(
                __('Delete Camera'),
                ['action' => 'delete', $camera->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $camera->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cameras'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cameras form content">
            <?= $this->Form->create($camera) ?>
    <fieldset>
        <legend><?= __('Edit Camera') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('ip_address');
            echo $this->Form->control('location');
            echo $this->Form->control('status');
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => __('Select Category'), 'label' => __('Category')]);
            echo $this->Form->control('store_id', ['options' => $stores, 'empty' => __('Select Store'), 'label' => __('Store')]);
        ?>
    </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
