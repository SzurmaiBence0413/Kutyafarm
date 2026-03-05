<template>
  <section class="about-page">
    <div v-if="loading" class="container py-5 text-center">
      <div class="spinner-border text-warning" role="status"></div>
    </div>

    <div v-else-if="error" class="container py-5">
      <div class="alert alert-danger">Could not load About page content.</div>
    </div>

    <template v-else-if="page">
      <AboutHero :title="page.hero.title" :subtitle="page.hero.subtitle" />
      <AboutMission
        :title="page.mission.title"
        :paragraphs="page.mission.paragraphs"
        :image="page.mission.image"
      />
      <AboutValues :items="page.values" />
      <AboutStory :title="page.story.title" :paragraphs="page.story.paragraphs" />
      <AboutImpact :items="page.impact" />
      <AboutTeam
        :title="page.team.title"
        :subtitle="page.team.subtitle"
        :members="page.team.members"
      />
      <AboutCommunity :title="page.community.title" :text="page.community.text" />
    </template>
  </section>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useAboutStore } from "@/stores/aboutStore";
import AboutHero from "@/components/About/AboutHero.vue";
import AboutMission from "@/components/About/AboutMission.vue";
import AboutValues from "@/components/About/AboutValues.vue";
import AboutStory from "@/components/About/AboutStory.vue";
import AboutImpact from "@/components/About/AboutImpact.vue";
import AboutTeam from "@/components/About/AboutTeam.vue";
import AboutCommunity from "@/components/About/AboutCommunity.vue";

export default {
  name: "AboutView",
  components: {
    AboutHero,
    AboutMission,
    AboutValues,
    AboutStory,
    AboutImpact,
    AboutTeam,
    AboutCommunity,
  },
  computed: {
    ...mapState(useAboutStore, ["page", "loading", "error"]),
  },
  methods: {
    ...mapActions(useAboutStore, ["fetchAboutPage"]),
  },
  async mounted() {
    await this.fetchAboutPage();
  },
};
</script>

<style scoped>
.about-page {
  background: #f4f6f8;
}
</style>
