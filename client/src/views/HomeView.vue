<template>
  <div>
    <!-- Hero Section -->
    <Hero/>
    <Carousel/>
  
  </div>
</template>

<script>
import Hero from '../components/Layout/Hero.vue'; 
import Carousel from '@/components/Layout/Carousel.vue';
export default {
  components: {
    Hero,
    Carousel  
  }
};
</script>

<style>
</style>