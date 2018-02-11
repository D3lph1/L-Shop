<template>
    <div class="modal fade" id="monitoring-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100">{{ $t('content.monitoring.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div v-for="server in servers" class="md-form text-left">
                        <h4>{{ get_server_by_id($servers, $server->getServerId())->getName() }}</h4>

                        @if(is_null($server->getNow()) or is_null($server->getTotal()))
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger danger-color" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                @lang('content.monitoring.error')
                            </div>
                        </div>
                        @else
                        <div class="progress">
                            @if($server->getNow() === -1)
                            <div class="progress-bar progress-bar-danger danger-color" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                @lang('content.monitoring.server_disabled')
                            </div>
                            @else
                            <div class="progress-bar info-color" role="progressbar" aria-valuenow="{{ $server->getNow() }}" aria-valuemin="0" aria-valuemax="{{ $server->getTotal() }}" style="min-width: 12%; width: {{ ($server->getNow() / $server->getTotal()) * 100 }}%;">
                                {{ $server->getNow() }} / {{ $server->getTotal() }}
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">@lang('content.monitoring.cancel')</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['servers']
    }
</script>