<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * DashboardController integration tests.
 */
class DashboardControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures loaded for every test.
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Stores',
        'app.Cameras',
        'app.Users',
    ];

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Log in as a valid user so authenticated routes are accessible.
     */
    private function loginAsUser(): void
    {
        $this->session([
            'Auth' => [
                'id'       => 1,
                'username' => 'testuser',
            ],
        ]);
    }

    // ── Happy path ────────────────────────────────────────────────────────────

    /**
     * GET /dashboard returns 200 with expected view variables.
     */
    public function testIndexReturns200(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertResponseContains('Surveillance Dashboard');
    }

    /**
     * Dashboard view sets the required stat variables.
     */
    public function testIndexSetsStatVariables(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertNotNull($this->viewVariable('totalStores'));
        $this->assertNotNull($this->viewVariable('totalCameras'));
        $this->assertNotNull($this->viewVariable('activeCameras'));
        $this->assertNotNull($this->viewVariable('inactiveCameras'));
    }

    /**
     * Stat counts match fixture data (2 stores, 3 cameras, 2 active, 1 inactive).
     */
    public function testIndexStatCounts(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertSame(2, $this->viewVariable('totalStores'));
        $this->assertSame(3, $this->viewVariable('totalCameras'));
        $this->assertSame(2, $this->viewVariable('activeCameras'));
        $this->assertSame(1, $this->viewVariable('inactiveCameras'));
    }

    /**
     * Camera list is rendered in the response.
     */
    public function testIndexRendersCameraTable(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseContains('192.168.1.10');
        $this->assertResponseContains('Parking Lot Camera');
        $this->assertResponseContains('Lobby Camera');
    }

    /**
     * Store cards are rendered in the response.
     */
    public function testIndexRendersStoreCards(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertResponseContains('Store Bangkok Central');
        $this->assertResponseContains('Store Chiang Mai');
    }

    // ── Camera search / filter ─────────────────────────────────────────────────

    /**
     * Searching by name narrows the camera list.
     */
    public function testIndexSearchByName(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?q=Front+Door');

        $this->assertResponseOk();
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseNotContains('Parking Lot Camera');
        $this->assertResponseNotContains('Lobby Camera');
    }

    /**
     * Searching by IP address narrows the camera list.
     */
    public function testIndexSearchByIp(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?q=192.168.1.11');

        $this->assertResponseOk();
        $this->assertResponseContains('Parking Lot Camera');
        $this->assertResponseNotContains('Front Door Camera');
    }

    /**
     * Filtering by status=active returns only active cameras.
     */
    public function testIndexFilterByStatusActive(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?status=active');

        $this->assertResponseOk();
        // Lobby Camera is inactive — must not appear
        $this->assertResponseNotContains('Lobby Camera');
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseContains('Parking Lot Camera');
    }

    /**
     * Filtering by status=inactive returns only inactive cameras.
     */
    public function testIndexFilterByStatusInactive(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?status=inactive');

        $this->assertResponseOk();
        $this->assertResponseContains('Lobby Camera');
        $this->assertResponseNotContains('Front Door Camera');
        $this->assertResponseNotContains('Parking Lot Camera');
    }

    /**
     * Filtering by store_id narrows the camera list to that store's cameras.
     */
    public function testIndexFilterByStore(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?store_id=2');

        $this->assertResponseOk();
        $this->assertResponseContains('Lobby Camera');
        $this->assertResponseNotContains('Front Door Camera');
        $this->assertResponseNotContains('Parking Lot Camera');
    }

    /**
     * A search with no matches shows the empty-state placeholder.
     */
    public function testIndexSearchNoResults(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?q=NonExistentCameraXYZ');

        $this->assertResponseOk();
        $this->assertResponseContains('No cameras match your search criteria');
    }

    // ── Edge cases ────────────────────────────────────────────────────────────

    /**
     * Invalid store_id (non-numeric) is ignored gracefully.
     */
    public function testIndexIgnoresInvalidStoreId(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?store_id=not-a-number');

        $this->assertResponseOk();
        // All cameras still rendered
        $this->assertResponseContains('Front Door Camera');
    }

    /**
     * Unknown status value falls back to showing all cameras.
     */
    public function testIndexUnknownStatusShowsAll(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard?status=unknown');

        $this->assertResponseOk();
        $this->assertResponseContains('Front Door Camera');
        $this->assertResponseContains('Lobby Camera');
    }

    /**
     * The dashboard nav links are present in the layout.
     */
    public function testLayoutNavContainsDashboardLink(): void
    {
        $this->loginAsUser();
        $this->get('/dashboard');

        $this->assertResponseOk();
        $this->assertResponseContains('Dashboard');
    }
}
