import { defineStore } from "pinia";
import service from "@/api/dogBrowseService";

const FALLBACK_IMAGE = "https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=900&q=80";

function yearsFromDate(dateString) {
  if (!dateString) return null;

  const birthDate = new Date(dateString);
  if (Number.isNaN(birthDate.getTime())) return null;

  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();

  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age -= 1;
  }

  return age;
}

function generatePrice(id, weight) {
  const base = 900;
  const weightPart = Number(weight) ? Math.min(Number(weight) * 7, 300) : 0;
  const idPart = ((id || 1) * 87) % 600;
  return Math.round(base + weightPart + idPart);
}

function buildDescription(dog, breedName, age) {
  const genderText = Number(dog.gender) === 1 ? "male" : "female";
  const ageText = age === null ? "young" : `${age}-year-old`;
  return `${ageText} ${genderText} ${breedName.toLowerCase()} with a friendly temperament.`;
}

export const useDogBrowseStore = defineStore("dogBrowse", {
  state: () => ({
    dogs: [],
    loading: false,
    error: null,
    searchText: "",
    selectedBreed: "all",
    favorites: {},
  }),

  getters: {
    breedOptions(state) {
      const breedSet = new Set(state.dogs.map((dog) => dog.breed).filter(Boolean));
      return ["all", ...Array.from(breedSet).sort((a, b) => a.localeCompare(b))];
    },

    filteredDogs(state) {
      const text = state.searchText.trim().toLowerCase();

      return state.dogs.filter((dog) => {
        const matchesBreed =
          state.selectedBreed === "all" || dog.breed === state.selectedBreed;

        if (!text) return matchesBreed;

        const haystack = [dog.name, dog.breed, dog.location, dog.description]
          .join(" ")
          .toLowerCase();

        return matchesBreed && haystack.includes(text);
      });
    },
  },

  actions: {
    async fetchDogs() {
      this.loading = true;
      this.error = null;

      try {
        const [dogsResponse, breedsResponse, photosResponse] = await Promise.all([
          service.getDogs(),
          service.getBreeds(),
          service.getPhotos(),
        ]);

        const dogs = dogsResponse?.data ?? [];
        const breeds = breedsResponse?.data ?? [];
        const photos = photosResponse?.data ?? [];

        const breedMap = Object.fromEntries(
          breeds.map((breed) => [breed.id, breed.breed])
        );

        const photoMap = {};
        for (const photo of photos) {
          if (!photoMap[photo.dogId]) {
            photoMap[photo.dogId] = photo.imgUrl;
          }
        }

        this.dogs = dogs.map((dog) => {
          const age = yearsFromDate(dog.dateOfBirth);
          const breedName = breedMap[dog.breedId] || "Unknown Breed";

          return {
            id: dog.id,
            name: dog.dogName,
            breed: breedName,
            image: photoMap[dog.id] || FALLBACK_IMAGE,
            featured: dog.id % 2 === 0,
            location: "Budapest, Hungary",
            age,
            price: generatePrice(dog.id, dog.weight),
            description: buildDescription(dog, breedName, age),
          };
        });
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },

    setSearchText(value) {
      this.searchText = value;
    },

    setSelectedBreed(value) {
      this.selectedBreed = value;
    },

    toggleFavorite(id) {
      this.favorites[id] = !this.favorites[id];
    },

    isFavorite(id) {
      return !!this.favorites[id];
    },
  },
});
