<template>
  <section class="about-hero text-center text-white py-5">
    <div class="container">
      <h1 class="mb-2">{{ title }}</h1>
      <p class="mb-0">{{ subtitle }}</p>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutHero",
  props: {
    title: { type: String, required: true },
    subtitle: { type: String, required: true },
  },
};
</script>

<style scoped>
.about-hero {
  background: linear-gradient(180deg, #ff8700 0%, #ff9800 100%);
}

h1 {
  font-size: 2rem;
  font-weight: 700;
}

p {
  opacity: 0.95;
}
</style>
