{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Документация по API L - Shop
@endsection

@section('js')
    <script type="text/javascript">
        hljs.initHighlightingOnLoad();
    </script>
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cog fa-left-big"></i>Документация по API L - Shop</h1>
        </div>
        <div class="card card-block">
            {!! $data !!}
        </div>
    </div>
@endsection
