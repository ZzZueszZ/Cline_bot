<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    /**
     * Index method — list all categories.
     *
     * @return void
     */
    public function index(): void
    {
        $categories = $this->Categories->find()->all();
        $this->set(compact('categories'));
    }

    /**
     * View method — display a single category.
     *
     * @param int $id Category id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id): void
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Cameras'],
        ]);
        $this->set(compact('category'));
    }

    /**
     * Add method — create a new category.
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): Response|null
    {
        $category = $this->Categories->newEmptyEntity();

        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

        $this->set(compact('category'));

        return null;
    }

    /**
     * Edit method — update an existing category.
     *
     * @param int $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(int $id): Response|null
    {
        $category = $this->Categories->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

        $this->set(compact('category'));

        return null;
    }

    /**
     * Delete method — remove a category.
     *
     * @param int $id Category id.
     * @return \Cake\Http\Response Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(int $id): Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $category = $this->Categories->get($id);

        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
