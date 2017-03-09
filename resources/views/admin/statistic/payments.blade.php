{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    История покупок пользователей
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-list fa-lg fa-left-big"></i>История покупок и платежей пользователей</h1>
        </div>
        <div class="product-container">
            @if($payments->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Тип</th>
                            <th>Товары</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Сервер</th>
                            <th>Статус</th>
                            <th>Создан</th>
                            <th>Завершен</th>
                            <th>Сервис</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr @if($payment->completed) class="table-success" @endif>
                                <td>{{ $payment->id }}</td>
                                <td>@if($payment->products) Покупка товаров @else Пополнение баланса @endif</td>
                                <td>@if($payment->products)<a class="btn btn-info btn-sm profile-payments-info" data-url="{{ route('admin.statistic.payments.info', ['server' => $payment->server_id, 'payment' => $payment->id]) }}">Подробнее...</a> @endif</td>
                                <td>{{ $payment->username }}</td>
                                <td>{{ $payment->cost }} {!! $currency !!}</td>
                                @foreach($servers as $server)
                                    @if($server->id == $payment->server_id)
                                        <td>{{ $server->name }}</td>
                                    @endif
                                @endforeach
                                <td>@if($payment->completed) Завершен @else Не завершен @endif</td>
                                <td>{{ $payment->created_at }}</td>
                                <td>@if($payment->completed) {{ $payment->updated_at }} @endif</td>
                                <td>@if($payment->service) {{ $payment->service }} @endif</td>
                                <td>@if(!$payment->completed) <a href="{{ route('admin.statistic.payments.complete', ['server' => $payment->server_id, 'payment' => $payment->id]) }}" class="btn success-color btn-sm">Завершить</a> @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $payments->links('components.pagination') }}
            @else
                <div class="text-center">
                    <h3>История платежей пуста</h3>
                </div>
            @endif
        </div>
    </div>
    @component('components.modal')
    @slot('id')
    profile-payments-modal
    @endslot
    @slot('title')
    Информация о товарах платежа
    @endslot
    @slot('buttons')
    <button type="button" class="btn btn-warning" data-dismiss="modal">Понятно</button>
    @endslot
    <div class="md-form">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Количество</th>
                </tr>
                </thead>
                <tbody id="profile-payments-modal-products">

                </tbody>
            </table>
        </div>
    </div>
    @endcomponent
@endsection
