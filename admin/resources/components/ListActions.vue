<script>
export default {
    name: 'ListActions',
    inject: ['translations'],
    props: {
        dataId: {
            type: [Number, String],
            required: true
        },
        controller: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            required: true
        },
        isSystem: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        onDelete() {
            Swal.fire({
                icon: 'warning',
                title: this.translations.delete_item,
                text: this.translations.delete_question,
                showCancelButton: true,
                cancelButtonText: this.translations.no,
                confirmButtonText: this.translations.yes
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=`/admin/${this.controller}/delete/${this.dataId}`;
                    }
                });
        }
    }
};
</script>

<template>
    <ul class="action-list" id="table_action">
        <li v-if="user.role !== 'admin'">
            <a :href="`/admin/${controller}/view/${dataId}`">
                <i class="material-icons">remove_red_eye</i>
            </a>
        </li>
        <li>
            <a :href="`/admin/${controller}/edit/${dataId}`">
                <i class="material-icons">create</i>
            </a>
        </li>
        <li v-if="!isSystem">
            <a href="#" @click="onDelete">
                <i class="material-icons">delete</i>
            </a>
        </li>
    </ul>
</template>

<style scoped>

</style>
