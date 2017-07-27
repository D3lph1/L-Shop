{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.profile.payments.title')
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-list fa-lg fa-left-big"></i>@lang('content.profile.payments.title')</h1>
        </div>
        <div class="product-container">
            @if($payments->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('content.profile.payments.table.id')</th>
                            <th>@lang('content.profile.payments.table.type')</th>
                            <th>@lang('content.profile.payments.table.products')</th>
                            <th>@lang('content.profile.payments.table.sum')</th>
                            <th>@lang('content.all.server')</th>
                            <th>@lang('content.profile.payments.table.status')</th>
                            <th>@lang('content.profile.payments.table.created_at')</th>
                            <th>@lang('content.profile.payments.table.completed_at')</th>
                            <th>@lang('content.profile.payments.table.service')</th>
                            <th>@lang('content.profile.payments.table.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr @if($payment->completed) class="table-success" @endif>
                                <td>{{ $payment->id }}</td>
                                <td>@if($payment->products) @lang('content.profile.payments.table.shopping') @else @lang('content.profile.payments.table.fillupbalance') @endif</td>
                                <td>@if($payment->products)<a class="btn btn-info btn-sm profile-payments-info" data-url="{{ route('profile.payments.info', ['server' => $payment->server_id, 'payment' => $payment->id]) }}">@lang('content.profile.payments.table.more')</a> @endif</td>
                                <td>{{ $payment->cost }} {!! $currency !!}</td>
                                @foreach($servers as $server)
                                    @if($server->id == $payment->server_id)
                                        <td>{{ $server->name }}</td>
                                    @endif
                                @endforeach
                                <td>@if($payment->completed) @lang('content.profile.payments.table.completed') @else @lang('content.profile.payments.table.not_completed') @endif</td>
                                <td>{{ $payment->created_at }}</td>
                                <td>@if($payment->completed) {{ $payment->updated_at }} @endif</td>
                                <td>@if($payment->service) {{ $payment->service }} @endif</td>
                                <td>@if(!$payment->completed) <a href="{{ route('payment.methods', ['server' => $payment->server_id, 'payment' => $payment->id]) }}" class="btn success-color btn-sm">@lang('content.profile.payments.table.pay')</a> @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $payments->links('components.pagination') }}
            @else
                <div class="text-center">
                    <h3>@lang('content.profile.payments.table.empty')</h3>
                </div>
            @endif
        </div>
    </div>
    @component('components.modal')
    @slot('id')
    profile-payments-modal
    @endslot
    @slot('title')
        @lang('content.profile.payments.table.details_modal.title')
    @endslot
    @slot('buttons')
    <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('content.profile.payments.table.details_modal.btn')</button>
    @endslot
    <div class="md-form">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>@lang('content.profile.payments.table.details_modal.table.image')</th>
                    <th>@lang('content.profile.payments.table.details_modal.table.name')</th>
                    <th>@lang('content.profile.payments.table.details_modal.table.count')</th>
                </tr>
                </thead>
                <tbody id="profile-payments-modal-products">

                </tbody>
            </table>
        </div>
    </div>
    @endcomponent
@endsection
