<template>
    <div class="form__field">
        <div class="form__label">
            <strong>Please select template colors: </strong>
        </div>
        <div class="form__input d-flex">
            <v-swatches
                class="mx-4"
                v-model="color"
                show-fallback
                fallback-input-type="color"
                popover-x="left"
            ></v-swatches>
            <v-swatches
                class="mx-4"
                v-model="color2"
                show-fallback
                fallback-input-type="color"
                popover-x="left"
            ></v-swatches>
        </div>
        <div class="mx-4 my-2">
            <button @click="updateColors" class="btn btn-sm btn-primary">Update</button>
        </div>
    </div>
</template>

<script>
import VSwatches from "vue-swatches";
export default {
    components: { VSwatches },
    props:['screen'],
    data() {
        return {
            color: "#A463BF",
            color2: "#A463BF",
            color3: "#A463BF"
        };
    },
    mounted() {
        this.fetchScreen();
    },
    methods: {
        fetchScreen(){
            axios.get(`/screen_resource/${this.screen}`).then((response) => {
                console.log(response.data);
                this.color = response.data.color1;
                this.color2 = response.data.color2;
                this.color3 = response.data.color3;
            })
        },
        updateColors(){
            axios.post(`/update-colors/${this.screen}`, {color1: this.color, color2: this.color2, color3: this.color3}).then((response) => alert('updated successfully')).catch((err) => alert(err));
        }
    },
};
</script>
<style>
.vue-swatches__trigger{
    width: 100px;
    height: 100px;
}
</style>
