<?php

namespace Sanchescom\WiFi\Contracts;

use Sanchescom\WiFi\System\AbstractNetwork;

/**
 * Interface NetworkInterface.
 */
interface NetworkInterface
{
    /**
     * @param string $device
     * @param ?string $password
     */
    public function connect(string $device, ?string $password=null): void;

    /**
     * @param string $device
     */
    public function disconnect(string $device): void;

    /**
     * @param array $network
     *
     * @return \Sanchescom\WiFi\System\AbstractNetwork
     */
    public function createFromArray(array $network): AbstractNetwork;
}
