<template>
  <div class="row g-4">
    <div
      class="col-12 col-sm-6 col-lg-4 col-xl-3"
      v-for="dog in dogs"
      :key="dog.id"
    >
      <DogCard
        :dog="dog"
        :isFavorite="isFavorite(dog.id)"
        :canManage="false"
        @toggle-favorite="$emit('toggle-favorite', $event)"
      />
    </div>
  </div>
</template>

<script>
import DogCard from "@/components/Dogs/DogCard.vue";

export default {
  name: "FavoriteDogsGrid",
  components: {
    DogCard,
  },
  props: {
    dogs: {
      type: Array,
      required: true,
    },
    isFavorite: {
      type: Function,
      required: true,
    },
  },
  emits: ["toggle-favorite"],
};
</script>

