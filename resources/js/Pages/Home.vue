<template>
    <layout>
        <p>{{ bookCount }}件の読書情報が記録されています。</p>
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
        }
    },
    data() {
        return {
            mdiChevronRight, mdiChevronLeft,
            page_data: this.prop,
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