<template>
<div>
    <div class="form-group">
        <label for="attachment-type">Type</label>
        <select id="attachment-type" class="form-control" v-model="form.type">
            <option value="">Choose</option>
            <option value="image">Image</option>
            <option value="quote">Quote</option>
            <option value="video">Video</option>
        </select>
    </div>
    <div class="form-group">
        <label for="fileuploader">File</label>
        <input type="file" @change="appendImage" class="form-control">
    </div>
    <div class="form-group" v-if="form.type === 'quote'">
        <label for="quote-text">Quote Text</label>
        <textarea v-model="form.text" id="quote-text" cols="10" rows="4" class="form-control"></textarea>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5"><button class="btn btn-primary btn-block" :disabled="!inputValidated()" @click="submitForm">Save</button></div>
    </div>
</div>
</template>

<script>
export default {
    props: ['screen'],
    data(){
        return{
            form: {
                type: null,
                attachment:'',
                duration: 3,
                link: '',
                text: ''
            }
        }
    },
    methods: {
        appendImage: function (e) {
            this.form.attachment = e.target.files[0];
        },
        inputValidated: function(){
            if(this.form.type === null)
                return false;

            if(this.form.text === '' && this.form.type === 'quote')
                return false;

            if((this.form.type === 'twitter' || this.form.type === 'youtube') && this.form.link === '')
                return false;

            if((this.form.type === 'image' || this.form.type === 'video' || this.form.type === 'quote') && this.form.attachment === '')
                return false;

            return true;
        },
        submitForm: function(e){
            e.preventDefault();

            var fd = new FormData();
            fd.append('screen', this.screen);
            Object.keys(this.form).forEach((key) => {
                fd.append(key, this.form[key]);
            });

            axios.post('/attachments', fd).then((response) => {
                window.location = `/screens/${this.screen}`
            });

        }
    }
}
</script>

<style>

</style>
