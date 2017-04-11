<?php

namespace App\Services;

use App\Exceptions\SashokLauncherAuthWhiteListException;

/**
 * Class SashokLauncher
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class SashokLauncher
{
    /**
     * Method - handler
     *
     * @param string $username
     * @param string $password
     * @param string $ip
     *
     * @throws SashokLauncherAuthWhiteListException
     *
     * @return bool
     */
    public function checkCredentials($username, $password, $ip, $whiteList)
    {
        if (!$this->whiteList($ip, $whiteList)) {
            throw new SashokLauncherAuthWhiteListException();
        }

        $user = \Sentinel::getUserRepository()->findByCredentials(['username' => $username]);

        if ($user) {
            $hash = $user->getUserPassword();

            if (password_verify($password, $hash)) {
                return $user->username;
            }
        }

        return false;
    }

    /**
     * Checks if the current ip is in the whitelist
     *
     * @param string $ip
     * @param array  $whiteList
     *
     * @return bool
     */
    private function whiteList($ip, $whiteList)
    {
        $whiteList = json_decode($whiteList, true);

        if (count($whiteList) === 0) {
            return true;
        }

        if (in_array($ip, $whiteList)) {
            return true;
        }

        return false;
    }
}
