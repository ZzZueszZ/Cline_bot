<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AccessoriesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AccessoriesController Test Case
 *
 * @uses \App\Controller\AccessoriesController
 */
class AccessoriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Accessories',
        'app.Cameras',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AccessoriesController::index()
     */
    public function testIndex(): void
    {
        $this->get('/accessories');
        $this->assertResponseOk();
        $this->assertResponseContains('Accessories');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AccessoriesController::view()
     */
    public function testView(): void
    {
        $this->get('/accessories/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Cable');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AccessoriesController::add()
     */
    public function testAdd(): void
    {
        $this->get('/accessories/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Accessory');

        // Test successful add
        $this->enableCsrfToken();
        $this->post('/accessories/add', [
            'name' => 'New Accessory',
            'type' => 'Test Type',
            'description' => 'Test description',
            'status' => 'Available',
            'purchase_date' => '2024-01-01',
            'warranty_expiry' => '2025-01-01',
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
    }

    /**
     * Test add method with validation errors
     *
     * @return void
     */
    public function testAddValidationErrors(): void
    {
        $this->enableCsrfToken();
        $this->post('/accessories/add', [
            'name' => '', // Empty name should fail
            'type' => '', // Empty type should fail
            'status' => 'Invalid Status', // Invalid status should fail
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('The accessory could not be saved');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AccessoriesController::edit()
     */
    public function testEdit(): void
    {
        $this->get('/accessories/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Edit Accessory');

        // Test successful edit
        $this->enableCsrfToken();
        $this->post('/accessories/edit/1', [
            'name' => 'Updated Accessory',
            'type' => 'Updated Type',
            'description' => 'Updated description',
            'status' => 'In Use',
            'assigned_camera_id' => 1,
            'purchase_date' => '2024-01-01',
            'warranty_expiry' => '2025-01-01',
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AccessoriesController::delete()
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->delete('/accessories/delete/1');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
    }

    /**
     * Test delete method with non-existent accessory
     *
     * @return void
     */
    public function testDeleteNonExistent(): void
    {
        $this->enableCsrfToken();
        $this->delete('/accessories/delete/999');
        $this->assertResponseCode(404);
    }
}
