<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\User\Character\InvalidImageSizeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UploadCloakRequest;
use App\Http\Requests\Profile\UploadSkinRequest;
use App\Services\Character\Skin;
use App\Services\Character\UploadedCloak;
use App\Services\Character\UploadedSkin;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class CharacterController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        if (!(s_get('profile.character.skin.enabled', 0) or s_get('profile.character.cloak.enabled', 0))) {
            abort(403);
        }

        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('profile.character', $data);
    }

    /**
     * @param UploadSkinRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadSkin(UploadSkinRequest $request)
    {
        if (!s_get('profile.character.skin.enabled', 0)) {
            return json_response('disabled');
        }

        $uploadedSkin = new UploadedSkin($request->file('skin'));

        try {
            $uploadedSkin->validate(s_get('profile.character.skin.hd', false));
        } catch (InvalidImageSizeException $e) {
            return json_response('invalid ratio');
        }
        $uploadedSkin->move(username());

        return json_response('success');
    }

    /**
     * @param UploadCloakRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadCloak(UploadCloakRequest $request)
    {
        if (!s_get('profile.character.cloak.enabled', 0)) {
            return json_response('disabled');
        }

        $uploadedCloak = new UploadedCloak($request->file('cloak'));

        try {
            $uploadedCloak->validate(s_get('profile.character.cloak.hd'));
        } catch (InvalidImageSizeException $e) {
            return json_response('invalid ratio');
        }
        $uploadedCloak->move(username());

        return json_response('success');
    }
}
