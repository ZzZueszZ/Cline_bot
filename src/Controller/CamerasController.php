<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Cameras Controller
 *
 * @property \App\Model\Table\CamerasTable $Cameras
 */
class CamerasController extends AppController
{
    /**
     * Index method — list all cameras.
     *
     * @return void
     */
    public function index(): void
    {
        $cameras = $this->Cameras->find()
            ->contain(['Stores', 'Categories'])
            ->all();
        $this->set(compact('cameras'));
    }

    /**
     * View method — display a single camera.
     *
     * @param int $id Camera id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id): void
    {
        $camera = $this->Cameras->get($id);
        $this->set(compact('camera'));
    }

    /**
     * Add method — create a new camera.
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): Response|null
    {
        $camera = $this->Cameras->newEmptyEntity();

        if ($this->request->is('post')) {
            $camera = $this->Cameras->patchEntity($camera, $this->request->getData());

            if ($this->Cameras->save($camera)) {
                $this->Flash->success(__('The camera has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The camera could not be saved. Please, try again.'));
        }

        $categories = $this->Cameras->Categories->find('list', ['limit' => 200]);
        $stores = $this->Cameras->Stores->find('list', ['limit' => 200]);
        $this->set(compact('camera', 'categories', 'stores'));

        return null;
    }

    /**
     * Edit method — update an existing camera.
     *
     * @param int $id Camera id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(int $id): Response|null
    {
        $camera = $this->Cameras->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $camera = $this->Cameras->patchEntity($camera, $this->request->getData());

            if ($this->Cameras->save($camera)) {
                $this->Flash->success(__('The camera has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The camera could not be saved. Please, try again.'));
        }

        $categories = $this->Cameras->Categories->find('list', ['limit' => 200]);
        $stores = $this->Cameras->Stores->find('list', ['limit' => 200]);
        $this->set(compact('camera', 'categories', 'stores'));

        return null;
    }

    /**
     * Delete method — remove a camera.
     *
     * @param int $id Camera id.
     * @return \Cake\Http\Response Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(int $id): Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $camera = $this->Cameras->get($id);

        if ($this->Cameras->delete($camera)) {
            $this->Flash->success(__('The camera has been deleted.'));
        } else {
            $this->Flash->error(__('The camera could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
