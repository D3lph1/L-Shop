{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать товары
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cubes fa-lg fa-left-big"></i>Редактировать товары</h1>
        </div>
        <div class="mb-1">
            <a href="{{ route('admin.products.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">Добавить товар</a>
        </div>
        <div class="product-container">
            <div class="text-right">
                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Сортировать</button>

                    <div class="dropdown-menu">
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id]) }}" class="dropdown-item">Без сортировки</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'asc']) }}" class="dropdown-item">По идентификатору</a>
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'desc']) }}" class="dropdown-item">По идентификатору, в обратном порядке</a>
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'asc']) }}" class="dropdown-item">По названию</a>
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'desc']) }}" class="dropdown-item">По названию, в обратном порядке</a>
                    </div>
                </div>

                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Фильтр</button>

                    <div class="dropdown-menu dropdown-overflow">
                        <a href="{{ route('admin.products.list', ['server' => $currentServer->id]) }}" class="dropdown-item">Без фильтра</a>
                        <div class="dropdown-divider"></div>
                        @foreach($filters as $filter)
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->id, 'filter' => $filter]) }}" class="dropdown-item">{{ $filter }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение предмета</th>
                        <th>Название предмета</th>
                        <th>Цена (за стак)</th>
                        <th>Количество / длительность</th>
                        <th>Сервер</th>
                        <th>Категория</th>
                        <th>Редактировать</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td><img height="35" width="35" src="@if(is_file(img_path("items/$product->image"))) {{ asset("img/items/{$product->image}") }} @else {{ asset("img/empty.png") }} @endif"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stack }}</td>
                            <td>{{ $product->server }}</td>
                            <td>{{ $product->category }}</td>
                            <td><a href="{{ route('admin.products.edit', ['server' => $currentServer->id, 'product' => $product->id]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $products->links('components.pagination') }}
        </div>
    </div>
@endsection
