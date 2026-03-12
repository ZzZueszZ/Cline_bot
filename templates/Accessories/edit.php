<div class="accessories form content">
    <?= $this->Form->create($accessory) ?>
    <fieldset>
        <legend><?= __('Edit Accessory') ?></legend>
        <?php
            echo $this->Form->control('name', ['required' => true]);
            echo $this->Form->control('type', ['required' => true]);
            echo $this->Form->control('description', ['rows' => 3]);
            echo $this->Form->control('status', [
                'options' => ['Available' => 'Available', 'In Use' => 'In Use', 'Damaged' => 'Damaged', 'Retired' => 'Retired'],
                'empty' => __('Select Status'),
                'required' => true
            ]);
            echo $this->Form->control('assigned_camera_id', [
                'options' => $cameras,
                'empty' => __('Select Camera (Optional)'),
                'label' => __('Assigned Camera')
            ]);
            echo $this->Form->control('purchase_date', ['empty' => true, 'type' => 'date']);
            echo $this->Form->control('warranty_expiry', ['empty' => true, 'type' => 'date']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button button-outline']) ?>
    <?= $this->Form->end() ?>
</div>
