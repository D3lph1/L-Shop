<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\Character\Skin;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SkinController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers
 */
class SkinController extends Controller
{
    /**
     * Check user with given username on exists
     */
    protected function checkUser(string $username): bool
    {
        if ($this->sentinel->getUserRepository()->findByCredentials(['username' => $username])) {
            return true;
        }

        $this->app->abort(404);

        return false;
    }

    public function skinFront(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getFrontSkin();
        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    public function skinBack(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getBackSkin();
        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    public function headFront(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getFrontHead();
        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    public function headBack(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getBackHead();
        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    public function cloakFront(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getFrontCloak();
        if (!$ready) {
            $this->app->abort(404);
        }

        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    public function cloakBack(Request $request): Response
    {
        $username = $request->route('user');
        $skin = $this->skin($username);
        $this->checkUser($username);
        $ready = $skin->getBackCloak();
        if (!$ready) {
            $this->app->abort(404);
        }

        $ready->resizeImage(256);
        $img = $ready->saveImageAsTmpAndGet();

        return $this->makeResponse($img);
    }

    private function skin(string $player): Skin
    {
        return $this->app->makeWith(Skin::class, ['player' => $player]);
    }

    private function makeResponse(Image $image): Response
    {
        return response($image->encode('png'), 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
