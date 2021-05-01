<template>
  <layout>
    <!-- 検索フォームの定義 -->
    <v-row class="mt-1 ml-lg-16">
        <v-form>
            <v-col cols="8" sm="6" md="4" lg="3">
              <v-text-field 
                label="キーワード"
                v-model="keyword"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-btn
                color="green"
                class="white--text"
                type="submit"
                @click="search"
              >
                検索
              </v-btn>
            </v-col>
        </v-form>
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
    <div v-if="noresult" class="ml-16 mt-10">
      <p>検索結果を取得できませんでした。</p>
      <p>検索キーワードを変更して再度検索してください。</p>
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

    <!-- エラー通知 -->
    <v-snackbar
      v-model="snackbar"
      right
      top
      :timeout="4000"
      color="red"
    >
      <h4 class="h4">Reading Recoder</h4>
      <p>検索キーワードを入力してください。</p>
    </v-snackbar>
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
  remember: [
    'keyword',
    'books',
    'page',
    'pageCount'
  ],
  data() {
    return {
      mdiChevronRight, mdiChevronLeft,
      keyword: '',
      keyword_change_flg: false,
      books: [],
      progress: false,
      page: 1,
      change_btn_flg: false,
      pageCount: 0,
      snackbar: false,
      noresult: false,
    }
  },
  computed: {
    index() {
      return (this.page - 1) * 10
    }
  },
  methods: {
    async fetch() {
      this.progress = true
      this.noresult = false

      this.books = []

      const response = await axios.get(`https://www.googleapis.com/books/v1/volumes?q=${this.keyword}&startIndex=${this.index}`)

      if (!response.data.items) {
        this.noresult = true
        this.progress = false
        return
      }

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
          image: img ? img.smallThumbnail.replace('http://', 'https://') : '',
        })
      }

      this.progress = false
    },
    async search() {
      if (!this.keyword) {
        this.snackbar = true
        return
      }

      if (this.keyword_change_flg && this.page != 1) {
        this.change_btn_flg = true
        this.page = 1
      }

      await this.fetch();

      this.keyword_change_flg = false
    }
  },
  watch: {
    page(val) {
      if (this.change_btn_flg && val == 1) {
        this.change_btn_flg = false
        return 
      }
      this.fetch()
      this.$vuetify.goTo(0)
    },
    keyword() {
      this.keyword_change_flg = true
    }
  }
}
</script>
