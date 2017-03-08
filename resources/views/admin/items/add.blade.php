{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Добавить предмет
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-diamond fa-lg fa-left-big"></i>Добавить предмет</h1>
        </div>
        <form method="post" action="{{ route('admin.items.add.save', ['server' => $currentServer->id]) }}" enctype="multipart/form-data">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-font prefix"></i>
                                <input type="text" name="name" id="item-name" class="form-control" value="">
                                <label for="item-name">Название предмета</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <h4 class="text-center">Тип изображения:</h4>
                            <div class="plus-category text-center mt-1 mb-3">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <input type="radio" name="image_mode" id="item-set-default-image" autocomplete="off" value="default" checked> Стандартное изображеиние
                                    </label>
                                    <label class="btn btn-info">
                                        <input type="radio" name="image_mode" id="item-set-uploaded-image" autocomplete="off" value="upload"> Загрузить изображение
                                    </label>
                                </div>
                            </div>
                            <div id="item-load-image-block" class="plus-category text-center mt-1 mb-3" style="display: none">
                                <label for="upload-img" class="btn btn-warning" style="display: inline-block;">Выбрать изображение  <i class="fa fa-download"></i></label>
                                <input style="display: none;" type="file" name="image" id="upload-img" accept="image/*" onchange="$('#file-location').val($('#upload-img').val());">

                                <input type="text" id="file-location" placeholder="Изображение не выбрано" readonly>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-list prefix"></i>
                                    <input type="text" name="item" id="item" class="form-control" value="">
                                    <label for="item">ID или ID:DATA предмета</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-list prefix"></i>
                                    <input type="text" name="extra" id="extra" class="form-control" value="">
                                    <label for="extra">Extra</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection