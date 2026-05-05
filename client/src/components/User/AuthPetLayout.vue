<template>
  <section class="auth-hero">
    <div class="overlay"></div>
    <div class="container py-5 position-relative">
      <div class="panel ms-auto me-auto">
        <h2 class="panel-title">{{ subtitle }}</h2>
        <slot />
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "AuthPetLayout",
  props: {
    subtitle: {
      type: String,
      default: "Login",
    },
  },
};
</script>

<style scoped>
.auth-hero {
  position: relative;
  min-height: calc(100vh - 70px);
  background-image: url("https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=1800&q=80");
  background-size: cover;
  background-position: center;
  color: #fff;
}

.overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(5, 35, 13, 0.52), rgba(4, 20, 11, 0.74));
}

.title {
  letter-spacing: 4px;
  text-transform: uppercase;
  font-size: clamp(1.4rem, 2.8vw, 2.3rem);
  margin-bottom: 28px;
}

.panel {
  max-width: 560px;
  background: rgba(8, 30, 14, 0.68);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 10px;
  padding: 26px 24px;
  backdrop-filter: blur(2px);
}

.panel-title {
  text-transform: uppercase;
  color: #ffd34f;
  letter-spacing: 1px;
  font-size: 1.45rem;
  margin-bottom: 20px;
  text-align: center;
}
</style>
