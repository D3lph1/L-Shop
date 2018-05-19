<template>
    <section class="shop-grid">
        <slot></slot>
    </section>
</template>

<style lang="less" scoped>
    .shop-grid {
        padding: 15px;
        display: grid;
        grid-gap: 20px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        justify-items: center;
    }
</style>
