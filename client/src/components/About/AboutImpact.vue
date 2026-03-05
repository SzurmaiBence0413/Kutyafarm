<template>
  <section class="impact-section py-5 text-white">
    <div class="container">
      <h2 class="text-center mb-4">Our Impact</h2>
      <div class="row text-center g-4">
        <div class="col-6 col-lg-3" v-for="item in items" :key="item.id">
          <p class="impact-value mb-1">{{ item.value }}</p>
          <p class="impact-label mb-0">{{ item.label }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutImpact",
  props: {
    items: { type: Array, required: true },
  },
};
</script>

<style scoped>
.impact-section {
  background: linear-gradient(180deg, #ff8700 0%, #ff9800 100%);
}

h2 {
  font-size: 1.25rem;
  font-weight: 700;
}

.impact-value {
  font-size: 2rem;
  font-weight: 700;
}

.impact-label {
  opacity: 0.96;
}
</style>
