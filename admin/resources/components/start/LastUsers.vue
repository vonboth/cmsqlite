<script>
export default {
    name: 'LastUsers',
    inject: ['translations', 'dayjs'],
    props: {
        users: {
            type: Array,
            required: true
        }
    }
}
</script>

<template>
    <div class="card">
        <div class="card-content" id="start__loggedin_users">
            <span class="card-title">{{ translations.last_loggedin_users }}</span>
            <p></p>
            <ul class="collection">
                <li class="collection-item" v-for="user in users">
                    <span>{{ user.firstname }} {{ user.lastname }}</span>
                    <span class="right">{{ dayjs(user.lastlogin).format(translations.formats.date_time) }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
