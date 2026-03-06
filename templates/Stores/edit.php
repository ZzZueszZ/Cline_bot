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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $store->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $store->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Stores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="stores form content">
            <?= $this->Form->create($store) ?>
            <fieldset>
                <legend><?= __('Edit Store') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('address');
                    echo $this->Form->control('latitude', ['type' => 'text', 'id' => 'latitude', 'value' => $store->latitude ?? '']); // Changed to text for easier JS manipulation
                    echo $this->Form->control('longitude', ['type' => 'text', 'id' => 'longitude', 'value' => $store->longitude ?? '']); // Changed to text for easier JS manipulation
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
        <div class="map-container" style="height: 400px; width: 100%; margin-top: 20px;">
            <div id="map" style="height: 100%; width: 100%;"></div>
        </div>
        <?php
        $this->Html->script('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['block' => true]);
        $this->Html->css('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', ['block' => true]);
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([13.7563, 100.5018], 13); // Default to Bangkok

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var latitudeInput = document.getElementById('latitude');
            var longitudeInput = document.getElementById('longitude');
            var initialLat = parseFloat(latitudeInput.value);
            var initialLng = parseFloat(longitudeInput.value);

            if (!isNaN(initialLat) && !isNaN(initialLng)) {
                map.setView([initialLat, initialLng], 15);
                window.storeMarker = L.marker([initialLat, initialLng]).addTo(map);
            }

            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);

                latitudeInput.value = lat;
                longitudeInput.value = lng;

                // Remove existing marker if any
                if (window.storeMarker) {
                    map.removeLayer(window.storeMarker);
                }

                // Add new marker
                window.storeMarker = L.marker([lat, lng]).addTo(map);
            });
        });
        </script>
    </div>
</div>
