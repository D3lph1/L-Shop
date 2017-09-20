{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.pages.list.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-files-o fa-left-big"></i>@lang('content.admin.pages.list.title')</h1>
        </div>
        <div class="product-container">
            <div class="mb-1">
                <a href="{{ route('admin.pages.add', ['server' => $currentServer->getId()]) }}" class="btn btn-info btn-block">@lang('content.admin.pages.list.add')</a>
            </div>
            @if($pages->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('content.admin.pages.list.table.id')</th>
                            <th>@lang('content.admin.pages.list.table.name')</th>
                            <th>@lang('content.admin.pages.list.table.url')</th>
                            <th>@lang('content.admin.pages.list.table.created_at')</th>
                            <th>@lang('content.admin.pages.list.table.updated_at')</th>
                            <th>@lang('content.admin.pages.list.table.edit')</th>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <th scope="row">{{ $page->getId() }}</th>
                                <td>{{ $page->getTitle() }}</td>
                                <td><a href="{{ route('page',['server' => $currentServer->getId(), 'page' => $page->getUrl()]) }}" target="_blank">{{ route('page',['server' => $currentServer->getId(), 'page' => $page->getUrl()]) }}</a></td>
                                <td>{{ $page->getCreatedAt() }}</td>
                                <td>{{ $page->getUpdatedAt() }}</td>
                                <td><a href="{{ route('admin.pages.edit', ['server' => $currentServer->getId(), 'id' => $page->getId()]) }}" class="btn btn-info btn-sm">@lang('content.admin.pages.list.table.edit')</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    @lang('content.admin.pages.list.empty')
                </div>
            @endif
            {{ $pages->links('components.pagination') }}
        </div>
    </div>
@endsection