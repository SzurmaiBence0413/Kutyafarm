<template>
  <article class="dog-card h-100">
    <div class="dog-image-wrap">
      <img :src="dog.image" :alt="dog.name" class="dog-image" />

      <button
        class="favorite-btn"
        :class="{ active: isFavorite }"
        @click="$emit('toggle-favorite', dog.id)"
        type="button"
      >
        <i class="bi" :class="isFavorite ? 'bi-heart-fill' : 'bi-heart'"></i>
      </button>
    </div>

    <div class="dog-content">
      <div class="dog-head">
        <h3>{{ dog.name }}</h3>
        <p class="price">${{ dog.price }}</p>
      </div>

      <p class="breed">{{ dog.breed }}</p>
      <p class="description">{{ dog.description }}</p>
      <p class="meta">
        <i class="bi bi-geo-alt"></i>
        {{ dog.location }}
      </p>

      <div v-if="canManage" class="manage-actions mt-3">
        <button class="btn btn-sm btn-outline-warning" @click="$emit('edit', dog)">
          Edit
        </button>
        <button class="btn btn-sm btn-outline-danger" @click="$emit('delete', dog.id)">
          Delete
        </button>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: "DogCard",
  props: {
    dog: {
      type: Object,
      required: true,
    },
    isFavorite: {
      type: Boolean,
      required: true,
    },
    canManage: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["toggle-favorite", "edit", "delete"],
};
</script>

<style scoped>
.dog-card {
  background: #fff;
  border: 1px solid #e5e8ee;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 8px 18px rgba(16, 24, 40, 0.06);
}

.dog-image-wrap {
  position: relative;
}

.dog-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.favorite-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 40px;
  height: 40px;
  border: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.94);
  color: #6e7788;
  font-size: 1.2rem;
}

.favorite-btn.active {
  color: #ff6a00;
}

.dog-content {
  padding: 16px 18px 18px;
}

.dog-head {
  display: flex;
  justify-content: space-between;
  gap: 8px;
  align-items: center;
}

.dog-head h3 {
  margin: 0;
  font-size: 1.45rem;
}

.price {
  margin: 0;
  color: #ff6a00;
  font-size: 1.95rem;
  line-height: 1;
  font-weight: 500;
}

.breed {
  margin: 8px 0 10px;
  font-size: 1.03rem;
  color: #556074;
}

.description {
  margin: 0 0 8px;
  color: #4f5665;
  line-height: 1.45;
}

.meta {
  margin: 0;
  color: #6f7a8e;
  display: flex;
  align-items: center;
  gap: 6px;
}

.manage-actions {
  display: flex;
  gap: 8px;
}

@media (max-width: 768px) {
  .dog-image {
    height: 220px;
  }

  .price {
    font-size: 1.7rem;
  }
}
</style>
