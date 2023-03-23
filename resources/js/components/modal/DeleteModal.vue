<template>
    <div class="modal custom-modal show">
        <div class="modal-dialog" role="document">
            <div class="modal-content tb-trash-popup">
                <div class="modal-header">
                    <button class="close" type="button" @click="onCancel"><span
                        aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">{{ messageData }}</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" @click="onDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DeleteModal",
        props:{
            messageData:String,
        },
        methods: {
            onDelete() {
                this.$emit('confirm-delete');
            },
            onCancel() {
                this.$emit('close-delete');

            }
        }
    }
</script>
