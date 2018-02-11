<template>
    <div>
        <div class="content-header text-center z-depth-1">
            <h1><i class="fa fa-wrench fa-left-big"></i>{{ $t('content.admin.control.basic.title') }}</h1>
        </div>
        <div class="card card-block">
            <h4 class="card-title">{{ $t('content.admin.control.basic.shop.title') }}</h4>
            <div class="card-text">
                {{ $t('content.admin.control.basic.shop.edit_info') }}
                <div class="md-form mt-1">
                    <i class="fa fa-font prefix" data-toggle="popover" data-placement="right" data-trigger="hover" :title="$t('components.popover.title')" :data-content="$t('content.admin.control.basic.shop.name_popover')"></i>
                    <input type="text" name="shop_name" id="m-s-shop-name" class="form-control" value="">
                    <label for="m-s-shop-name">{{ $t('content.admin.control.basic.shop.name') }}</label>
                </div>

                <div class="md-form">
                    <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" :title="$t('components.popover.title')" :data-content="$t('content.admin.control.basic.shop.description_popover')"></i>
                    <textarea type="text" name="shop_description" id="m-s-shop-description" class="md-textarea">{{ '' }}</textarea>
                    <label for="m-s-shop-description">{{ $t('content.admin.control.basic.shop.description') }}</label>
                </div>

                <div class="md-form">
                    <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" :title="$t('components.popover.title')" :data-content="$t('content.admin.control.basic.shop.keywords_popover')"></i>
                    <input type="text" name="shop_keywords" id="m-s-shop-keywords" class="form-control" value="">
                    <label for="m-s-shop-keywords">{{ $t('content.admin.control.basic.shop.keywords') }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //
    }
</script>