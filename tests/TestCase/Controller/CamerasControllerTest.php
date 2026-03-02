<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CamerasController Test Case
 *
 * @uses \App\Controller\CamerasController
 */
class CamerasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Cameras',
    ];

    /**
     * setUp — disable CSRF for all integration tests.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test index displays cameras from fixture.
     */
    public function testIndex(): void
    {
        $this->get('/cameras');
        $this->assertResponseOk();
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseContains('Parking Lot Camera');
        $this->assertResponseContains('Lobby Camera');
    }

    /**
     * Test view displays a single camera.
     */
    public function testView(): void
    {
        $this->get('/cameras/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseContains('192.168.1.10');
        $this->assertResponseContains('Main Entrance');
    }

    /**
     * Test view returns 404 for unknown id.
     */
    public function testViewNotFound(): void
    {
        $this->get('/cameras/9999');
        $this->assertResponseCode(404);
    }

    /**
     * Test add renders the form.
     */
    public function testAdd(): void
    {
        $this->get('/cameras/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Camera');
    }

    /**
     * Test add POST with valid data redirects to index and creates the record.
     */
    public function testAddPost(): void
    {
        $data = [
            'name' => 'New Test Camera',
            'ip_address' => '10.0.0.50',
            'location' => 'Server Room',
            'status' => 1,
        ];
        $this->post('/cameras', $data);
        $this->assertRedirect(['action' => 'index']);

        $cameras = $this->getTableLocator()->get('Cameras');
        $count = $cameras->find()->where(['name' => 'New Test Camera'])->count();
        $this->assertSame(1, $count);
    }

    /**
     * Test add POST with empty name stays on page and shows errors.
     */
    public function testAddPostValidationFail(): void
    {
        $data = [
            'name' => '',
            'ip_address' => '10.0.0.50',
            'status' => 1,
        ];
        $this->post('/cameras', $data);
        $this->assertResponseOk();
        $this->assertResponseContains('Add Camera');
    }

    /**
     * Test edit renders the pre-filled form.
     */
    public function testEdit(): void
    {
        $this->get('/cameras/1/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('Edit Camera');
        $this->assertResponseContains('Front Door Camera');
    }

    /**
     * Test edit returns 404 for unknown id.
     */
    public function testEditNotFound(): void
    {
        $this->get('/cameras/9999/edit');
        $this->assertResponseCode(404);
    }

    /**
     * Test edit POST with valid data redirects to index and updates the record.
     */
    public function testEditPost(): void
    {
        $data = [
            'name' => 'Updated Camera Name',
            'ip_address' => '192.168.1.10',
            'location' => 'Updated Location',
            'status' => 1,
        ];
        $this->put('/cameras/1', $data);
        $this->assertRedirect(['action' => 'index']);

        $cameras = $this->getTableLocator()->get('Cameras');
        $camera = $cameras->get(1);
        $this->assertSame('Updated Camera Name', $camera->name);
    }

    /**
     * Test delete POST removes the record and redirects.
     */
    public function testDeletePost(): void
    {
        $this->delete('/cameras/1');
        $this->assertRedirect(['action' => 'index']);

        $cameras = $this->getTableLocator()->get('Cameras');
        $count = $cameras->find()->where(['id' => 1])->count();
        $this->assertSame(0, $count);
    }

    /**
     * Test delete POST for unknown id returns 404.
     */
    public function testDeleteNotFound(): void
    {
        $this->delete('/cameras/9999');
        $this->assertResponseCode(404);
    }
}
