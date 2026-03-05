<template>
  <article class="team-card h-100">
    <div class="team-image-wrap" :class="{ fallback: !member.image }">
      <img v-if="member.image" :src="member.image" :alt="member.name" class="team-image" />
      <i v-else class="bi bi-people"></i>
    </div>
    <div class="team-content text-center">
      <h3>{{ member.name }}</h3>
      <p class="role">{{ member.role }}</p>
      <p class="bio mb-0">{{ member.bio }}</p>
    </div>
  </article>
</template>

<script>
export default {
  name: "AboutTeamCard",
  props: {
    member: { type: Object, required: true },
  },
};
</script>

<style scoped>
.team-card {
  background: #fff;
  border: 1px solid #e7e9ef;
  border-radius: 12px;
  overflow: hidden;
}

.team-image-wrap {
  height: 165px;
  background: #f5f6fa;
  display: flex;
  align-items: center;
  justify-content: center;
}

.team-image-wrap.fallback {
  background: #ffedc9;
  color: #ff8a00;
  font-size: 2.2rem;
}

.team-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.team-content {
  padding: 14px;
}

h3 {
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 4px;
}

.role {
  color: #ff8a00;
  font-weight: 600;
  margin-bottom: 4px;
}

.bio {
  color: #68748b;
  font-size: 0.85rem;
}
</style>
