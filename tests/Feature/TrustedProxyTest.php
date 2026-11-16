<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Memastikan IP pengunjung asli terbaca benar untuk tiap jenis instalasi
 * (hosting langsung, Cloudflare, reverse proxy, atau keduanya).
 */
class TrustedProxyTest extends TestCase
{
    private const CLIENT = '36.80.1.2';      // pengunjung asli
    private const CLOUDFLARE = '172.70.1.1'; // salah satu IP Cloudflare
    private const LOCAL_PROXY = '127.0.0.1'; // reverse proxy di server yang sama
    private const ATTACKER_FAKE = '9.9.9.9';  // IP palsu yang disisipkan penyerang

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('/_test/ip', fn () => response()->json([
            'ip' => request()->ip(),
            'secure' => request()->isSecure(),
        ]));
    }

    private function useProxies(string $value): void
    {
        putenv("TRUSTED_PROXIES=$value");
        $_ENV['TRUSTED_PROXIES'] = $_SERVER['TRUSTED_PROXIES'] = $value;
        config(['trustedproxy' => require config_path('trustedproxy.php')]);
    }

    protected function tearDown(): void
    {
        putenv('TRUSTED_PROXIES');
        unset($_ENV['TRUSTED_PROXIES'], $_SERVER['TRUSTED_PROXIES']);
        parent::tearDown();
    }

    private function hit(string $remoteAddr, ?string $forwardedFor, string $proto = 'https')
    {
        $headers = ['X-Forwarded-Proto' => $proto];
        if ($forwardedFor !== null) {
            $headers['X-Forwarded-For'] = $forwardedFor;
        }

        return $this->withServerVariables(['REMOTE_ADDR' => $remoteAddr])
            ->withHeaders($headers)
            ->getJson('/_test/ip');
    }

    public function test_direct_hosting_ignores_forged_forwarded_header(): void
    {
        $this->useProxies('');

        $this->hit(self::CLIENT, self::ATTACKER_FAKE)
            ->assertJson(['ip' => self::CLIENT]);
    }

    public function test_cloudflare_only(): void
    {
        $this->useProxies('cloudflare');

        $this->hit(self::CLOUDFLARE, self::CLIENT)
            ->assertJson(['ip' => self::CLIENT, 'secure' => true]);
    }

    public function test_cloudflare_setting_does_not_trust_random_ip(): void
    {
        $this->useProxies('cloudflare');

        // Penyerang menembak server langsung (bukan lewat Cloudflare) dengan header palsu.
        $this->hit(self::CLIENT, self::ATTACKER_FAKE)
            ->assertJson(['ip' => self::CLIENT]);
    }

    public function test_reverse_proxy_behind_cloudflare(): void
    {
        $this->useProxies('private,cloudflare');

        // Pengunjung -> Cloudflare -> reverse proxy lokal -> aplikasi.
        // Penyerang juga mencoba menyisipkan IP palsu di depan.
        $this->hit(self::LOCAL_PROXY, self::ATTACKER_FAKE . ', ' . self::CLIENT . ', ' . self::CLOUDFLARE)
            ->assertJson(['ip' => self::CLIENT, 'secure' => true]);
    }

    public function test_reverse_proxy_with_specific_ip(): void
    {
        $this->useProxies('203.0.113.10');

        $this->hit('203.0.113.10', self::CLIENT)
            ->assertJson(['ip' => self::CLIENT, 'secure' => true]);
    }
}
