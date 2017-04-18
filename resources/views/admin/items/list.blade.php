{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать предметы
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-diamond fa-lg fa-left-big"></i>Редактировать предметы</h1>
        </div>
        <div class="mb-1">
            <a href="{{ route('admin.items.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">Добавить предмет</a>
        </div>
        <div class="product-container">
            @if($items->count())
                <div class="text-right">
                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Сортировать</button>

                        <div class="dropdown-menu">
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id]) }}" class="dropdown-item">Без сортировки</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'asc']) }}" class="dropdown-item">По идентификатору</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'desc']) }}" class="dropdown-item">По идентификатору, в обратном порядке</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'asc']) }}" class="dropdown-item">По названию</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'desc']) }}" class="dropdown-item">По названию, в обратном порядке</a>
                        </div>
                    </div>

                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Фильтр</button>

                        <div class="dropdown-menu dropdown-overflow">
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id]) }}" class="dropdown-item">Без фильтра</a>
                            <div class="dropdown-divider"></div>
                            @foreach($filters as $filter)
                                <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'filter' => $filter]) }}" class="dropdown-item">{{ $filter }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Extra</th>
                            <th>Редактировать</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td><img height="35" width="35" src="@if(is_file(img_path("items/$item->image"))) {{ asset("img/items/{$item->image}") }} @else {{ asset("img/empty.png") }} @endif"></td>
                                <td>{{ $item->name }}</td>
                                <td>@if ($item->type == 'item') Предмет/блок @elseif($item->type == 'permgroup') Привилегия @endif</td>
                                <td>@if(is_null($item->extra)) Нет @else {{ $item->extra }} @endif</td>
                                <td><a href="{{ route('admin.items.edit', ['server' => $currentServer->id, 'item' => $item->id]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $items->links('components.pagination') }}
            @else
                <div class="alert alert-info text-center">
                    Список предметов пока пуст...
                </div>
            @endif
        </div>
    </div>
@endsection
