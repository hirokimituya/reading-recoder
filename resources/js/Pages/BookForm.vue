<template>
  <layout>
    <!-- 選択中の書籍を表示 -->
    <book-info :book="book"></book-info>
    <div class="ml-lg-16">
      <!-- レビュー入力のためのフォームを準備 -->
      <v-form
        @submit.prevent="onsubmit"
        v-model="valid"
        class="mt-10"
      >
        <!-- 読了日 -->
        <v-row>
          <v-col cols="8" sm="6" md="4" lg="3">
            <v-menu
              v-model="menu"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template #activator="{ on, attrs }">
                <v-text-field
                  v-model="form.date"
                  label="読了日"
                  :prepend-icon="mdiCalendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.date"
                no-title
                scrollable
                @input="menu = false"
                :prev-icon="mdiChevronLeft"
                :next-icon="mdiChevronRight"
              ></v-date-picker>
            </v-menu>
          </v-col>
        </v-row>
        <!-- 感想 -->
        <v-row>
          <v-col cols="12" md="9" lg="8">
            <v-textarea
              v-model="form.content"
              label="感想"
              :rules="contentRules"
              :counter="255"
            ></v-textarea>
          </v-col>
        </v-row>

        <!-- 登録ボタン -->
        <v-btn
          type="submit"
          color="green"
          class="white--text my-5"
          :disabled="form.processing"
        >
          登録
        </v-btn>
      </v-form>

      <!-- コメント表示 -->
      <h3 class="h4 my-5">過去の感想</h3>
      <p v-if="!comments">感想はまだ登録されていません。</p>
      <v-row
        v-for="comment in comments"
        :key="comment.id"
      >
        <v-col cols="12" md="9" lg="8">
          <v-card>
            <v-card-text>
              {{ comment.content }}  
            </v-card-text>
            <v-card-subtitle>
              {{ comment.date }}
            </v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>
    </div>

    <!-- バリデーションエラー通知 -->
    <v-snackbar
      v-model="error"
      right
      top
      :timeout="4000"
      color="red"
    >
      <v-icon class="d-inline">{{ mdiAlertOutline }}</v-icon>
      <h4 class="h4 d-inline">Reading Recoder</h4>
      <div>{{ form.errors.date }}</div>
      <div>{{ form.errors.content }}</div>
    </v-snackbar>
  </layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import BookInfo from '@/Components/BookInfo.vue'

import { mdiChevronRight, mdiChevronLeft, mdiCalendar, mdiAlertOutline } from '@mdi/js';

export default {
  components: {
    Layout,
    BookInfo
  },
  props: {
    book: {
      type: Object,
      required: true,
    },
    comments: {
      type: Array,
      default: null,
    },
  },
  data() {
    return {
      mdiChevronRight, mdiChevronLeft, mdiCalendar, mdiAlertOutline,
      form: this.$inertia.form({
        date: new Date().toISOString().substr(0, 10),
        content: '',
      }),
      menu: false,
      valid: false,
      contentRules: [
        v => !!v || 'メモが未入力です。',
        v => v.length <= 255 || '255文字以下で入力してください。',
      ],
      error: false,
    }
  },
  methods: {
    onsubmit() {
      this.form.transform(data => ({
        ...data,
        ...this.book,
      }))
        .post('/form', { 
          preserveScroll: true,
          onError: errors => {
            if (errors.date || errors.content) {
              this.error = true
            }
          },
        });
    }
  }
}
</script>