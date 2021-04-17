<template>
    <layout>
        <p class="ml-lg-16">{{ bookCount }}件の読書情報が記録されています。</p>
        <!-- 読書情報を一覧表示（キーはid）-->
        <book-info
            v-for="(b, i) of books"
            :linkable="true"
            :book="b"
            :index="i + 1"
            :key="b.id"
        ></book-info>
        <!-- ページャを生成 -->
        <v-pagination
            v-model="page_data"
            class="mt-5"
            :length="pageCount"
            :total-visible="10"
            :next-icon="mdiChevronRight"
            :prev-icon="mdiChevronLeft"
        ></v-pagination>

        <v-snackbar
          v-model="success"
          right
          top
          :timeout="4000"
          color="green"
        >
          <h4 class="h4">Reading Recoder</h4>
          <p>読書情報の登録／更新に成功しました。</p>
        </v-snackbar>
    </layout>
</template>

<script>
import Layout from '@/Layouts/Layout'
import BookInfo from '@/Components/BookInfo.vue'

import { mdiChevronRight, mdiChevronLeft } from '@mdi/js';

export default {
    name: 'home',
    components: {
        Layout,
        BookInfo,
    },
    props: {
        books: {
            type: Array,
        },
        bookCount: {
            type: Number,
            default: 0,
        },
        page: {
            type: Number,
            default: 1,
        },
        per_page: {
            type: Number,
            default: 15,
        },
        snackbar: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            mdiChevronRight, mdiChevronLeft,
            page_data: this.prop,
            success: this.snackbar,
        }
    },
    computed:{
        pageCount() {
            return Math.ceil(this.bookCount / this.per_page);
        }
    },
    watch: {
        page_data(val) {
            this.$inertia.get(route('home'), {
                'page': val,
            })
        }
    }
}
</script>