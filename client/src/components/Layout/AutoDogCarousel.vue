<template>
  <div
    id="dogCarousel"
    ref="carouselEl"
    class="carousel slide mt-3"
    data-bs-ride="carousel"
    data-bs-interval="3200"
    data-bs-pause="false"
  >
    <div class="carousel-inner">
      <div
        v-for="(group, index) in groupedCards"
        :key="index"
        class="carousel-item"
        :class="{ active: index === 0 }"
      >
        <div class="container">
          <div class="row">
            <div
              v-for="card in group"
              :key="card.id"
              class="col-12 col-sm-6 col-lg-4 mb-3"
            >
              <div class="card h-100 dog-card">
                <img :src="card.img" class="card-img-top" :alt="card.title" />
                <div class="card-body">
                  <h5 class="card-title">{{ card.title }}</h5>
                  <p class="card-text mb-0">{{ card.text }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button
      v-if="groupedCards.length > 1"
      class="carousel-control-prev"
      type="button"
      data-bs-target="#dogCarousel"
      data-bs-slide="prev"
    >
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button
      v-if="groupedCards.length > 1"
      class="carousel-control-next"
      type="button"
      data-bs-target="#dogCarousel"
      data-bs-slide="next"
    >
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</template>

<script>
import { Carousel as BootstrapCarousel } from "bootstrap";
import { useDogBrowseStore } from "@/stores/dogBrowseStore";

const fallbackCards = [
  {
    id: "fallback-1",
    title: "Golden Retriever",
    text: "Friendly, gentle, and always ready for a happy run in the park.",
    img: "https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: "fallback-2",
    title: "Border Collie",
    text: "Smart, focused, and full of playful energy all day long.",
    img: "https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: "fallback-3",
    title: "Corgi",
    text: "Small legs, big personality, and a smile that steals attention.",
    img: "https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: "fallback-4",
    title: "Husky",
    text: "Adventurous spirit with bright eyes and a love for the outdoors.",
    img: "https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: "fallback-5",
    title: "Beagle",
    text: "Curious nose, cheerful heart, and a charming family companion.",
    img: "https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=900&q=80",
  },
  {
    id: "fallback-6",
    title: "Shiba Inu",
    text: "Confident, alert, and full of character in every look.",
    img: "https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=900&q=80",
  },
];

export default {
  data() {
    return {
      cardsPerSlide: 3,
      carouselInstance: null,
    };
  },

  computed: {
    cards() {
      const dogBrowseStore = useDogBrowseStore();
      const dogs = dogBrowseStore.dogs.slice(0, 6).map((dog) => ({
        id: dog.id,
        title: dog.name || dog.breed || "Dog",
        text: dog.description || `${dog.breed || "Lovely dog"} looking for a home.`,
        img: dog.image,
      }));

      return dogs.length ? dogs : fallbackCards;
    },

    groupedCards() {
      const result = [];

      for (let i = 0; i < this.cards.length; i += this.cardsPerSlide) {
        result.push(this.cards.slice(i, i + this.cardsPerSlide));
      }

      return result;
    },
  },

  async mounted() {
    const dogBrowseStore = useDogBrowseStore();

    if (!dogBrowseStore.dogs.length && !dogBrowseStore.loading) {
      try {
        await dogBrowseStore.fetchDogs();
      } catch (error) {
        // Keep fallback cards on screen if loading fails.
      }
    }

    this.$nextTick(() => {
      this.setupCarousel();
    });
  },

  updated() {
    if (this.groupedCards.length > 1 && !this.carouselInstance) {
      this.$nextTick(() => {
        this.setupCarousel();
      });
    }
  },

  beforeUnmount() {
    this.destroyCarousel();
  },

  methods: {
    setupCarousel() {
      if (!this.$refs.carouselEl || this.groupedCards.length <= 1) {
        return;
      }

      this.destroyCarousel();
      this.carouselInstance = new BootstrapCarousel(this.$refs.carouselEl, {
        interval: 3200,
        ride: "carousel",
        pause: false,
        wrap: true,
      });
    },

    destroyCarousel() {
      if (this.carouselInstance) {
        this.carouselInstance.dispose();
        this.carouselInstance = null;
      }
    },
  },
};
</script>

<style scoped>
.dog-card {
  overflow: hidden;
  border: 0;
  border-radius: 1rem;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}

.card-img-top {
  height: 250px;
  width: 100%;
  object-fit: cover;
}

.card-title {
  font-weight: 700;
}

.carousel-control-prev,
.carousel-control-next {
  width: 8%;
}
</style>
