<?php

namespace Sanchescom\WiFi\System;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\ItemNotFoundException;
use Sanchescom\WiFi\Exceptions\NetworkNotFoundException;

/**
 * Class Collection.
 */
class Collection extends BaseCollection
{
    /**
     * @return \Sanchescom\WiFi\System\AbstractNetwork[]
     */
    public function getAll()
    {
        return $this->all();
    }

    /**
     * @param string $ssid
     *
     * @return \Sanchescom\WiFi\System\AbstractNetwork
     */
    public function getBySsid(string $ssid)
    {
        return $this->where('ssid', $ssid)->firstOrFail();
    }

    /**
     * @param string $bssid
     *
     * @return \Sanchescom\WiFi\System\AbstractNetwork
     */
    public function getByBssid(string $bssid)
    {
        return $this->where('bssid', $bssid)->firstOrFail();
    }

    /**
     * @return \Sanchescom\WiFi\System\AbstractNetwork[]
     */
    public function getConnected()
    {
        return $this->where('connected', true)->all();
    }

    /**
     * @return \Sanchescom\WiFi\System\AbstractNetwork
     * @throws \Sanchescom\WiFi\Exceptions\NetworkNotFoundException
     */
    public function firstOrFail($key = null, $operator = null, $value = null)
    {
        try {
            return parent::firstOrFail(...func_get_args());
        } catch (ItemNotFoundException $e) {
            throw new NetworkNotFoundException();
        }
    }
}
