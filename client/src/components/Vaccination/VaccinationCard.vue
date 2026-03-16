<template>
  <article class="vaccine-card h-100">
    <div class="card-head">
      <h3 class="vaccine-name mb-0">
        <i class="bi bi-capsule-pill me-1"></i>{{ card.name }}
      </h3>
      <div class="d-flex align-items-center gap-2">
        <span class="badge">{{ card.badge }}</span>
        <button
          v-if="canDelete"
          type="button"
          class="btn btn-outline-danger btn-sm"
          title="Delete"
          @click="onDelete"
        >
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </div>

    <p class="desc mt-3 mb-3">{{ card.description }}</p>

    <div class="meta-row">
      <p class="meta-title mb-1">Recommended Age:</p>
      <p class="meta-value mb-0">{{ card.recommendedAge }}</p>
    </div>

    <div class="meta-row">
      <p class="meta-title mb-1">Frequency:</p>
      <p class="meta-value mb-0">{{ card.frequency }}</p>
    </div>

    <div class="meta-row">
      <p class="meta-title mb-1">Common Side Effects:</p>
      <p class="meta-value mb-0">{{ card.sideEffects }}</p>
    </div>
  </article>
</template>

<script>
export default {
  name: "VaccinationCard",
  emits: ["delete"],
  props: {
    card: {
      type: Object,
      required: true,
    },
    canDelete: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    onDelete() {
      const ok = window.confirm(`Delete "${this.card?.name}"?`);
      if (!ok) return;
      this.$emit("delete", this.card);
    },
  },
};
</script>

<style scoped>
.vaccine-card {
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  background: #ffffff;
  padding: 16px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.03);
}

.card-head {
  display: flex;
  justify-content: space-between;
  gap: 8px;
  align-items: center;
}

.vaccine-name {
  color: #b15000;
  font-size: 1.1rem;
  font-weight: 700;
}

.badge {
  background: #ffefdb;
  color: #b15000;
  border: 1px solid #ffd1a3;
  border-radius: 999px;
  padding: 4px 9px;
  font-size: 0.73rem;
  font-weight: 700;
}

.desc {
  color: #4b5563;
  line-height: 1.45;
  font-size: 0.92rem;
}

.meta-row {
  background: #faf7ef;
  border-radius: 8px;
  padding: 8px 10px;
  margin-bottom: 8px;
}

.meta-title {
  color: #7a4a00;
  font-size: 0.75rem;
  text-transform: uppercase;
  font-weight: 700;
  letter-spacing: 0.3px;
}

.meta-value {
  color: #4b5563;
  font-size: 0.87rem;
}
</style>
