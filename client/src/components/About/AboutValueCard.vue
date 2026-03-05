<template>
  <article class="value-card text-center h-100">
    <div class="icon-wrap"><i class="bi" :class="icon"></i></div>
    <h3>{{ title }}</h3>
    <p class="mb-0">{{ text }}</p>
  </article>
</template>

<script>
export default {
  name: "AboutValueCard",
  props: {
    icon: { type: String, required: true },
    title: { type: String, required: true },
    text: { type: String, required: true },
  },
};
</script>

<style scoped>
.value-card {
  background: #fff;
  border: 1px solid #e6e8ed;
  border-radius: 12px;
  padding: 18px;
  box-shadow: 0 8px 18px rgba(20, 24, 31, 0.05);
}

.icon-wrap {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  background: #fff2df;
  color: #ff8a00;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
  font-size: 1.3rem;
}

h3 {
  font-size: 1.05rem;
  font-weight: 700;
  margin-bottom: 8px;
}

p {
  color: #637088;
  font-size: 0.92rem;
}
</style>
