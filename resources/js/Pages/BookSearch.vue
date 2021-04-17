<template>
  <layout>
    <!-- 検索フォームの定義 -->
    <v-row class="mt-1">
      <v-col cols="8" sm="6" md="4">
        <v-text-field 
          label="キーワード"
          v-model="keyword"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-btn
          color="green"
          class="white--text"
          @click="search"
        >
          検索
        </v-btn>
      </v-col>
    </v-row>
    <!-- マッチした書籍情報をリスト表示 -->
    <div class="text-center">
    <v-progress-circular
      v-show="progress"
      indeterminate
      color="teal"
    >
    </v-progress-circular>
    </div>
    <book-info
      v-for="(b, i) of books"
      :linkable="true"
      :book="b"
      :index="i + 1"
      :key="b.isbn"
    ></book-info>
    <!-- ページャを生成 -->
    <v-pagination
        v-show="books.length"
        v-model="page"
        class="mt-5"
        :length="pageCount"
        :total-visible="10"
        :next-icon="mdiChevronRight"
        :prev-icon="mdiChevronLeft"
    ></v-pagination>
  </layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import BookInfo from '@/Components/BookInfo.vue'

import { mdiChevronRight, mdiChevronLeft } from '@mdi/js';

export default {
  name: 'book-search',
  components: { 
    Layout,
    BookInfo 
  },
  data() {
    return {
      mdiChevronRight, mdiChevronLeft,
      keyword: 'vue.js',
      books: [],
      progress: false,
      page: 1,
      pageCount: 0,
    }
  },
  computed: {
    index() {
      return (this.page - 1) * 10
    }
  },
  methods: {
    async search() {
      this.progress = true

      this.books = []

      const response = await axios.get(`https://www.googleapis.com/books/v1/volumes?q=${this.keyword}&startIndex=${this.index}`)

      this.pageCount = Math.ceil(response.data.totalItems / 10) - 30

      for (let b of response.data.items) {
        let authors = b.volumeInfo.authors
        let price = b.saleInfo.listPrice
        let img = b.volumeInfo.imageLinks
        this.books.push({
          id: b.id,
          title: b.volumeInfo.title,
          author: authors ? authors.join(',') : '',
          price: price ? price.amount : '-',
          publisher: b.volumeInfo.publisher,
          published: b.volumeInfo.publishedDate,
          image: img ? img.smallThumbnail : '',
        })
      }

      this.progress = false
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    }
  },
  watch: {
    page() {
      this.search()
      this.scrollToTop()
    }
  }
}
</script>