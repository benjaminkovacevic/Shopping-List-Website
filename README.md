# Shopping-List-Website
A shopping list is a list of items that you plan to buy during a shopping trip. It helps you stay organized and ensures you don't forget anything you need.

Opis projekta:
Cilj projekta je da se kreira web aplikacija-sajt za vođenje elektronske liste za kupovinu.
Aplikacija razlikuje tri nivoa pristupa: gost, registrovan/prijavljen korisnik i administrator.
Gost
•
•
može da pogleda ponuđene informacije na sajtu
može da izvrši registraciju na sajtu
Registrovan/prijavljen korisnik
•
•
•
•
•
•
može da pregleda ponuđene informacije na sajtu
može da promeni svoje profilne podatke (lozinka, ime, prezime, broj telefona, adresa)
može da kreira listu za kupovinu za jedan ili više dana
može da pregledam menja i briše svoje liste za kupovinu (omogućiti prikaz na osnovu
statusa liste – created i finished)
može da pregleda statistiku šta je najviše kupovao u nekom vremenskom periodu
može da zahteva promenu lozinke (zaboravljena lozinka)
Administrator
•
•
može da pregleda sve korisničke naloge
može da zabravni/odobri prijavu korisnika na sistem
Registraciju korisnika mora biti urađena na bezbedan način i obaveznim slanjem aktivacionog
linka putem e-maila. Slanje linka koristiti i kod zahteva za promenu lozinke. Ne sme se dozvoliti
registracija korisničkih naloga sa istom e-mail adresom. E-mail adresa mora biti jedinstvena i
ona predstavlja korisničko ime.
Korisnik kreira svoju listu za kupovinu unešenjem sledećih podataka: naziv liste, dan za
kupovinu, sadržaj liste (svaka stavka se navodi posebno) i opciono opis liste. U opisu može da
navede neke dodatne informacije koje ćemu koristiti prilikom kupovine. Datum i vreme unosa
liste treba da bude automatski dodato prilikom kreiranja liste. Svaka lista podrazumevano ima
status kreirana (created). Status se menja nakon završetka kupovine.
Kada korisnik odlazi u kupovinu može da otvori listu i da dobije spisak svih stavki te liste.
Pored svake stavke treba da stoji polje (checkbox) preko kojega može da označi da li je već tu
stavku stavio u korpu. Kada završi kupovinu pritiskom na taster Završi kupovinu završava
kupovinu. Ova lista menja svoj status na završena (finished).
Korisnik preko opcije statistika da odabirom vremenskog perioda pogleda koje je stavke najviše
kupovao odnosno dodavo u liste za kupovinu.
Administratorski deo zaštiti upotrebom sesija (PHP). Sve korisničke lozinke „hešovati“ bcrypt
algoritmom.
1Kreirati bazu podataka pod imenom shopping i unutar nje tabele koje će zadovoljiti sve
funkcionalnosti projekta.
Zahtevi i smernice
•Pored navedenih obaveznih funkcionalnosti studenti mogu dodati i neku svoju
funkcionalnost koja će po njihovom mišljenju unaprediti projekat.
•Upotreba spoljašnjeg fajla sa JavaScript kodom je obavezna. Programski kod
(promenljive, funkcije, objekte…) pisati na engleskom jeziku, koristiti komentare u
kodu, držati se uputstva koje je dato u posebnom fajlu coding_style_guide_sr.pdf
•Obavezna upotreba spoljašnjeg fajla sa CSS kodom.
•Pristupne parametre za povezivanje sa MySQL serverom definisati u spoljašnjem fajlu
db_config.php. Za rad sa MySQL bazom koristiti PDO ekstenziju unutar PHP jezika.
Deo PHP programskog koda mora biti objektno orijentisan.
•Na jednom projektu zajedno mogu da rade dva studenta. Svaki tim mora da ima svoje
ime.
•Projekat treba da bude multiplatformski (Responsive) i da bude prilagođen računarima
i mobilnim uređajima.
•U okviru projekta obavezno treba koristiti sledeće tehnike i tehnologije: HTML, CSS,
JavaScript, AJAX ili Fetch API, JSON, Bootstrap, PHP i MySQL.
•Programski deo koji koristi AJAX ili Fetch API tehniku mora da manipuliše sa
podacima iz baze podataka. Preporuka za korišćenje AJAX ili Fetch API tehnika:
provera validnosti podataka, nabavljanje podataka iz baze podataka, registracija i
provere kod registracije.
•Na stranicama gde se radi validacija podataka obavezno uraditi validaciju na klijentskoj
i serverskoj strani.
•Projekat je potrebno postaviti na školski web server. Svaki tim će dobiti svoje pristupne
parametre putem e-maila.
•Upotreba ostalih tehnologija, biblioteka i API-a je opciona.
