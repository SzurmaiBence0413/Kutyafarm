const STORAGE_KEY = "favorite_dog_ids";

export default {
  loadFavoriteIds() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return [];
      const parsed = JSON.parse(raw);
      if (!Array.isArray(parsed)) return [];
      return parsed.map((id) => Number(id)).filter((id) => Number.isInteger(id));
    } catch (error) {
      return [];
    }
  },

  saveFavoriteIds(ids) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
  },
};

