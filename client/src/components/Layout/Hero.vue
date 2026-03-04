<template>
  <section class="hero">
    <div class="hero-content">
      <h1 class="hero-title" v-html="title"></h1>

      <p class="hero-subtitle">
        {{ description }}
      </p>

      <div class="hero-buttons">
        <RouterLink class="btn btn-primary" :to="buttonLink">
          {{ buttonTitle }}
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: "Find Your Perfect <br /> Companion"
  },
  description: {
    type: String,
    default:
      "Connect with trusted breeders and find healthy, happy puppies looking for their forever home."
  },
  buttonTitle: {
    type: String,
    default: "Browse Dogs →"
  },
  buttonLink: {
    type: String,
    default: "/dogs"
  }
});
</script>
 
<style scoped>
.hero {
  background: linear-gradient(to bottom, #f8af40, #ffffff);

  padding: 120px 20px;

  text-align: center;
}

.hero-content {
  max-width: 800px;

  margin: 0 auto;
}

.hero-title {
  font-size: 48px;

  font-weight: 700;

  margin-bottom: 24px;

  line-height: 1.2;
}

.hero-subtitle {
  font-size: 18px;

  color: #555;

  margin-bottom: 40px;
}

.hero-buttons {
  display: flex;

  justify-content: center;

  gap: 16px;

  flex-wrap: wrap;
}

.btn {
  padding: 12px 24px;

  font-size: 16px;

  border-radius: 8px;

  cursor: pointer;

  border: none;

  transition: all 0.2s ease;
}

.btn-primary {
  background-color: #ff7a00;

  color: white;
}

.btn-primary:hover {
  background-color: #e66d00;
}

.btn-secondary {
  background-color: #e0e0e0;

  color: #333;
}

.btn-secondary:hover {
  background-color: #d5d5d5;
}
</style>
 