<?php

namespace Studiosidekicks\Alfred\Log\Services;

use Illuminate\Support\Facades\Request;
use Studiosidekicks\Alfred\Log\Contracts\SigningsRepositoryContract;
use Studiosidekicks\Alfred\Log\Contracts\SigningsServiceContract;

class SigningsService implements SigningsServiceContract
{
    protected $repository;

    public function __construct(SigningsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function insert(string $email, string $errorMessage = null)
    {
        return $this->repository->create([
            'email' => $email,
            'is_successful' => empty($errorMessage),
            'message' => $errorMessage,
            'ip' => $this->assignIP(),
        ]);
    }

    private function assignIP()
    {
        $ip = Request::getClientIp();

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {

            $v4mapped_prefix_hex = '00000000000000000000ffff';
            $v4mapped_prefix_bin = pack("H*", $v4mapped_prefix_hex);

            // Parse
            $addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $addr_bin = inet_pton($addr);

            if ($addr_bin === FALSE) {
                $ip = '';
            } else {
                // Check prefix
                if (substr($addr_bin, 0, strlen($v4mapped_prefix_bin)) == $v4mapped_prefix_bin) {
                    // Strip prefix
                    $addr_bin = substr($addr_bin, strlen($v4mapped_prefix_bin));
                }

                // Convert back to printable address in canonical form
                $ip = inet_ntop($addr_bin);
            }
        }

        return $ip;
    }
}