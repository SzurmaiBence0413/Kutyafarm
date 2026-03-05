<template>
  <section class="community-section py-5">
    <div class="container text-center">
      <h2 class="mb-2">{{ title }}</h2>
      <p class="community-text mx-auto mb-4">{{ text }}</p>

      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <RouterLink to="/dogs" class="btn btn-primary">Browse Dogs</RouterLink>
        <RouterLink to="/registration" class="btn btn-outline-primary">Get Started</RouterLink>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutCommunity",
  props: {
    title: { type: String, required: true },
    text: { type: String, required: true },
  },
};
</script>

<style scoped>
.community-section {
  background: #f7f3e8;
}

h2 {
  font-size: 1.35rem;
  font-weight: 700;
}

.community-text {
  max-width: 820px;
  color: #5b667c;
}

.btn-primary {
  background: #ff8a00;
  border-color: #ff8a00;
}

.btn-outline-primary {
  color: #ff8a00;
  border-color: #ff8a00;
}

.btn-outline-primary:hover {
  background: #ff8a00;
  color: #fff;
}
</style>
