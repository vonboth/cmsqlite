<script>
export default {
    name: 'PageStatistics',
    inject: ['translations', 'dayjs'],
    props: {
        articles: {
            type: Array,
            required: true
        }
    }
}
</script>

<template>
  <div class="card">
    <div class="card-content" id="start__last_edit_articles">
      <span class="card-title">{{ translations.last_edited_articles }}</span>
      <p></p>
      <ul class="collection">
        <li class="collection-item"
            v-for="article in articles">
          <a :href="`/admin/articles/edit/${article.id}`">{{article.title}}</a>
          <span class="right">{{ dayjs(article.updated).format(translations.formats.date_time) }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
</style>
