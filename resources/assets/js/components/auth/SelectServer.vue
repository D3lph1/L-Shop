<template>
    <div class="full-h flex-center pd-v-form" id="servers-list">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-sm-10 col-11">

            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1><i class="fa fa-check-square-o fa-lg fa-left"></i>{{ $t('content.all.server') }}</h1>
                </div>
                <div class="list-group no-shadow">
                    <a v-for="server in servers" :href="server.url" class="list-group-item waves-effect">
                        <i v-if="!server.enabled" class="fa fa-power-off fa-left" :title="$t('content.monitoring.server_disabled')"></i>
                        {{ server.name }}
                    </a>
                </div>
            </div>
            <div class="card-footer text-center">
                <a v-if="isAuth" :href="routeLogout" class="btn btn-primary btn-lg">{{ $t('content.all.logout') }}<i class="fa fa-sign-out fa-right"></i></a>
                <a v-else-if="!isAuth && allowLogin" :href="routeLogin" class="btn btn-primary btn-lg">{{ $t('content.auth.servers.signin') }}<i class="fa fa-sign-out fa-right"></i></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['servers', 'isAuth', 'allowLogin', 'routeLogin', 'routeLogout']
    }
</script>
