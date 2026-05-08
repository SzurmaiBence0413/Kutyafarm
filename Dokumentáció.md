# DogShelter projekt

## A projekt bemutatása
A DogShelter projekt egy, olyan szoftver, ami segít a kutyamenhelyek számára nyílvántartani, módosítani digitálisan a menhelyen lévő kutyák adatai. A projekt célja, hogy segítse a menhelyek gyors és hatékony munkáját.

***Célkitűzés***
- Gyors és jól átlátható rendszer, adatbázis az örökbefogadható kutyákról.
- Modern, reszponzív felület biztosítása a leendő gazdák, valamint az admin számára.
- Az adminisztráció megkyönnyítése, iletve az papír mentes adminisztráció.

## Követélmények
***Látogatói felület:***
- Oltásokról, vakcinákról útmutatók, tudnivalók


- A kutyak szűrése fajta szerint
![Szűrés fajata szerint](/images/BreedFilter.png)
- Keresés név és fajta alapján
- Részletes adatlapok
![Céglogó](/images/Vaccination.png)
![Céglogó](/images/dogInfo.png)
- Biztonságos belépés

***Admin felület:***
- Biztonságos belépés
- CRUD műveletek végrehajtása a kutyák, felhasználók, valamint az oltások adataival
![Admin kutya űrlap](/images/admindDogForm.png)
- Az örökbefogadási kérelmek elutasítása, elfogadása
![Örökbefogadási kérelmek](/images/admindAdoptRequest.png)

## Technikai felépítés
***Frontend:***
- A modern és gyors felhaszáló felületért a Vue.js felel vite környezetben.

***Backend:***
- Az adatok kiszolgálásáért PHP egyik keretrendszere felel a Laravel ami REST API segítségével.

***Adatbázis:***
- Az adatok tárolását MySQL-ben valósítottuk meg.

***Hitelesítés:***
- A hitelesítésre, a token alapú védelemre a Laravel Sanctum-ot használtuk.

## A projekt fejlesztői szemmel
***Backend logikája:***
- A szerver oldali logikát Controllerekbe szerveztük ki. Például a DogController azért felelős, hogy csak azok a kutyák jelenjenek meg a frontend oldali, amikre a felhasználó rákeresett.
![Kontrollerek](/images/Controllers.png)

***Frontend logikája:***
- Komponenseket, store-oket, service-ket használtunk a könyebb karbantártás, valamint az átláthatáság miatt is. A navigációt a vue routerekkel kezeljük, a API hívásokhoz pedi a axios könyvtárat alkalmaztuk.

## Jövőbeli fejlesztések
- Szűrés megye és város alapján
- Szűrés kor, szín és nem alapján
- Részletes örökbefogadói kérdőív 
- Kutyákhoz kapcsolódó termékek árusítása