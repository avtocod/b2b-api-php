<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Avtocod\B2BApi\Settings;
use GuzzleHttp\RequestOptions as GuzzleHttpOptions;

/**
 * @covers \Avtocod\B2BApi\Settings<extended>
 */
class SettingsTest extends AbstractTestCase
{
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var string
     */
    protected $auth_token;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->settings = new Settings(
            $this->auth_token = $this->faker->word
        );
    }

    /**
     * @return void
     */
    public function testConstructorDefaults(): void
    {
        $this->assertSame('https://b2bapi.avtocod.ru/b2b/api/v1/', $this->settings->getBaseUri());

        $this->assertTrue($this->settings->getGuzzleOptions()[GuzzleHttpOptions::VERIFY]);
        $this->assertSame(60.0, $this->settings->getGuzzleOptions()[GuzzleHttpOptions::TIMEOUT]);
    }

    /**
     * @return void
     */
    public function testAuthToken(): void
    {
        $this->assertSame($this->auth_token, $this->settings->getAuthToken());

        $this->settings->setAuthToken($new_token = $this->faker->word);

        $this->assertSame($new_token, $this->settings->getAuthToken());
    }

    /**
     * @return void
     */
    public function testBaseUriSetter(): void
    {
        $this->settings = new Settings($this->auth_token, $uri = 'http://httpbin.org/foo');

        $this->assertSame($uri . '/', $this->settings->getBaseUri());
    }

    /**
     * @return void
     */
    public function testGuzzleOptionsSetter(): void
    {
        $this->settings = new Settings($this->auth_token, null, [
            GuzzleHttpOptions::ALLOW_REDIRECTS => false,
        ]);

        $this->assertFalse($this->settings->getGuzzleOptions()[GuzzleHttpOptions::ALLOW_REDIRECTS]);

        $this->assertSame('https://b2bapi.avtocod.ru/b2b/api/v1/', $this->settings->getBaseUri());
    }
}
