import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import { useToastStore } from "@/stores/toastStore";

//Azt nézi meg, hogy be van-e valaki jelentkezv
function checkIfNotLogged() {
  const storeAuth = useUserLoginLogoutStore();
  if (!storeAuth.isLoggedIn) {
    return "/login";
  }
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
      meta: {
        title: (route) => "Home",
        breadcrumb: "Home",
      },
    },
    {
      path: "/about",
      name: "about",
      component: () => import("@/views/AboutView.vue"),
      meta: {
        title: (route) => "About Us ",
        breadcrumb: "About Us",
      },
    },
    {
      path: "/dogs",
      name: "dogs",
      component: () => import("@/views/DogsView.vue"),
      meta: {
        title: (route) => "Dogs",
        breadcrumb: "Dogs",
      },
    },
    {
      path: "/adoptions",
      name: "adoptions",
      component: () => import("@/views/AdoptionsView.vue"),
      beforeEnter: [checkIfNotLogged],
      meta: {
        title: (route) => "Adoptions",
        breadcrumb: "Adoptions",
        roles: [1, 2],
      },
    },
    {
      path: "/favorites",
      name: "favorites",
      component: () => import("@/views/FavoritesView.vue"),
      beforeEnter: [checkIfNotLogged],
      meta: {
        title: (route) => "Favorites",
        breadcrumb: "Favorites",
      },
    },
    {
      path: "/vaccination-guide",
      name: "vaccination-guide",
      component: () => import("@/views/VaccinationGuideView.vue"),
      meta: {
        title: (route) => "Vaccination Guide",
        breadcrumb: "Vaccination Guide",
      },
    },
    {
      path: "/adatok",
      name: "adatok",
      component: () => import("@/views/EmptyWrapperView.vue"),
      meta: {
        breadcrumb: "Adatok",
        disabled: true,
        roles: [1],
      },
      children: [
        {
          path: "users",
          name: "users",
          component: () => import("@/views/UsersView.vue"),
          beforeEnter: [checkIfNotLogged],
          meta: {
            title: (route) => "Users",
            breadcrumb: "Users",
            roles: [1],
          },
        },
        {
          path: "breeds",
          name: "breeds-admin",
          component: () => import("@/views/BreedsAdminView.vue"),
          beforeEnter: [checkIfNotLogged],
          meta: {
            title: (route) => "Breeds",
            breadcrumb: "Breeds",
            roles: [1],
          },
        },
        {
          path: "colors",
          name: "colors-admin",
          component: () => import("@/views/ColorsAdminView.vue"),
          beforeEnter: [checkIfNotLogged],
          meta: {
            title: (route) => "Colors",
            breadcrumb: "Colors",
            roles: [1],
          },
        },
      ],
    },
    {
      path: "/login",
      name: "login",
      component: () => import("@/views/LoginView.vue"),
      meta: {
        title: (route) => "Login",
        breadcrumb: "Login",
      },
    },
    {
      path: "/registration",
      name: "registration",
      component: () => import("@/views/RegistrationView.vue"),
      meta: {
        title: (route) => "Regisztráció",
        breadcrumb: "Regisztráció",
      },
    },

    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: () => import("@/views/404.vue"),
      meta: {
        title: (route) => "404",
        breadcrumb: "",
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
 
  document.title = "DogShelter - " + to.meta.title(to);
  //mehetsz tovább az oldalra

  // Megkeressük az összes meta.roles beállítást az útvonal láncban
  // (A to.matched azért jó, mert ha a szülő védett, az egész ág védett lesz)
  const requiredRoles = to.meta.roles;
  
  const userStore = useUserLoginLogoutStore();
  // Használjuk a már megismert logikát
  if (userStore.canAccess(requiredRoles)) {
    // 1. eset: Van joga (vagy publikus), mehet tovább
    next();
  } else {
    // 2. eset: Nincs joga
    if (!userStore.isLoggedIn) {
      // Ha nincs belépve, küldjük a loginra
      next({ path: "/login" });
    } else {
      // Ha be van lépve, de ehhez nincs joga (pl. örökbefogadó admin oldalra téved)
      // Küldjük a főoldalra vagy egy "Nincs jogosultság" oldalra
      //alert("Nincs jogosultságod az oldal megtekintéséhez!");
      useToastStore().messages.push("Ehhez az oldalhoz nincs jogod!");
      useToastStore().show("Error");
      next("/");
    }
  }

  // next();
});

export default router;
