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

$storesArray  = $stores->toArray();
$camerasArray = $cameras->toArray();
?>
<?php $this->start('css') ?>
<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }
    .stat-card-glow {
        position: relative;
        overflow: hidden;
    }
    .stat-card-glow::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    #dashboard-map {
        height: 450px;
        border-radius: 1rem;
        z-index: 1;
    }
    .leaflet-container {
        background: #0f172a !important;
    }
    .badge-vibrant-active {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    .badge-vibrant-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    /* Override Milligram defaults that might clash */
    input, select, textarea {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }
    input:focus, select:focus {
        border-color: #3b82f6 !important;
        outline: none !important;
    }
    button.button, .button {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        text-transform: none !important;
        height: auto !important;
        padding: 0.75rem 1.5rem !important;
        font-weight: 600 !important;
    }
    .button-outline {
        background-color: transparent !important;
        color: #3b82f6 !important;
    }
</style>
<?php $this->end() ?>

<div class="space-y-12">
    <!-- ── Hero Section ── -->
    <div class="relative rounded-2xl overflow-hidden p-8 md:p-12 mb-8">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 z-0"></div>
        <div class="absolute inset-0 backdrop-blur-3xl z-0"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    System <span class="text-blue-500">Overview</span>
                </h1>
                <p class="text-slate-400 text-lg max-w-xl">
                    Real-time monitoring and management of your surveillance network across all locations.
                </p>
            </div>
            <div class="flex gap-4">
                <div class="glass-card rounded-xl p-4 flex flex-col items-center justify-center min-w-[120px]">
                    <span class="text-3xl font-bold text-white"><?= $totalCameras ?></span>
                    <span class="text-xs text-slate-500 uppercase font-semibold">Total Nodes</span>
                </div>
                <div class="glass-card rounded-xl p-4 flex flex-col items-center justify-center min-w-[120px] border-green-500/30">
                    <span class="text-3xl font-bold text-green-400"><?= $activeCameras ?></span>
                    <span class="text-xs text-green-500/70 uppercase font-semibold">Online</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Stats Grid ── -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card stat-card-glow rounded-2xl p-6 transition-all hover:translate-y-[-4px] group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Stores</p>
                    <h3 class="text-3xl font-bold text-white"><?= $totalStores ?></h3>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-xl">
                    <i data-lucide="store" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <i data-lucide="info" class="w-3 h-3 mr-1 text-blue-500"></i>
                Registered locations
            </div>
        </div>

        <div class="glass-card stat-card-glow rounded-2xl p-6 transition-all hover:translate-y-[-4px] group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Cameras</p>
                    <h3 class="text-3xl font-bold text-white"><?= $totalCameras ?></h3>
                </div>
                <div class="bg-indigo-500/10 p-3 rounded-xl">
                    <i data-lucide="camera" class="w-6 h-6 text-indigo-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <i data-lucide="info" class="w-3 h-3 mr-1 text-indigo-500"></i>
                Total assets
            </div>
        </div>

        <div class="glass-card stat-card-glow rounded-2xl p-6 transition-all hover:translate-y-[-4px] group border-green-500/20">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Active</p>
                    <h3 class="text-3xl font-bold text-green-400"><?= $activeCameras ?></h3>
                </div>
                <div class="bg-green-500/10 p-3 rounded-xl">
                    <i data-lucide="activity" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-green-500/50">
                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                Normal operation
            </div>
        </div>

        <div class="glass-card stat-card-glow rounded-2xl p-6 transition-all hover:translate-y-[-4px] group border-red-500/20">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Inactive</p>
                    <h3 class="text-3xl font-bold text-red-400"><?= $inactiveCameras ?></h3>
                </div>
                <div class="bg-red-500/10 p-3 rounded-xl">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-red-500/50">
                <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                Attention required
            </div>
        </div>
    </div>

    <!-- ── Camera Search & Filters ── -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="list" class="w-6 h-6 text-blue-500"></i>
            <h2 class="text-xl font-bold text-white">Device Directory</h2>
        </div>

        <?= $this->Form->create(null, [
            'type' => 'get',
            'url'  => ['controller' => 'Dashboard', 'action' => 'index'],
            'class' => 'grid grid-cols-1 md:grid-cols-4 items-end gap-4',
        ]) ?>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Search Devices</label>
                <?= $this->Form->control('q', [
                    'label'       => false,
                    'type'        => 'text',
                    'value'       => $searchQuery,
                    'placeholder' => 'Name, IP, location...',
                    'class'       => 'w-full px-4 py-2 rounded-lg bg-slate-900/50 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all',
                ]) ?>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Status</label>
                <?= $this->Form->control('status', [
                    'label'   => false,
                    'type'    => 'select',
                    'options' => ['all' => 'All Statuses', 'active' => 'Active', 'inactive' => 'Inactive'],
                    'value'   => $statusFilter,
                    'class'   => 'w-full px-4 py-2 rounded-lg bg-slate-900/50 border border-slate-700 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all',
                ]) ?>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i> Filter
                </button>
                <?= $this->Html->link('<i data-lucide="rotate-ccw" class="w-4 h-4"></i>', ['action' => 'index'], ['escape' => false, 'class' => 'bg-slate-700 hover:bg-slate-600 text-white font-bold py-2 px-3 rounded-lg transition-colors flex items-center justify-center']) ?>
            </div>
        <?= $this->Form->end() ?>

        <div class="mt-8 overflow-hidden rounded-xl border border-slate-700/50">
            <?php if (empty($camerasArray)): ?>
                <div class="text-center py-12 bg-slate-800/20">
                    <i data-lucide="search-x" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
                    <p class="text-slate-500">No cameras found matching your criteria.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800/50 text-slate-400 text-xs uppercase font-bold tracking-wider">
                                <th class="px-6 py-4">Device</th>
                                <th class="px-6 py-4">IP Address</th>
                                <th class="px-6 py-4">Location</th>
                                <th class="px-6 py-4">Store</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            <?php foreach ($camerasArray as $camera): ?>
                            <tr class="hover:bg-blue-500/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-slate-700/50 rounded-lg group-hover:bg-blue-500/20 transition-colors">
                                            <i data-lucide="camera" class="w-4 h-4 text-slate-400 group-hover:text-blue-400"></i>
                                        </div>
                                        <span class="font-medium text-white"><?= h($camera->name) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-blue-400/80 font-mono text-xs"><?= h($camera->ip_address) ?></code>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-sm">
                                    <?= h($camera->location ?? 'Unspecified') ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-300 text-sm"><?= h($camera->store->name ?? '—') ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($camera->status): ?>
                                        <span class="badge-vibrant-active px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Online
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-vibrant-inactive px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Offline
                                        </span>
                                    <?php endif ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <?= $this->Html->link('<i data-lucide="eye" class="w-4 h-4"></i>', ['controller' => 'Cameras', 'action' => 'view', $camera->id], ['escape' => false, 'title' => 'View', 'class' => 'p-2 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-lg transition-all']) ?>
                                        <?= $this->Html->link('<i data-lucide="edit-3" class="w-4 h-4"></i>', ['controller' => 'Cameras', 'action' => 'edit', $camera->id], ['escape' => false, 'title' => 'Edit', 'class' => 'p-2 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-lg transition-all']) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- ── Stores Grid ── -->
    <div>
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <i data-lucide="layout-grid" class="w-6 h-6 text-purple-500"></i>
                <h2 class="text-2xl font-bold text-white">Store Infrastructure</h2>
            </div>
            <span class="text-slate-500 text-sm font-medium"><?= count($storesArray) ?> Locations</span>
        </div>

        <?php if (empty($storesArray)): ?>
            <div class="glass-card rounded-2xl p-12 text-center">
                <p class="text-slate-500">No stores available yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($storesArray as $store): ?>
                <div class="glass-card rounded-2xl p-6 border-l-4 border-purple-500/30 hover:border-purple-500 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-purple-500/10 rounded-xl">
                            <i data-lucide="store" class="w-6 h-6 text-purple-500"></i>
                        </div>
                        <div class="text-right text-[10px] font-black text-slate-600 group-hover:text-purple-500/50 uppercase transition-colors">
                            ID #<?= $store->id ?>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2"><?= h($store->name) ?></h4>
                    <?php if ($store->address): ?>
                        <p class="text-slate-400 text-sm flex items-start gap-2 mb-6 min-h-[40px]">
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-600 flex-shrink-0 mt-0.5"></i>
                            <?= h($store->address) ?>
                        </p>
                    <?php endif ?>

                    <div class="pt-6 border-t border-slate-800 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                             <div class="flex -space-x-2">
                                <?php foreach (array_slice($store->cameras, 0, 3) as $cam): ?>
                                    <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-slate-800 flex items-center justify-center text-[10px] font-bold <?= $cam->status ? 'text-green-400' : 'text-slate-600' ?>">
                                        <i data-lucide="camera" class="w-3 h-3"></i>
                                    </div>
                                <?php endforeach ?>
                             </div>
                             <?php if (count($store->cameras) > 3): ?>
                                <span class="text-xs text-slate-500">+<?= count($store->cameras) - 3 ?></span>
                             <?php endif ?>
                        </div>
                        <div class="flex items-center gap-1.5 text-blue-400 bg-blue-400/5 px-2 py-1 rounded-md text-xs font-bold uppercase tracking-wider">
                            <i data-lucide="shield" class="w-3 h-3"></i>
                            <?= count($store->cameras) ?> Nodes
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

    <!-- ── Map Visualization ── -->
    <div class="glass-card rounded-3xl p-2 overflow-hidden">
        <div id="dashboard-map"></div>
    </div>

    <!-- ── Technical Overview ── -->
    <div class="relative rounded-3xl overflow-hidden p-8 border border-white/5">
        <div class="absolute inset-0 bg-slate-800/30 z-0"></div>
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h3 class="text-3xl font-bold text-white mb-6">Network Intelligence</h3>
                <p class="text-slate-400 leading-relaxed mb-6">
                    Our centralised surveillance hub integrates disparate IP camera networks into a unified management plane. Monitor status, geographical distribution, and technical telemetry in real-time.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 text-slate-300">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                            <i data-lucide="globe" class="w-5 h-5 text-blue-500"></i>
                        </div>
                        <div>
                            <span class="block font-bold">Geospatial Awareness</span>
                            <span class="text-xs text-slate-500">Leaflet.js powered location mapping</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-slate-300">
                        <div class="w-10 h-10 rounded-full bg-purple-500/10 flex items-center justify-center border border-purple-500/20">
                            <i data-lucide="zap" class="w-5 h-5 text-purple-500"></i>
                        </div>
                        <div>
                            <span class="block font-bold">Reactive Monitoring</span>
                            <span class="text-xs text-slate-500">Instant offline/online state detection</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-black/20 rounded-2xl p-6 border border-white/5 font-mono text-xs text-blue-400 space-y-2">
                <div class="flex gap-4">
                    <span class="text-slate-600">Framework</span>
                    <span>CakePHP 5.x</span>
                </div>
                <div class="flex gap-4">
                    <span class="text-slate-600">Environment</span>
                    <span>PHP 8.3 &bull; MySQL 8</span>
                </div>
                <div class="flex gap-4">
                    <span class="text-slate-600">Visualization</span>
                    <span>Tailwind CSS &bull; Leaflet</span>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 text-slate-500 text-center">
                    SurveillanceHub v2.0 Ready
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Leaflet Scripts ── -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    // Modern Dark Map Theme
    var map = L.map('dashboard-map', { zoomControl: false }).setView([13.7563, 100.5018], 5);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
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
    var customIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='background-color:#3b82f6; width:12px; height:12px; border-radius:50%; border:2px solid white; box-shadow: 0 0 10px #3b82f6;'></div>",
        iconSize: [12, 12],
        iconAnchor: [6, 6]
    });

    storeData.forEach(function (s) {
        if (s.lat === null || s.lng === null) { return; }

        var popupContent = `
            <div class="p-2 font-sans bg-slate-900 text-white rounded-lg">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <i data-lucide="store" class="w-4 h-4 text-blue-500"></i> ${s.name}
                </div>
                <div class="text-[10px] text-slate-400 mb-2">${s.address}</div>
                <div class="flex justify-between text-xs border-t border-slate-800 pt-2">
                    <span class="flex items-center gap-1"><i data-lucide="camera" class="w-3 h-3"></i> ${s.cameras}</span>
                    <span class="flex items-center gap-1 text-green-400"><i data-lucide="activity" class="w-3 h-3"></i> ${s.active}</span>
                </div>
            </div>
        `;

        L.marker([s.lat, s.lng], { icon: customIcon }).addTo(map).bindPopup(popupContent, {
            className: 'modern-popup',
            maxWidth: 250
        });
        bounds.push([s.lat, s.lng]);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [80, 80] });
    }

    // Refresh lucide icons in popups when opened
    map.on('popupopen', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
}());
</script>

<style>
/* Leaflet Popup Styling */
.modern-popup .leaflet-popup-content-wrapper {
    background: #0f172a !important;
    color: white !important;
    border-radius: 12px !important;
    padding: 0 !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}
.modern-popup .leaflet-popup-content {
    margin: 0 !important;
    line-height: 1.4 !important;
}
.modern-popup .leaflet-popup-tip {
    background: #0f172a !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}
</style>
