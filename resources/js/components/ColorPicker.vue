<template>
    <div class="form__field">
        <div class="form__label">
            <strong>Please choose a color:</strong>
        </div>
        <div class="form__input">
            <v-swatches
                v-model="color"
                show-fallback
                fallback-input-type="color"
                popover-x="left"
            ></v-swatches>
        </div>
    </div>
</template>

<script>
import VSwatches from "vue-swatches";
export default {
    components: { VSwatches },
    data() {
        return {
            color: "#A463BF"
        };
    }
};
</script>
