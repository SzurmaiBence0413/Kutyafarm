<template>
  <section class="container py-5 text-center">
    <h2 class="mb-3">{{ title }}</h2>
    <p v-for="(paragraph, index) in paragraphs" :key="index" class="story-p mx-auto">
      {{ paragraph }}
    </p>
  </section>
</template>

<script>
export default {
  name: "AboutStory",
  props: {
    title: { type: String, required: true },
    paragraphs: { type: Array, required: true },
  },
};
</script>

<style scoped>
h2 {
  font-size: 1.35rem;
  font-weight: 700;
}

.story-p {
  max-width: 780px;
  color: #566176;
  line-height: 1.6;
}
</style>
