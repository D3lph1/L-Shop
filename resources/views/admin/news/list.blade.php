{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать новости
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-newspaper-o fa-left-big"></i>Редактировать новости</h1>
        </div>
        <div class="product-container">
            <div class="mb-1">
                <a href="{{ route('admin.news.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">Добавить новость</a>
            </div>
            @if($news->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Автор</th>
                            <th>Дата публикации</th>
                            <th>Дата последнего редактирования</th>
                            <th>Редактировать</th>
                        </thead>
                        <tbody>
                        @foreach($news as $one)
                            <tr>
                                <th scope="row">{{ $one->id }}</th>
                                <td>{{ $one->title }}</td>
                                <td>{{ $one->author->username }}</td>
                                <td>{{ $one->created_at }}</td>
                                <td>{{ $one->updated_at }}</td>
                                <td><a href="{{ route('admin.news.edit', ['server' => $currentServer->id, 'id' => $one->id]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Новостей пока нет...
                </div>
            @endif
            {{ $news->links('components.pagination') }}
        </div>
    </div>
@endsection