<template>
    <div>
        <img src="@assets/img/error.svg"/>
        <h4>Internal server error!</h4>
    </div>
</template>

<style scoped>
    div{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
    }
    img{
        width: 30%;
    }
    h4{
        font-size: 16pt;
        color: rgba(0, 0, 0, 0.87);
    }
</style>