<template>
  <div id="cardCarousel" class="carousel slide mt-3">
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
              <div class="card h-100">
                <img :src="card.img" class="card-img-top" alt="Card image">
                <div class="card-body">
                  <h5 class="card-title">{{ card.title }}</h5>
                  <p class="card-text">{{ card.text }}</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

    <!-- Carousel controls -->
    <button 
      class="carousel-control-prev" 
      type="button" 
      data-bs-target="#cardCarousel" 
      data-bs-slide="prev"
    >
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button 
      class="carousel-control-next" 
      type="button" 
      data-bs-target="#cardCarousel" 
      data-bs-slide="next"
    >
      <span class="carousel-control-next-icon"></span>
    </button>

  </div>
</template>

<script>
export default {
    computed: {
  groupedCards() {
    const chunkSize = 3 // desktop-hoz
    const result = []
    for (let i = 0; i < this.cards.length; i += chunkSize) {
      result.push(this.cards.slice(i, i + chunkSize))
    }
    return result
  }
},
    data() {
  return {
    cards: [
      { id: 1, title: "Boxer", text: "Bright and alert, full of boundless energy", img: "https://tinyurl.com/BoxerImg" },
      { id: 2, title: "Dachshund", text: "Brave and curious with palyful spirit", img: "https://tinyurl.com/DachshundImg" },
      { id: 3, title: "Yorkshire Terrier", text: "Feisty and affectionate toy breed ", img: "https://tinyurl.com/mtt4c6sr" },
      { id: 4, title: "Dalmatian", text: "Energatic and playful, known for their distinctive spots", img: "https://tinyurl.com/DalmationDog" },
      { id: 5, title: "Rottweiler", text: "Loyal and confident guardian breed ", img: "https://tinyurl.com/RottweilerImg" },
      { id: 6, title: "Shiba Inu", text: "Alert and  agile with spirited personality", img: "https://tinyurl.com/ShibaImg" },
    ]
  }
}
    };
</script>

<style>
.card-img-top {
  height: 250px;        /* fix magasság */
  width: 100%;          /* teljes szélesség */
  object-fit: cover;    /* ne torzuljon, vágjon */
}
</style>