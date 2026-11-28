# Palivové dřevo, Pila Bílina – www.pilabilina.cz

Statický jednostránkový web + PHP skript pro poptávkový formulář. Běží na webhostingu **Active24**.
Tento repozitář slouží jako zdroj a záloha.

## Soubory

| Soubor | K čemu je |
|---|---|
| `index.html` | celý web (ceník, kalkulačka, doprava, poptávka) |
| `kontakt.php` | odeslání poptávky e-mailem na info@pilabilina.cz |
| `favicon.svg` | ikona v záložce prohlížeče |
| `.htaccess` | přesměrování na https://www.pilabilina.cz |
| `robots.txt`, `sitemap.xml` | pro vyhledávače |

## Zveřejnění na Active24

1. **SSL certifikát** – v Zákaznickém centru Active24 → webhosting → zapněte bezplatný certifikát (Let's Encrypt) pro `pilabilina.cz` i `www.pilabilina.cz`. Počkejte, až je aktivní.
2. **E-mailová schránka** – založte `info@pilabilina.cz` (v e-mailu hostingu, nebo u jiného poskytovatele – pak v DNS nasměrujte MX záznamy).
3. **Nahrání souborů** – v administraci hostingu otevřete Správce souborů (nebo FTP, údaje jsou v administraci) a do kořenové složky webu nahrajte všechny soubory z tabulky výše. Případný výchozí `index.html` od Active24 přepište.
   - `.htaccess` začíná tečkou – některé FTP programy ho skrývají; zapněte zobrazení skrytých souborů.
4. **Test** – otevřete https://www.pilabilina.cz, vyzkoušejte kalkulačku a odešlete zkušební poptávku. Měla by dorazit na info@pilabilina.cz.

## Google

1. **Google Search Console** – přidejte doménu `pilabilina.cz` (ověření TXT záznamem v DNS u Active24) a odešlete `https://www.pilabilina.cz/sitemap.xml`.
2. **Google Business Profile** – firma s oblastí působnosti (Bílina, Hrobčice a okolí), odkaz na web.
3. **GitHub Pages vypněte** (Settings → Pages → Unpublish), ať na internetu nejsou dvě kopie webu.

## Úpravy

- **Ceny** – v `index.html` karty ceníku a objekt `WOODS` v JavaScriptu dole (musí sedět obojí).
- **Doprava** – v JavaScriptu `KM_RATE` (Kč/km), `LOAD` (prms na jedno auto), `FREE_KM` (km zdarma).
- **Příjemce poptávek** – v `kontakt.php` konstanta `PRIJEMCE`.
- Po úpravě nahrajte změněný soubor znovu na hosting.
