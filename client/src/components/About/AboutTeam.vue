<template>
  <section class="container py-5 text-center">
    <h2 class="mb-2">{{ title }}</h2>
    <p class="team-subtitle mx-auto mb-4">{{ subtitle }}</p>

    <div class="row g-3 justify-content-center">
      <div class="col-12 col-sm-6 col-lg-3" v-for="member in members" :key="member.id">
        <AboutTeamCard :member="member" />
      </div>
    </div>
  </section>
</template>

<script>
import AboutTeamCard from "@/components/About/AboutTeamCard.vue";

export default {
  name: "AboutTeam",
  components: { AboutTeamCard },
  props: {
    title: { type: String, required: true },
    subtitle: { type: String, required: true },
    members: { type: Array, required: true },
  },
};
</script>

<style scoped>
h2 {
  font-size: 1.35rem;
  font-weight: 700;
}

.team-subtitle {
  max-width: 750px;
  color: #637088;
}
</style>
