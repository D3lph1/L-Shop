{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.other.statistics.show.title')
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-pencil fa-lg fa-left-big"></i>@lang('content.admin.other.statistics.show.title')</h1>
        </div>
        <div class="product-container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-center">@lang('content.admin.other.statistics.show.orders_per_year')</h4>
                    <canvas id="paymentsCountPerYear"></canvas>
                </div>
                <div class="col-md-6">
                    <h4 class="text-center">
                        @lang('content.admin.other.statistics.show.orders_per_month')
                            <div class="btn-group">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $currentMonthWord }}</button>

                                <div class="dropdown-menu">
                                    @foreach($months as $key => $value)
                                        <a class="dropdown-item" href="{{ route('admin.statistic.show', ['server' => $currentServer->id, 'month' => $key]) }}">{{ $value }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </h4>
                    <canvas id="paymentsCountPerMonth"></canvas>
                </div>

                <div class="col-md-6 mt-3">
                    <h4 class="text-center">@lang('content.admin.other.statistics.show.profit_per_year')</h4>
                    <canvas id="profitPerYear"></canvas>
                </div>

                <div class="col-md-6 mt-3">
                    <h4 class="text-center">
                        @lang('content.admin.other.statistics.show.profit_per_month')
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $currentMonthWord }}</button>

                            <div class="dropdown-menu">
                                @foreach($months as $key => $value)
                                    <a class="dropdown-item" href="{{ route('admin.statistic.show', ['server' => $currentServer->id, 'month' => $key]) }}">{{ $value }}</a>
                                @endforeach
                            </div>
                        </div>
                    </h4>
                    <canvas id="profitPerMonth"></canvas>
                </div>
                <div class="col-md-12 mt-2">
                    <hr>
                    <h3 class="text-center">@lang('content.admin.other.statistics.show.profit', ['profit' => $profit, 'currency' => $currency])</h3>
                    <hr>
                </div>
            </div>

            <div class="card card-block mt-5">
                <div class="flex-row">
                    <form method="post" action="{{ route('admin.statistic.flush_cache', ['server' => $currentServer->id]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-warning">@lang('content.admin.other.statistics.show.clear_cache')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var option = {
            responsive: true
        };

        var paymentsCountPerYear = document.getElementById("paymentsCountPerYear").getContext('2d');

        var data = {
            labels: [
                @foreach(__('content.months') as $month)
                    {!! '"' . $month . '",' !!}
                @endforeach
            ],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [
                        @for($i = 1; $i <= 12; $i++)
                            <?php $k = 0; ?>
                            @foreach($payments as $payment)
                                @if((new \DateTime($payment->updated_at))->format('n') == $i)
                                    <?php $k++; ?>
                                @endif
                            @endforeach
                        {{ $k . ','}}
                        @endfor
                    ]
                }
            ]
        };

        new Chart(paymentsCountPerYear).Line(data, option);

        /** --- */
        var paymentsCountPerMonth = document.getElementById("paymentsCountPerMonth").getContext('2d');

        data = {
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [
                        @for($i = 1; $i <= 31; $i++)
                            <?php $k = 0; ?>
                            @foreach($payments as $payment)
                                @if((new \DateTime($payment->updated_at))->format('n') == $currentMonth)
                                    @if((new \DateTime($payment->updated_at))->format('j') == $i)
                                        <?php $k++; ?>
                                    @endif
                                @endif
                            @endforeach
                            {{ $k . ','}}
                        @endfor
                    ]
                }
            ]
        };

        new Chart(paymentsCountPerMonth).Line(data, option); //'Line' defines type of the chart.

        /** --- */

        var profitPerYear = document.getElementById("profitPerYear").getContext('2d');

        data = {
            labels: [
                @foreach(__('content.months') as $month)
                    {!! '"' . $month . '",' !!}
                @endforeach
            ],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [
                        @for($i = 1; $i <= 12; $i++)
                            <?php $k = 0; ?>
                            @foreach($payments as $payment)
                                @if((new \DateTime($payment->updated_at))->format('n') == $i)
                                    <?php $k += $payment->cost; ?>
                                @endif
                            @endforeach
                            {{ $k . ','}}
                        @endfor
                    ]
                }
            ]
        };

        new Chart(profitPerYear).Line(data, option);

        /** --- */
        var profitPerMonth = document.getElementById("profitPerMonth").getContext('2d');

        data = {
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [
                        @for($i = 1; $i <= 31; $i++)
                            <?php $k = 0; ?>
                            @foreach($payments as $payment)
                                @if((new \DateTime($payment->updated_at))->format('n') == $currentMonth)
                                    @if((new \DateTime($payment->updated_at))->format('j') == $i)
                                        <?php $k += $payment->cost; ?>
                                    @endif
                                @endif
                            @endforeach
                            {{ $k . ','}}
                        @endfor
                    ]
                }
            ]
        };

        new Chart(profitPerMonth).Line(data, option);
    </script>
@endsection