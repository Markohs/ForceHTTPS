<?php

namespace Tests;

class ForceHTTPSTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::SetUp();

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function unconfigured_remains_inactive()
    {
        $response = $this->get('test');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_force_redirect_single_route()
    {
        config()->set('forcehttps.enabled_environments', ['testing']);

        $response = $this->get('test_forced');

        $response->assertStatus(302);
        $response->assertRedirect(secure_url('test_forced'));
    }

    /**
     * @test
     */
    public function can_force_redirect_single_route_whitelist()
    {
        config()->set('forcehttps.enabled_environments', ['testing']);

        $response = $this->get('test_forced');

        config()->set('forcehttps.whitelist', []);

        $response->assertStatus(302);
        $response->assertRedirect(secure_url('test_forced'));

        config()->set('forcehttps.whitelist', ['test_forced']);
        $response2 = $this->get('test_forced');
        $response2->assertStatus(200);
    }

    /**
     * @test
     */
    public function autoregister_works()
    {
        // TODO: No idea how to check this one, as it's executed on servide provider booting
        // Maybe update forcehttps.autoregister and re-boot the service provider? No idea.
        $this->assertTrue(true);
    }

    /** @test */
    public function populates_expected_config_settings()
    {
        $this->assertEquals(['stage', 'prod', 'production'], $this->app['config']['forcehttps.enabled_environments']);
        $this->assertEquals([], $this->app['config']['forcehttps.whitelist']);
        $this->assertEquals([], $this->app['config']['forcehttps.autoregister']);
    }
}
