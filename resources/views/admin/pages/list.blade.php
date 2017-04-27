{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать статические страницы
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-files-o fa-left-big"></i>Редактировать статические страницы</h1>
        </div>
        <div class="product-container">
            <div class="mb-1">
                <a href="{{ route('admin.pages.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">Добавить статическую страницу</a>
            </div>
            @if($pages->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Адрес</th>
                            <th>Дата добавления</th>
                            <th>Дата последнего редактирования</th>
                            <th>Редактировать</th>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <th scope="row">{{ $page->id }}</th>
                                <td>{{ $page->title }}</td>
                                <td><a href="{{ route('page',['server' => $currentServer->id, 'page' => $page->url]) }}" target="_blank">{{ route('page',['server' => $currentServer->id, 'page' => $page->url]) }}</a></td>
                                <td>{{ $page->created_at }}</td>
                                <td>{{ $page->updated_at }}</td>
                                <td><a href="{{ route('admin.pages.edit', ['server' => $currentServer->id, 'id' => $page->id]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Статических страниц пока нет...
                </div>
            @endif
            {{ $pages->links('components.pagination') }}
        </div>
    </div>
@endsection