<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CamerasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CamerasTable Test Case
 */
class CamerasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CamerasTable
     */
    protected CamerasTable $Cameras;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
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
        $config = $this->getTableLocator()->exists('Cameras') ? [] : ['className' => CamerasTable::class];
        $this->Cameras = $this->getTableLocator()->get('Cameras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Cameras);
        parent::tearDown();
    }

    /**
     * Test validationDefault — name is required.
     */
    public function testValidationRequiresName(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => '',
            'ip_address' => '192.168.1.1',
            'status' => 1,
        ]);
        $this->assertArrayHasKey('name', $camera->getErrors());
    }

    /**
     * Test validationDefault — name max length 100.
     */
    public function testValidationNameMaxLength(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => str_repeat('a', 101),
            'ip_address' => '192.168.1.1',
            'status' => 1,
        ]);
        $this->assertArrayHasKey('name', $camera->getErrors());
    }

    /**
     * Test validationDefault — ip_address is required.
     */
    public function testValidationRequiresIpAddress(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => '',
            'status' => 1,
        ]);
        $this->assertArrayHasKey('ip_address', $camera->getErrors());
    }

    /**
     * Test validationDefault — invalid IP address string fails.
     */
    public function testValidationInvalidIpAddress(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => 'not-an-ip',
            'status' => 1,
        ]);
        $this->assertArrayHasKey('ip_address', $camera->getErrors());
    }

    /**
     * Test validationDefault — valid IPv4 passes.
     */
    public function testValidationValidIpv4(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => '10.0.0.1',
            'status' => 1,
        ]);
        $this->assertArrayNotHasKey('ip_address', $camera->getErrors());
    }

    /**
     * Test validationDefault — valid IPv6 passes.
     */
    public function testValidationValidIpv6(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            'status' => 1,
        ]);
        $this->assertArrayNotHasKey('ip_address', $camera->getErrors());
    }

    /**
     * Test validationDefault — location is optional.
     */
    public function testValidationLocationOptional(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => '192.168.1.1',
            'status' => 1,
        ]);
        $this->assertArrayNotHasKey('location', $camera->getErrors());
    }

    /**
     * Test validationDefault — status must be boolean.
     */
    public function testValidationStatusBoolean(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'Test Camera',
            'ip_address' => '192.168.1.1',
            'status' => 'not-a-bool',
        ]);
        $this->assertArrayHasKey('status', $camera->getErrors());
    }

    /**
     * Test that a fully valid entity saves successfully.
     */
    public function testSaveValidRecord(): void
    {
        $camera = $this->Cameras->newEntity([
            'name' => 'New Camera',
            'ip_address' => '10.10.10.10',
            'location' => 'Server Room',
            'status' => 1,
        ]);
        $result = $this->Cameras->save($camera);
        $this->assertNotFalse($result);
        $this->assertNotEmpty($result->id);
    }
}
