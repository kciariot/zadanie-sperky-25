# Zadanie Sperky 25

## Cieľ:
Vašou úlohou je vytvoriť jednoduchú a opakovane použiteľnú PHP knižnicu, ktorá umožní komunikáciu s verejne dostupným API služby Meow Facts (https://github.com/wh-iterabb-it/meowfacts) a pripraviť jednoduchý frontend (HTML+JS), ktorý zobrazuje výstup knižnice cez AJAX (volanie cez PHP endpoint).

## Knižnica by mala:
1. Byť implementovaná ako trieda/y v čistej PHP (minimálne PHP 7.4).
2. Umožňovať načítanie náhodných faktov o mačkách cez API.
3. Podporovať voliteľné parametre: id – špecifický identifikátor faktu, ak je dostupný. lang – jazyk faktu (napr. en , sk , cz ). count – počet náhodných faktov, ktoré sa majú načítať.
4. Správne ošetriť chybové stavy (napr. zlé parametre, chyby HTTP komunikácie, neplatná odpoveď).
5. Vrátiť výstup v spracovateľnej forme (napr. pole, JSON objekt).
