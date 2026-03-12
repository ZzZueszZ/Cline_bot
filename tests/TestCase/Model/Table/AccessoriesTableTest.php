<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessoriesTable;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Model\Table\AccessoriesTable Test Case
 */
class AccessoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessoriesTable
     */
    protected $Accessories;

    /**
     * Fixtures
     */
    protected $fixtures = [
        'app.Accessories',
        'app.Cameras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Accessories') ? [] : ['className' => AccessoriesTable::class];
        $this->Accessories = TableRegistry::getTableLocator()->get('Accessories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Accessories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AccessoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $accessory = $this->Accessories->newEmptyEntity();
        $accessory = $this->Accessories->patchEntity($accessory, [
            'name' => 'Test Accessory',
            'type' => 'Test Type',
            'description' => 'Test description',
            'status' => 'Available',
            'assigned_camera_id' => 1,
            'purchase_date' => '2024-01-01',
            'warranty_expiry' => '2025-01-01',
        ]);

        $this->assertEmpty($accessory->getErrors());
    }

    /**
     * Test validationDefault method with invalid data
     *
     * @return void
     */
    public function testValidationDefaultInvalid(): void
    {
        $accessory = $this->Accessories->newEmptyEntity();
        $accessory = $this->Accessories->patchEntity($accessory, [
            'name' => '', // Empty name should fail
            'type' => '', // Empty type should fail
            'status' => 'Invalid Status', // Invalid status should fail
            'warranty_expiry' => '2023-01-01', // Before purchase_date
        ]);

        $errors = $accessory->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('type', $errors);
        $this->assertArrayHasKey('status', $errors);
        $this->assertArrayHasKey('warranty_expiry', $errors);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // Test that accessories with status "In Use" must have assigned_camera_id
        $accessory = $this->Accessories->newEmptyEntity();
        $accessory = $this->Accessories->patchEntity($accessory, [
            'name' => 'Test Accessory',
            'type' => 'Test Type',
            'status' => 'In Use',
            'assigned_camera_id' => null, // This should fail
        ]);

        $this->assertNotEmpty($accessory->getErrors());
        $this->assertArrayHasKey('status', $accessory->getErrors());
    }

    /**
     * Test buildRules with valid data
     *
     * @return void
     */
    public function testBuildRulesValid(): void
    {
        // Test that accessories with status "In Use" and assigned_camera_id pass
        $accessory = $this->Accessories->newEmptyEntity();
        $accessory = $this->Accessories->patchEntity($accessory, [
            'name' => 'Test Accessory',
            'type' => 'Test Type',
            'status' => 'In Use',
            'assigned_camera_id' => 1, // Valid camera ID
        ]);

        $this->assertEmpty($accessory->getErrors());
    }

    /**
     * Test belongsTo relationship with Cameras
     *
     * @return void
     */
    public function testBelongsToCameras(): void
    {
        $accessory = $this->Accessories->get(2, [
            'contain' => ['Cameras'],
        ]);

        $this->assertNotEmpty($accessory->camera);
        $this->assertEquals(1, $accessory->assigned_camera_id);
    }
}
