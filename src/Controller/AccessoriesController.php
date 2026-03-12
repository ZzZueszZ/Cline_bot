<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Accessories Controller
 *
 * @property \App\Model\Table\AccessoriesTable $Accessories
 * @method \App\Model\Entity\Accessory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccessoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cameras'],
            'order' => ['Accessories.name' => 'ASC'],
        ];
        $accessories = $this->paginate($this->Accessories);

        $this->set(compact('accessories'));
    }

    /**
     * View method
     *
     * @param string|null $id Accessory id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accessory = $this->Accessories->get($id, [
            'contain' => ['Cameras'],
        ]);

        $this->set(compact('accessory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accessory = $this->Accessories->newEmptyEntity();
        if ($this->request->is('post')) {
            $accessory = $this->Accessories->patchEntity($accessory, $this->request->getData());
            if ($this->Accessories->save($accessory)) {
                $this->Flash->success(__('The accessory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessory could not be saved. Please, try again.'));
        }

        $cameras = $this->Accessories->Cameras->find('list', ['limit' => 200])->all();
        $this->set(compact('accessory', 'cameras'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accessory id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accessory = $this->Accessories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accessory = $this->Accessories->patchEntity($accessory, $this->request->getData());
            if ($this->Accessories->save($accessory)) {
                $this->Flash->success(__('The accessory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessory could not be saved. Please, try again.'));
        }

        $cameras = $this->Accessories->Cameras->find('list', ['limit' => 200])->all();
        $this->set(compact('accessory', 'cameras'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accessory id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accessory = $this->Accessories->get($id);
        if ($this->Accessories->delete($accessory)) {
            $this->Flash->success(__('The accessory has been deleted.'));
        } else {
            $this->Flash->error(__('The accessory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
