<template>
    <div class="l-shop-collapse">
        <p class="a-b-header">{{ title }}</p>
        <p v-for="item in items" v-if="typeof item.subItems === 'undefined'">
            <a :href="item.link" class="btn btn-info btn-block"><i :class="'fa fa-' + item.icon + ' left'"></i>{{ item.caption }}</a>
        </p>
        <div class="ad-btn-block" v-else>
            <button class="btn btn-info btn-block admin-menu-btn" @click="toggle($event.target)"><i :class="'fa fa-' + item.icon + ' left'"></i>{{ item.caption }}</button>
            <ul class="ad-btn-list">
                <li>
                    <a v-for="subItem in item.subItems" :href="subItem.link" class="waves-effect" :target="subItem.target === '_blank' ? '_blank' : '_self'">{{ subItem.caption }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'items'],
        mounted() {
            $('.ad-btn-list').hide();
        },
        methods: {
            toggle(target) {
                $(target).parent().siblings().find('.ad-btn-list').slideUp();
                $(target).siblings().slideToggle();
            }
        }
    }
</script>
