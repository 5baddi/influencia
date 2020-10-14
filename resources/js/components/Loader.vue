<template>
    <div class="loader" :class="{ 'loader--visible': visible }">
        <i class="fas fa-spinner fa-spin"></i>
    </div>
</template>

<script>
export default {
    name: "Loader",
    props: ["visible"]
}
</script>

<style lang="scss">
.loader {
    background: rgba(255, 255, 255, 0.8);
    transition: 0.15s ease-in opacity;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 62pt;
    color: #039be5;
    &--visible {
        opacity: 1;
        pointer-events: all;
    }
}
</style>