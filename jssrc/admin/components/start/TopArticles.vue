<script>
import Swal from 'sweetalert2';
import moment from 'moment';

export default {
    computed: {
        moment() {
            return moment
        }
    },
    inject: ['translations'],

    props: {
        articles: {
            type: Array,
            required: true
        }
    },

    methods: {
        onResetHits() {
            Swal.fire({
                title: translations.reset_hits,
                icon: 'warning',
                text: translations.reset_hits_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/admin/start/reset-hits';
                    }
                });
        }
    }
};
</script>

<template>
    <div class="card">
        <div class="card-content" id="start__top_articles">
            <div>
                <span class="card-title">
                    <span>{{ translations.top_articles }}</span>
                        <a class="right pointer"
                           @click="onResetHits"
                           :title="translations.reset_hits"><i class="material-icons">history</i></a>
                </span>
            </div>
            <p></p>
            <ul class="collection">
                <li v-if="articles.length === 0">{{ translations.no_data }}</li>
                <li class="collection-item" v-else v-for="article in articles">
                    <span>{{ article.title }}</span>
                    <span class="ml1rem">({{ article.hits }})</span>
                    <span class="right">{{ moment(article.updated).format(translations.formats.date_time) }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
