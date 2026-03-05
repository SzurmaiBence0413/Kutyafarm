<template>
  <div class="about">
    <h1>About Us</h1>
    

    <div class="image-container">
      <img src="/shelterkep.png" alt="Dog Shelter" class="shelter-img" />
    </div>
    
    <ul>
      <li>
        Dog Shelter started with a simple idea between two friends in Hungary. We both loved dogs and often talked about how many of them live on the streets without care, safety, or a home. One day we decided that instead of only talking about it, we would try to help.
      </li>
      <li>
        At first it was small. We rescued one dog, then another, giving them food, shelter, and time to recover. Slowly our small effort grew into something bigger, and Dog Shelter was born. 
      </li>
      <li>
        Today we still run the shelter together as friends with the same goal we started with: giving abandoned dogs a safe place, care, and a second chance to find a loving home.
      </li>
    </ul>
    
    <hr>
    
    <ul>
      <li>{{ title }}</li>
      <li>Version: {{ ver }}</li>
      <li>API url: {{ apiUrl }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dev: import.meta.env.DEV,
      prod: import.meta.env.PROD,
      ssr: import.meta.env.SSR,
      mode: import.meta.env.MODE,
      title: import.meta.env.VITE_APP_TITLE,
      ver: import.meta.env.VITE_APP_VER,
      apiUrl: import.meta.env.VITE_API_URL
    }
  }
}
</script>

<style scoped>

.about {
  font-family: Arial, sans-serif;
  color: #333;
  text-align: center;
  padding: 20px;
  background: linear-gradient(to right, #000000, #FFA500); 
  border-radius: 10px;
}


h1 {
  color: #FFA500;
}


.image-container {
  display: flex;
  justify-content: center;
  margin: 20px 0;
}

.shelter-img {
  max-width: 80%; 
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

ul {
  list-style-type: none;
  padding: 0;
  margin: 20px 0;
  color: #ddd;
}

ul li {
  margin-bottom: 10px;
  font-size: 1.1rem;
}

hr {
  margin: 30px 0;
  border: 1px solid #ddd;
}

ul li:last-child {
  font-weight: bold;
  color: #555;
}
</style>