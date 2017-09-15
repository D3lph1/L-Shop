<?php

namespace App\Services;

use App\Exceptions\SashokLauncherAuthWhiteListException;
use App\Models\User\UserInterface;
use Cartalyst\Sentinel\Checkpoints\ActivationCheckpoint;

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
     * Method - handler.
     *
     * @param string $username User username.
     * @param string $password User password.
     * @param string $ip       Sender ip address.
     *
     * @throws SashokLauncherAuthWhiteListException
     *
     * @return mixed
     */
    public function auth(string $username, string $password, string $ip, string $whiteList)
    {
        if (!$this->whiteList($ip, $whiteList)) {
            throw new SashokLauncherAuthWhiteListException();
        }

        /** @var UserInterface $user */
        $user = \Sentinel::authenticate([
            'username' => $username,
            'password' => $password
        ]);

        if ($user) {
            return $user->getUsername();
        }

        return false;
    }

    /**
     * Checks if the current ip is in the whitelist.
     *
     * @param string $ip Sender ip address.
     * @param string $whiteList White list with ip addresses in JSON format.
     *
     * @return bool
     */
    private function whiteList(string $ip, string $whiteList): bool
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

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    protected function activationCheckpoint(UserInterface $user)
    {
        /** @var ActivationCheckpoint $checkpoint */
        $checkpoint = app(ActivationCheckpoint::class);

        return $checkpoint->login($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    protected function banCheckpoint(UserInterface $user)
    {
        /** @var BanCheckpoint $checkpoint */
        $checkpoint = app(BanCheckpoint::class);

        return $checkpoint->login($user);
    }
}
