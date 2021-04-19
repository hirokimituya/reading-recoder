<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      app
      color="green lighten-4"
    >
      <v-list nav>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          @click="onLink(item.link)"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-menu
          transition="slide-y-transition"
          bottom
          offset-y
        >
          <template #activator="{ on, attrs }">
            <v-list-item
              link
              v-bind="attrs"
              v-on="on"
            >
              <v-list-item-icon>
                <v-icon>{{ mdiFaceAgent }}</v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Support</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <v-list color="green">
            <v-list-item
              v-for="(item, i) in subItems"
              :key="i"
              :href="item.link"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-list>   
    </v-navigation-drawer>

    <v-app-bar app color="green">
      <v-app-bar-nav-icon @click="drawer = !drawer"><v-icon color="white">{{ mdiMenu }}</v-icon></v-app-bar-nav-icon>

      <v-toolbar-title class="white--text row-pointer" @click="onLink('home')">Reading Recoder</v-toolbar-title>
    </v-app-bar>

    <v-main v-scroll="onscroll">
      <v-container>
        <slot></slot>
        <!-- 上に戻るボタン -->
        <v-fab-transition>
          <v-btn
            v-scroll="onscroll"
            v-show="btn_flg"
            transition="fade-transition"
            fab
            large
            fixed
            right
            bottom
            color="green"
            @click="$vuetify.goTo(0)"
          >
            <v-icon color="white">{{ mdiChevronUp }}</v-icon>
          </v-btn>
        </v-fab-transition>
      </v-container>
    </v-main>
    <v-footer 
      padless
      class="mt-16"
    >
      <v-col
        class="text-center"
        cols="12"
      >
        {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
import { mdiMenu, mdiHome, mdiMagnify, mdiFaceAgent, mdiChevronUp } from '@mdi/js';

export default {
  data() {
    return {
      mdiMenu, mdiFaceAgent, mdiChevronUp,
      drawer: null,
      right: null,
      items: [
        { title: 'Home', icon: mdiHome, link: 'home' },
        { title: 'Search', icon: mdiMagnify, link: 'search' },
      ],
      subItems: [
        { title: 'Author', link: 'https://wings.msn.to/' },
        { title: 'Publisher', link: 'https://www.sbcr.jp/'  },
      ],
      btn_flg: false,
    }
  },
  methods: {
    onLink(link) {
      if (link == undefined) {
        return false;
      }
      console.log('test' + route(link))
      this.$inertia.get(route(link));
    },
    onscroll() {
      if (window.scrollY > 500) {
        this.btn_flg = true
      }
      else {
        this.btn_flg = false
      }
    }
  }
}
</script>

<style scoped>
.row-pointer {
  cursor: pointer;
}
</style>
