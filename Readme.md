# A szoftver működésének műszaki feltételei

## A szoftver működéséhez szükségés programok
- Visual Studio Code
- Wampserver vagy xampp (ajánlott a Wampserver a megbízhatósága miatt)
- Vue.js
- Node.js
- dbForge Studio for MySQL
- Composer

## Telepítés lépései

### Visual Studio telepítése
1. [Látogass el a hivatalos weboldalra](https://code.visualstudio.com/)
2. Töltsd le a legfrisebb verziót
3. Futtasd a telepítőt és kövesd az utasításokat

### Wampserver telepítése
1. [Látogass el a weboldalra](https://wampserver.aviatechno.net/)
2. Töltsd le a wamp legfrisebb php-s verzióját
3. Futtasd  a telepítőt
4. Indítsd el a programot
5. Ellenőrizd, hogy a Wamp ikon zöld, ez jelzi, hogy minden szolgáltatás fut

### Node.js telepítése
1. [Niysd meg a Node.js hivatalso weboldalát](https://nodejs.org/en)
2. Töltsd le az LTS verziót
3. Telepítsd le az utasítások követésével

### Vue.js telepítése
1. Nyisd meg a terminált Visual Studio Code-ban
2. Futtasd az alabbi parancsot: `npm install -g @vue/cli`

### dbForge Studio for MySQl telepítése
1. [Látogass el a weboldalra](https://www.devart.com/dbforge/mysql/studio/product-overview.html)
2. Töltsd le a legfrisebb  verziót
3. Telepítsd le az utasítások követésével
4. Indítás után csatlakozz a helyi MySQl szerverhez

### Composer telepítése
1. [Látogass el a hivatalos weboldalra](https://getcomposer.org/)
2. Töltsd le a telepítőt
3. Telepítés során válaszd ki a PHP verziót (WAMP mappából)
4. Telepítés után ellenőrzés a terminálban: `composer -v`
5. függőségek telepítése terminálban: `composer install`

### A projekt betöltése
1. Nyiss egy új terminált Visual Studio Code-ban
2. Illeszd be a terminálba a következőt: `git clone https://github.com/SzurmaiBence0413/DogShelter.git`
3. Függőségek telepítése terminálban: `npm install`


## A projekt elindítása
1. Nyiss egy új bash ablakot (backend indítása)
2. Írd be a következőket: 
 - cd server
 - php artisan serve
3. Nyiss egy újabb bash ablakot (frontend indítása)
4. Írd be a következőket az ablakba:
 - `cd client`
 - `npm run dev`


