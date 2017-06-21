{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')


@section('title')
    Персонаж
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-user fa-lg fa-left-big"></i>Персонаж</h1>
        </div>
        <div class="product-container">
            <div id="change-skin" class="row">
                @if(s_get('profile.character.skin.enabled'))
                    <div class="change-skin-col col-md-@if(s_get('profile.character.cloak.enabled'))6 @else12 @endif col-12 text-center">
                        <div class="row">
                            <div class="col-12" id="skin">
                                <img src="{{ route('skin.front', ['user' => username()]) }}" alt="skin" id="skin-front" class="skin-img">
                                <img src="{{ route('skin.back', ['user' => username()]) }}" alt="skin" id="skin-back" class="skin-img">
                            </div>
                            <div class="col-12" id="skin-upload">
                                <form id="skin-form" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <label for="upload-skin" class="btn btn-primary" style="display: inline-block;">Выбрать файл<i class="fa fa-download fa-right"></i></label><br/>
                                    <input style="display: none;" type="file" name="skin" id="upload-skin" accept="image/png" onchange="$('#skin-location').val($('#upload-skin').val());
                               if ($('#skin-location').val() !== '')
                                    $('#profile-update-skin').prop('disabled', false).removeClass('disabled');
                                else
                                    $('#profile-update-skin').attr('disabled', 'disabled').addClass('disabled');">
                                    </form>
                                <input type="text" readonly id="skin-location">
                            </div>
                            <div class="col-12">
                                <button id="profile-update-skin" class="btn green disabled" disabled="disabled" data-url="{{ route('profile.character.skin.upload') }}"><i class="fa fa-refresh fa-left"></i>Обновить</button>
                                <div class="alert alert-info mt-3">
                                    Максимальный размер файла - <strong>{{ s_get('profile.character.skin.max_size') }}</strong> КБ.
                                </div>
                                <div class="alert alert-info">
                                    @if(s_get('profile.character.skin.hd'))
                                        Максимальные размеры изображения - <strong>1024x512</strong>
                                    @else
                                        Размер изображения - <strong>64x32</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(s_get('profile.character.cloak.enabled'))
                    <div class="change-skin-col col-md-@if(s_get('profile.character.skin.enabled'))6 @else12 @endif col-12 text-center">
                        <div class="row">
                            <div class="col-12" id="cloak">
                                @if(cloak_exists(username()))
                                    <img src="{{ route('cloak.back', ['user' => username()]) }}" alt="skin" class="skin-img">
                                    <img src="{{ route('cloak.front', ['user' => username()]) }}" alt="skin" class="skin-img">
                                @else
                                    <div class="alert alert-info">
                                        Плащ не установлен
                                    </div>
                                @endif
                            </div>
                            <div class="col-12" id="cloak-upload">
                                <form id="cloak-form" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <label for="upload-cloak" class="btn btn-primary" style="display: inline-block;">Выбрать файл<i class="fa fa-download fa-right"></i></label><br/>
                                    <input style="display: none;" type="file" name="cloak" id="upload-cloak" accept="image/png" onchange="$('#cloak-location').val($('#upload-cloak').val());
                               if ($('#cloak-location').val() !== '')
                                    $('#profile-update-cloak').prop('disabled', false).removeClass('disabled');
                                else
                                    $('#profile-update-cloak').attr('disabled', 'disabled').addClass('disabled');">
                                </form>
                                <input type="text" readonly id="cloak-location">
                            </div>
                            <div class="col-12">
                                <button id="profile-update-cloak" class="btn green disabled" disabled="disabled" data-url="{{ route('profile.character.cloak.upload') }}"><i class="fa fa-refresh fa-left"></i>Обновить</button>
                                <div class="alert alert-info mt-3">
                                    Максимальный размер файла - <strong>{{ s_get('profile.character.cloak.max_size') }}</strong> КБ.
                                </div>
                                <div class="alert alert-info">
                                    @if(s_get('profile.character.cloak.hd'))
                                        Максимальные размеры изображения - <strong>1024x512</strong>
                                    @else
                                        Размер изображения - <strong>22x17</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
