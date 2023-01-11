<?php

declare(strict_types=1);

namespace Sanchescom\WiFi\System\Windows;

use Sanchescom\WiFi\Contracts\FrequencyInterface;
use Sanchescom\WiFi\System\AbstractNetwork;
use Sanchescom\WiFi\System\Frequency;

/**
 * Class Network.
 */
class Network extends AbstractNetwork implements FrequencyInterface
{
    use Frequency;

    /**
     * @param string $device
     * @param ?string $password
     *
     * @throws \Exception
     */
    public function connect(string $device, ?string $password=null): void
    {
        $command = glue_commands(
            sprintf('netsh wlan add profile filename="%s"', $this->getProfileService()->create($password)),
            sprintf('netsh wlan connect interface="%s" ssid="%s" name="%s"', $device, $this->ssid, $this->ssid)
        );

        $this->getCommand()->execute($command);

        $this->getProfileService()->delete();
    }

    /**
     * @param string $device
     *
     * @throws \Exception
     */
    public function disconnect(string $device): void
    {
        $this->getCommand()->execute(sprintf('netsh wlan disconnect interface="%s"', $device));
    }

    /**
     * @param array $network
     *
     * @return \Sanchescom\WiFi\System\Windows\Network
     */
    public function createFromArray(array $network): AbstractNetwork
    {
        $this->ssid = $network[0];
        $this->bssid = $network[4];
        $this->channel = (int) $network[7];
        $this->security = $network[2];
        $this->securityFlags = $network[3];
        $this->quality = (int) $network[5];
        $this->frequency = $this->getFrequency();
        $this->dbm = to_dbm((int) $network[5]);
        $this->connected = isset($network[10]);

        return $this;
    }

    /**
     * @return Profile
     */
    protected function getProfileService()
    {
        return new Profile($this->ssid, $this->getSecurityType());
    }
}
