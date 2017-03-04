@extends('layouts.shop')

@section('title')
    Добавить товар
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cube fa-lg fa-left-big"></i>Добавить товар</h1>
        </div>
        <form method="post" action="{{ route('admin.products.add.save', ['server' => $currentServer->id]) }}">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>Привязать предмет:</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-products-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    <div class="dropdown-divider"></div>
                                    @foreach($items as $item)
                                        <a class="dropdown-item edit-products-clip-item change" data-item="{{ $item->id }}" data-parent="edit-products-clip">[{{ $item->id }}] {{ $item->name }}</a>
                                    @endforeach
                                </div>
                                <input type="hidden" name="item" id="item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-cubes prefix"></i>
                                    <input type="text" name="stack" id="stack" class="form-control" value="{{ old('stack') }}">
                                    <label for="stack">Количество товара в 1 стаке</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-money prefix"></i>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                                    <label for="price">Цена за стак товара</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>Привязать к серверу/категории:</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-categories-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    <div class="dropdown-divider"></div>
                                    @foreach($categories as $category)
                                        <a class="dropdown-item edit-categories-clip-item change" data-server="{{ $category->server_id }}" data-category="{{ $category->category_id }}" data-parent="edit-categories-clip">{{ $category->server }} / {{ $category->category }}</a>
                                    @endforeach
                                </div>
                                <input type="hidden" name="server" id="server">
                                <input type="hidden" name="category" id="category">
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
