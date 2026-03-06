<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Stores Controller
 *
 * @property \App\Model\Table\StoresTable $Stores
 */
class StoresController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $stores = $this->paginate($this->Stores);
        $this->set(compact('stores'));
    }

    /**
     * View method
     *
     * @param int $id Store id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id): void
    {
        $store = $this->Stores->get($id, contain: ['Cameras']);
        $this->set(compact('store'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): Response|null
    {
        $store = $this->Stores->newEmptyEntity();
        if ($this->request->is('post')) {
            $store = $this->Stores->patchEntity($store, $this->request->getData());
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('The store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store could not be saved. Please, try again.'));
        }
        $this->set(compact('store'));

        return null;
    }

    /**
     * Edit method
     *
     * @param int $id Store id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(int $id): Response|null
    {
        $store = $this->Stores->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $store = $this->Stores->patchEntity($store, $this->request->getData());
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('The store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store could not be saved. Please, try again.'));
        }
        $this->set(compact('store'));

        return null;
    }

    /**
     * Delete method
     *
     * @param int $id Store id.
     * @return \Cake\Http\Response Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(int $id): Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $store = $this->Stores->get($id);
        if ($this->Stores->delete($store)) {
            $this->Flash->success(__('The store has been deleted.'));
        } else {
            $this->Flash->error(__('The store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
