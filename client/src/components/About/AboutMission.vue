<template>
  <section class="container py-5">
    <div class="row g-4 align-items-center">
      <div class="col-12 col-lg-6">
        <h2>{{ title }}</h2>
        <p v-for="(paragraph, index) in paragraphs" :key="index">{{ paragraph }}</p>
      </div>
      <div class="col-12 col-lg-6">
        <img :src="image" alt="Our mission" class="mission-image" />
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutMission",
  props: {
    title: { type: String, required: true },
    paragraphs: { type: Array, required: true },
    image: { type: String, required: true },
  },
};
</script>

<style scoped>
h2 {
  font-size: 1.35rem;
  margin-bottom: 14px;
  font-weight: 700;
}

p {
  color: #4f5a6d;
  line-height: 1.6;
}

.mission-image {
  width: 100%;
  border-radius: 12px;
  min-height: 280px;
  object-fit: cover;
}
</style>
