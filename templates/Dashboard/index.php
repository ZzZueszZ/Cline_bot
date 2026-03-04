<?php
/**
 * @var \App\View\AppView $this
 * @var int $totalStores
 * @var int $totalCameras
 * @var int $activeCameras
 * @var int $inactiveCameras
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Store> $stores
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Camera> $cameras
 * @var array<int, string> $storeList
 * @var string $searchQuery
 * @var string $statusFilter
 * @var string $storeFilter
 */
$this->assign('title', 'Dashboard');

// Convert result sets to arrays once so we can reuse them freely.
$storesArray  = $stores->toArray();
$camerasArray = $cameras->toArray();
?>
<?php $this->start('css') ?>
<style>
/* ── Dashboard Layout ──────────────────────────────── */
.dashboard { padding: 2rem 0; }
.dashboard-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: 12px;
    margin-bottom: 2.5rem;
    text-align: center;
}
.dashboard-hero h1 { font-size: 2.4rem; margin: 0 0 0.5rem; color: #fff; }
.dashboard-hero p  { font-size: 1.1rem; opacity: 0.8; margin: 0; }

/* ── Stat Cards ─────────────────────────────────────── */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.2rem;
    margin-bottom: 2.5rem;
}
.stat-card {
    border-radius: 10px;
    padding: 1.4rem 1.6rem;
    color: #fff;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    box-shadow: 0 4px 15px rgba(0,0,0,.15);
}
.stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; text-transform: uppercase; letter-spacing: .05em; }
.stat-card .stat-value { font-size: 2.4rem; font-weight: 700; line-height: 1; }
.stat-card .stat-icon  { font-size: 1.6rem; }
.card-stores   { background: linear-gradient(135deg, #667eea, #764ba2); }
.card-cameras  { background: linear-gradient(135deg, #11998e, #38ef7d); color: #1a3a2a; }
.card-active   { background: linear-gradient(135deg, #f7971e, #ffd200); color: #3a2a00; }
.card-inactive { background: linear-gradient(135deg, #cb2d3e, #ef473a); }

/* ── Section headings ────────────────────────────────── */
.section-heading {
    font-size: 1.3rem;
    font-weight: 700;
    border-left: 4px solid #0f3460;
    padding-left: 0.75rem;
    margin: 2rem 0 1rem;
    color: #1a1a2e;
}

/* ── Search / Filter bar ──────────────────────────────── */
.filter-bar {
    background: #f4f6fb;
    border-radius: 10px;
    padding: 1.2rem 1.4rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: flex-end;
    margin-bottom: 1.4rem;
}
.filter-bar label { font-size: 0.8rem; font-weight: 600; color: #555; display: block; margin-bottom: 0.2rem; }
.filter-bar input,
.filter-bar select { margin-bottom: 0; }
.filter-bar .filter-group { flex: 1 1 180px; }
.filter-bar .filter-actions { display: flex; gap: 0.5rem; align-items: flex-end; }

/* ── Status badge ──────────────────────────────────────── */
.badge {
    display: inline-block;
    padding: .2em .65em;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: .02em;
}
.badge-active   { background: #d4edda; color: #155724; }
.badge-inactive { background: #f8d7da; color: #721c24; }

/* ── Store cards ───────────────────────────────────────── */
.store-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.2rem;
    margin-bottom: 2rem;
}
.store-card {
    background: #fff;
    border: 1px solid #e0e4ef;
    border-radius: 10px;
    padding: 1.2rem 1.4rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    transition: box-shadow .2s;
}
.store-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,.12); }
.store-card h4 { margin: 0 0 0.3rem; color: #1a1a2e; font-size: 1rem; }
.store-card .store-address { font-size: 0.82rem; color: #777; margin: 0 0 0.8rem; }
.store-card .camera-chip {
    display: inline-flex; align-items: center; gap: 0.3rem;
    background: #eef2ff; color: #3949ab;
    border-radius: 6px; padding: .25rem .6rem;
    font-size: 0.82rem; font-weight: 600;
}
.store-card .camera-list-mini { list-style: none; padding: 0; margin: 0.6rem 0 0; }
.store-card .camera-list-mini li {
    font-size: 0.82rem; color: #444;
    padding: 0.15rem 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex; justify-content: space-between;
}
.store-card .camera-list-mini li:last-child { border-bottom: none; }

/* ── Camera table ──────────────────────────────────────── */
.table-wrapper { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
thead th { background: #1a1a2e; color: #fff; padding: .65rem .9rem; text-align: left; font-size: 0.78rem; text-transform: uppercase; letter-spacing: .04em; }
tbody tr:nth-child(even) { background: #f8f9fc; }
tbody td { padding: .6rem .9rem; border-bottom: 1px solid #eaeaea; vertical-align: middle; }
tbody tr:hover { background: #eef2ff; }

/* ── Map ──────────────────────────────────────────────── */
#dashboard-map {
    height: 420px;
    border-radius: 10px;
    border: 1px solid #dde;
    margin-bottom: 2rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.1);
}

/* ── About ──────────────────────────────────────────────── */
.about-card {
    background: linear-gradient(135deg, #f4f6fb 0%, #e8ecf8 100%);
    border-radius: 10px;
    padding: 2rem 2.2rem;
    margin-bottom: 2rem;
    border: 1px solid #dde4f5;
}
.about-card h3 { color: #1a1a2e; margin-top: 0; }
.about-card p  { color: #444; line-height: 1.7; }
.about-card ul { color: #444; line-height: 1.9; padding-left: 1.4rem; }

/* ── No data placeholder ──────────────────────────────── */
.empty-state {
    text-align: center; padding: 2.5rem; color: #999;
    background: #fafafa; border-radius: 10px;
    border: 2px dashed #e0e0e0;
    margin-bottom: 1.5rem;
}
</style>
<?php $this->end() ?>

<div class="dashboard">

    <!-- ── Hero ──────────────────────────────────────────── -->
    <div class="dashboard-hero">
        <h1>📡 Surveillance Dashboard</h1>
        <p>Real-time overview of stores, cameras and system health</p>
    </div>

    <!-- ── Stat Cards ─────────────────────────────────────── -->
    <div class="stat-grid">
        <div class="stat-card card-stores">
            <span class="stat-icon">🏪</span>
            <span class="stat-value"><?= $totalStores ?></span>
            <span class="stat-label">Total Stores</span>
        </div>
        <div class="stat-card card-cameras">
            <span class="stat-icon">📷</span>
            <span class="stat-value"><?= $totalCameras ?></span>
            <span class="stat-label">Total Cameras</span>
        </div>
        <div class="stat-card card-active">
            <span class="stat-icon">✅</span>
            <span class="stat-value"><?= $activeCameras ?></span>
            <span class="stat-label">Active Cameras</span>
        </div>
        <div class="stat-card card-inactive">
            <span class="stat-icon">⚠️</span>
            <span class="stat-value"><?= $inactiveCameras ?></span>
            <span class="stat-label">Inactive Cameras</span>
        </div>
    </div>

    <!-- ── Camera Search & Filter ─────────────────────────── -->
    <h2 class="section-heading">Camera List</h2>

    <?= $this->Form->create(null, [
        'type' => 'get',
        'url'  => ['controller' => 'Dashboard', 'action' => 'index'],
        'class' => 'filter-bar',
    ]) ?>
        <div class="filter-group">
            <label for="q">Search</label>
            <?= $this->Form->control('q', [
                'label'       => false,
                'type'        => 'text',
                'value'       => $searchQuery,
                'placeholder' => 'Name, IP address, location…',
                'id'          => 'q',
            ]) ?>
        </div>
        <div class="filter-group">
            <label for="status">Status</label>
            <?= $this->Form->control('status', [
                'label'   => false,
                'type'    => 'select',
                'options' => ['all' => 'All statuses', 'active' => 'Active', 'inactive' => 'Inactive'],
                'value'   => $statusFilter,
                'id'      => 'status',
            ]) ?>
        </div>
        <?php if (!empty($storeList)): ?>
        <div class="filter-group">
            <label for="store_id">Store</label>
            <?= $this->Form->control('store_id', [
                'label'   => false,
                'type'    => 'select',
                'options' => ['' => 'All stores'] + $storeList,
                'value'   => $storeFilter,
                'id'      => 'store_id',
            ]) ?>
        </div>
        <?php endif ?>
        <div class="filter-actions">
            <?= $this->Form->button('🔍 Search', ['class' => 'button', 'type' => 'submit']) ?>
            <?= $this->Html->link('✕ Clear', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'button button-outline']) ?>
        </div>
    <?= $this->Form->end() ?>

    <?php if (empty($camerasArray)): ?>
        <div class="empty-state">
            <p>No cameras match your search criteria.</p>
        </div>
    <?php else: ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>IP Address</th>
                    <th>Location</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($camerasArray as $camera): ?>
                <tr>
                    <td><?= $camera->id ?></td>
                    <td><?= h($camera->name) ?></td>
                    <td><code><?= h($camera->ip_address) ?></code></td>
                    <td><?= h($camera->location ?? '—') ?></td>
                    <td><?= h($camera->store->name ?? '—') ?></td>
                    <td>
                        <?php if ($camera->status): ?>
                            <span class="badge badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge badge-inactive">Inactive</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?= $this->Html->link('View', ['controller' => 'Cameras', 'action' => 'view', $camera->id]) ?>
                        <?= $this->Html->link('Edit', ['controller' => 'Cameras', 'action' => 'edit', $camera->id]) ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php endif ?>

    <!-- ── Stores Overview ────────────────────────────────── -->
    <h2 class="section-heading">Stores Overview</h2>

    <?php if (empty($storesArray)): ?>
        <div class="empty-state">
            <p>No stores have been added yet. <a href="#">Add the first store</a> to get started.</p>
        </div>
    <?php else: ?>
    <div class="store-grid">
        <?php foreach ($storesArray as $store): ?>
        <div class="store-card">
            <h4>🏪 <?= h($store->name) ?></h4>
            <?php if ($store->address): ?>
                <p class="store-address">📍 <?= h($store->address) ?></p>
            <?php endif ?>
            <span class="camera-chip">📷 <?= count($store->cameras) ?> camera<?= count($store->cameras) !== 1 ? 's' : '' ?></span>
            <?php if (!empty($store->cameras)): ?>
            <ul class="camera-list-mini">
                <?php foreach (array_slice($store->cameras, 0, 5) as $cam): ?>
                <li>
                    <span><?= h($cam->name) ?></span>
                    <?php if ($cam->status): ?>
                        <span class="badge badge-active">Active</span>
                    <?php else: ?>
                        <span class="badge badge-inactive">Inactive</span>
                    <?php endif ?>
                </li>
                <?php endforeach ?>
                <?php if (count($store->cameras) > 5): ?>
                <li style="color:#999;font-style:italic;">…and <?= count($store->cameras) - 5 ?> more</li>
                <?php endif ?>
            </ul>
            <?php endif ?>
        </div>
        <?php endforeach ?>
    </div>
    <?php endif ?>

    <!-- ── Map ────────────────────────────────────────────── -->
    <h2 class="section-heading">Store Map</h2>
    <div id="dashboard-map"></div>

    <!-- ── About ──────────────────────────────────────────── -->
    <h2 class="section-heading">About</h2>
    <div class="about-card">
        <h3>📡 Surveillance Management System</h3>
        <p>
            This platform provides centralised management of surveillance cameras across multiple store locations.
            Administrators can register stores, assign cameras to each location, monitor their real-time status,
            and view all assets on an interactive map.
        </p>
        <ul>
            <li><strong>Stores</strong> — physical locations each with a geo-coordinate for map plotting</li>
            <li><strong>Cameras</strong> — IP cameras tracked by name, IP address, location and active/inactive status</li>
            <li><strong>Dashboard</strong> — instant health overview with search, filter and map visualisation</li>
        </ul>
        <p>
            Built with <strong>CakePHP 5</strong> · <strong>PHP 8.3</strong> · <strong>MySQL 8</strong> ·
            <strong>Leaflet.js</strong> maps · Deployed via <strong>Docker</strong>.
        </p>
    </div>

</div>

<!-- ── Leaflet.js ────────────────────────────────────────── -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    var map = L.map('dashboard-map').setView([13.7563, 100.5018], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var storeData = <?= json_encode(
        array_map(function ($s) {
            return [
                'name'    => $s->name,
                'address' => $s->address ?? '',
                'lat'     => $s->latitude,
                'lng'     => $s->longitude,
                'cameras' => count($s->cameras),
                'active'  => count(array_filter($s->cameras, fn($c) => $c->status)),
            ];
        }, $storesArray),
        JSON_HEX_TAG | JSON_HEX_QUOT
    ) ?>;

    var bounds = [];

    storeData.forEach(function (s) {
        if (s.lat === null || s.lng === null) { return; }

        var popup = '<strong>\uD83C\uDFEA ' + s.name + '</strong>';
        if (s.address) { popup += '<br><small>\uD83D\uDCCD ' + s.address + '</small>'; }
        popup += '<br>\uD83D\uDCF7 ' + s.cameras + ' camera' + (s.cameras !== 1 ? 's' : '');
        popup += ' &middot; \u2705 ' + s.active + ' active';

        L.marker([s.lat, s.lng]).addTo(map).bindPopup(popup);
        bounds.push([s.lat, s.lng]);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40] });
    }
}());
</script>
