<template>
    <div class="loader" :class="{ 'loader--hidden': !visible }">
        <i class="fas fa-spinner fa-spin"></i>
    </div>
</template>

<script>
export default {
    name: "Loader",
    props: ["visible"],
}
</script>

<style lang="scss">
.loader {
    background: white;
    transition: 0.15s ease-in opacity;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    opacity: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 62pt;
    color: #039be5;
    overflow: hidden;
    z-index: 100000;
    &--hidden {
        opacity: 0;
        pointer-events: all;
    }
}
</style>