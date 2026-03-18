<template>
  <div>
    <!-- Hero Section -->
    <Hero/>
    <AutoDogCarousel />
  
  </div>
</template>

<script>
import Hero from '../components/Layout/Hero.vue'; 
import AutoDogCarousel from "@/components/Layout/AutoDogCarousel.vue";
export default {
  components: {
    Hero,
    AutoDogCarousel,
  }
};
</script>

<style>
</style>
