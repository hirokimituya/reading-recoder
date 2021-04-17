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

    <v-main>
      <slot></slot>
    </v-main>
  </v-app>
</template>

<script>
import { mdiMenu, mdiHome, mdiMagnify, mdiFaceAgent } from '@mdi/js';

export default {
  data() {
    return {
      mdiMenu,
      mdiFaceAgent,
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
    }
  },
  methods: {
    onLink(link) {
      if (link == undefined) {
        return false;
      }
      this.$inertia.get(route(link));
    }
  }
}
</script>

<style scoped>
.row-pointer {
  cursor: pointer;
}
</style>
