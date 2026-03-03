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
            <?= $this->Html->link(__('List Cameras'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cameras form content">
            <?= $this->Form->create($camera) ?>
            <fieldset>
                <legend><?= __('Add Camera') ?></legend>
                <?php
                    echo $this->Form->control('name', ['label' => __('Name')]);
                    echo $this->Form->control('ip_address', ['label' => __('IP Address')]);
                    echo $this->Form->control('location', ['label' => __('Location'), 'required' => false]);
                    echo $this->Form->control('status', ['label' => __('Status'), 'type' => 'checkbox']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
