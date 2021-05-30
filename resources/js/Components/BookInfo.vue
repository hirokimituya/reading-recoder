<template>
  <v-row justify="center">
    <v-col cols="12" lg="10">
      <v-card class="mx-auto mt-5" v-on:[eventName]="onclick">
        <v-row justify="space-between" align="center">
          <v-col cols="4" md="2">
            <v-img 
              :src="book.image || '/storage/noimage.png'"
              @load="image_load = true"
            >
              <v-row
                class="fill-height ma-0"
                align="center"
                justify="center"
              >
                <v-progress-circular
                  v-show="!image_load"
                  indeterminate
                  color="grey lighten-1"
                ></v-progress-circular>
              </v-row>
            </v-img>
          </v-col>
          <v-col cols="8" md="9">
            <ul>
              <li v-if="index">{{ index }}.</li>
              <li>{{ book.title }}（{{ book.price }}円）</li>
              <li>{{ book.author }} 著</li>
              <li>{{ book.publisher }} /刊</li>
              <li>{{ book.published }} /発売</li>
            </ul>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'book-info',
  props: {
    index: {
      type: Number,
    },
    linkable: {
      type: Boolean,
      default: false,
    },
    book: {
      type: Object
    },
  },
  data() {
    return {
      image_load: false
    }
  },
  computed: {
    eventName() {
      return this.linkable ? 'click' : null
    }
  },
  methods: {
    onclick() {
      if (this.linkable) {
        this.$inertia.get(route('form'), this.book)
      }
    }
  }
}
</script>