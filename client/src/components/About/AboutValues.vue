<template>
  <section class="values-section py-5">
    <div class="container">
      <h2 class="text-center mb-4">{{ title }}</h2>
      <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-3" v-for="item in items" :key="item.id">
          <AboutValueCard :icon="item.icon" :title="item.title" :text="item.text" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import AboutValueCard from "@/components/About/AboutValueCard.vue";

export default {
  name: "AboutValues",
  components: { AboutValueCard },
  props: {
    title: { type: String, default: "Our Core Values" },
    items: { type: Array, required: true },
  },
};
</script>

<style scoped>
.values-section {
  background: #f7f3e8;
}

h2 {
  font-size: 1.35rem;
  font-weight: 700;
}
</style>
