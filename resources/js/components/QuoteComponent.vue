<template>
    <div>
        <div class="container">
            <div class="d-flex" style="height: 100vh;">
                <div class="m-auto">
                    <div class="row">
                    <div class="col">
                        <img class="w-100" :src="data.link" alt="">
                    </div>
                    <div class="col">
                        <h1 class="display-2 font-bold">Quote</h1>
                        <p class="display-4">{{ data.text }}</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['data']
}
</script>
<style>
.quote-container {
    position: absolute;
    width: 80%;
    height: 80vh;
    background: rgba(0, 0, 0, 0.3);
    top: 10%;
    left: 10%;
    text-align: center;
}

.q-text {
    position: absolute;
    top: 25%;
    color: white;
}
</style>