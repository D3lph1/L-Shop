{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.news.list.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-newspaper-o fa-left-big"></i>@lang('content.admin.news.list.title')</h1>
        </div>
        <div class="product-container">
            <div class="mb-1">
                <a href="{{ route('admin.news.add', ['server' => $currentServer->getId()]) }}" class="btn btn-info btn-block">@lang('content.admin.news.list.add')</a>
            </div>
            @if($news->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('content.admin.news.list.table.id')</th>
                            <th>@lang('content.admin.news.list.table.name')</th>
                            <th>@lang('content.admin.news.list.table.author')</th>
                            <th>@lang('content.admin.news.list.table.published_at')</th>
                            <th>@lang('content.admin.news.list.table.updated_at')</th>
                            <th>@lang('content.admin.news.list.table.edit')</th>
                        </thead>
                        <tbody>
                        @foreach($news as $one)
                            <tr>
                                <th scope="row">{{ $one->getId() }}</th>
                                <td>{{ $one->getTitle() }}</td>
                                <td>{{ $one->getUser()->getUsername() }}</td>
                                <td>{{ $one->getCreatedAt() }}</td>
                                <td>{{ $one->getUpdatedAt() }}</td>
                                <td><a href="{{ route('admin.news.edit', ['server' => $currentServer->getId(), 'id' => $one->getId()]) }}" class="btn btn-info btn-sm">@lang('content.admin.news.list.table.edit')</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    @lang('content.admin.news.list.empty')
                </div>
            @endif
            {{ $news->links('components.pagination') }}
        </div>
    </div>
@endsection