<template>
  <div id="app">
    <Menu />

    <div class="main-content">
      <RouterView />
      <ToastContanier />
    </div>

    <Footer />
  </div>
</template>

<script>
import Menu from "./components/Layout/Menu.vue";
import Header from "./components/Layout/Header.vue";
import Footer from "./components/Layout/Footer.vue";
import Breadcrumb from "./components/Layout/Breadcrumb.vue";
import ToastContanier from "./components/Message/ToastContanier.vue";
import Hero from "./components/Layout/Hero.vue";
export default {
  components: {
    Menu,
    Header,
    Breadcrumb,
    ToastContanier,
    Hero,
    Footer,
  },
  data() {
    return {};
  },
};
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
}</style>