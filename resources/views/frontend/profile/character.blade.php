@extends('layout.shop')

@section('title')
    @lang('content.profile.character.title')
@endsection

@section('content')
    <div id="cart-header" class="z-depth-1">
        <h1><i class="fa fa-user fa-lg fa-left-big"></i>@lang('content.profile.character.title')</h1>
    </div>
    <div class="product-container">
        <div id="change-skin" class="row">
            @if($skinEnabled)
                <div class="change-skin-col col-md-@if($cloakEnabled)6 @else12 @endif col-12 text-center">
                    <skin-block
                            route-skin-front="{{ route('api.user.skin.front', ['username' => $username]) }}"
                            route-skin-back="{{ route('api.user.skin.back', ['username' => $username]) }}"
                            route-update="{{ route('frontend.profile.character.skin.upload') }}"
                            max-skin-size="{{ $maxSkinFileSize }}"
                            :available-image-sizes="{{ json_encode($availableSkinImageSizes) }}"
                            hd-skin-enabled="{{ $hdSkinEnabled }}"
                    ></skin-block>
                </div>
            @endif
            @if($cloakEnabled)
                <div class="change-skin-col col-md-@if($skinEnabled)6 @else12 @endif col-12 text-center">
                    <cloak-block
                            cloak-exist="{{ $cloakExist }}"
                            route-cloak-front="{{ route('api.user.cloak.front', ['username' => $username]) }}"
                            route-cloak-back="{{ route('api.user.cloak.back', ['username' => $username]) }}"
                            route-update="{{ route('frontend.profile.character.cloak.upload') }}"
                            max-cloak-size="{{ $maxCloakFileSize }}"
                            :available-image-sizes="{{ json_encode($availableCloakImageSizes) }}"
                            hd-cloak-enabled="{{ $hdCloakEnabled }}"
                    ></cloak-block>
                </div>
            @endif
        </div>
    </div>
@endsection
