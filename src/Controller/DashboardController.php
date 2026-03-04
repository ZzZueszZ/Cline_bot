<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Dashboard Controller — central overview page.
 *
 * @property \App\Model\Table\StoresTable $Stores
 * @property \App\Model\Table\CamerasTable $Cameras
 */
class DashboardController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Stores = TableRegistry::getTableLocator()->get('Stores');
        $this->Cameras = TableRegistry::getTableLocator()->get('Cameras');
    }

    /**
     * Index method — overview dashboard with stats, camera search, map and about.
     *
     * @return void
     */
    public function index(): void
    {
        // --- Stats ---
        $totalStores = $this->Stores->find()->count();
        $totalCameras = $this->Cameras->find()->count();
        $activeCameras = $this->Cameras->find()->where(['status' => true])->count();
        $inactiveCameras = $totalCameras - $activeCameras;

        // --- Stores with cameras for the store-cameras section ---
        $stores = $this->Stores->find()
            ->contain(['Cameras'])
            ->orderBy(['Stores.name' => 'ASC'])
            ->all();

        // --- Filtered camera list ---
        $searchQuery = $this->request->getQuery('q', '');
        $statusFilter = $this->request->getQuery('status', 'all');
        $storeFilter = $this->request->getQuery('store_id', '');

        $cameraQuery = $this->Cameras->find()
            ->contain(['Stores'])
            ->orderBy(['Cameras.name' => 'ASC']);

        if (!empty($searchQuery)) {
            $cameraQuery->where([
                'OR' => [
                    'Cameras.name LIKE' => '%' . $searchQuery . '%',
                    'Cameras.location LIKE' => '%' . $searchQuery . '%',
                    'Cameras.ip_address LIKE' => '%' . $searchQuery . '%',
                ],
            ]);
        }

        if ($statusFilter === 'active') {
            $cameraQuery->where(['Cameras.status' => true]);
        } elseif ($statusFilter === 'inactive') {
            $cameraQuery->where(['Cameras.status' => false]);
        }

        if (!empty($storeFilter) && is_numeric($storeFilter)) {
            $cameraQuery->where(['Cameras.store_id' => (int)$storeFilter]);
        }

        $cameras = $cameraQuery->all();

        // --- Store list for the filter dropdown ---
        $storeList = $this->Stores->find('list', keyField: 'id', valueField: 'name')
            ->orderBy(['name' => 'ASC'])
            ->toArray();

        $this->set(compact(
            'totalStores',
            'totalCameras',
            'activeCameras',
            'inactiveCameras',
            'stores',
            'cameras',
            'storeList',
            'searchQuery',
            'statusFilter',
            'storeFilter',
        ));
    }
}
