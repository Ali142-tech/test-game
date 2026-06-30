<?php

namespace App\Database\Connectors;

use Illuminate\Database\Connectors\PostgresConnector;

class NeonPostgresConnector extends PostgresConnector
{
    protected function addSslOptions($dsn, array $config)
    {
        $dsn = parent::addSslOptions($dsn, $config);

        $endpoint = $config['endpoint'] ?? $this->neonEndpointFromHost($config['host'] ?? null);

        if ($endpoint) {
            $dsn .= ';options=endpoint='.$endpoint;
        }

        return $dsn;
    }

    private function neonEndpointFromHost(?string $host): ?string
    {
        if (! $host || ! str_contains($host, 'neon.tech')) {
            return null;
        }

        return explode('.', $host)[0] ?: null;
    }
}
