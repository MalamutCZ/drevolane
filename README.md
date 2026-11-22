# Dřevo Laně – web pro prodej palivového dřeva

Statický jednostránkový web (HTML + CSS + trocha JavaScriptu, bez build kroku a bez závislostí). Připravený pro **GitHub Pages**.

## Obsah repozitáře

| Soubor | K čemu je |
|---|---|
| `index.html` | celý web: styly, obsah, kalkulačka ceny, poptávkový formulář |
| `favicon.svg` | ikona v záložce prohlížeče (letokruhy) |
| `README.md` | tento návod |

## 1. Nahrání na GitHub

**Přes web GitHubu (nejjednodušší):**
1. Na github.com vpravo nahoře **+ → New repository**, název např. `drevolane`, **Public**, Create.
2. Na stránce repozitáře **Add file → Upload files**, přetáhněte všechny soubory z této složky, **Commit changes**.

**Přes příkazovou řádku:**
```bash
cd drevolane
git init
git add .
git commit -m "Web Dřevo Laně"
git branch -M main
git remote add origin https://github.com/MalamutCZ/drevolane.git
git push -u origin main
```

## 2. Zapnutí GitHub Pages

Repozitář → **Settings → Pages** → Source: **Deploy from a branch** → Branch: `main`, složka `/ (root)` → **Save**.
Za 1–2 minuty bude web na `https://MalamutCZ.github.io/drevolane/`.

## 3. Zprovoznění formuláře (Formspree)

GitHub Pages umí jen statické stránky, formulář sám e-mail neodešle. Použijte bezplatnou službu Formspree (free tarif: 50 odeslání měsíčně):

1. Registrace na https://formspree.io, **New Form**, cílový e-mail = kam mají chodit poptávky.
2. Formspree vám dá adresu typu `https://formspree.io/f/abcdwxyz`.
3. V `index.html` najděte `VAS_FORMSPREE_ID` a nahraďte ho svým ID (`abcdwxyz`).
4. První odeslaný formulář potvrďte v e-mailu od Formspree.

Formulář obsahuje skryté pole `_gotcha` proti spamovým robotům.

## 4. Vlastní doména dřevolane.cz

Doména s diakritikou se v DNS a v nastavení GitHubu zapisuje v tzv. punycode: **`xn--devolane-3ub.cz`**.

1. U registrátora domény nastavte DNS:
   - 4× záznam **A** pro `@`: `185.199.108.153`, `185.199.109.153`, `185.199.110.153`, `185.199.111.153`
   - **CNAME** pro `www` → `MalamutCZ.github.io`
2. Na GitHubu **Settings → Pages → Custom domain**: `xn--devolane-3ub.cz` → Save (GitHub sám vytvoří soubor `CNAME`).
3. Po ověření (až 24 h) zaškrtněte **Enforce HTTPS**.

Doporučení: zaregistrujte i doménu bez háčků (`drevolane.cz`) a přesměrujte ji. Lidé ji budou psát bez diakritiky a e-mailové adresy s háčkem v doméně některé poštovní programy a formuláře odmítají.

## 5. Co ještě doplnit / zkontrolovat před spuštěním

- [ ] **IČO** – v `index.html` 2× text `[IČO]`
- [ ] **Ceny** – v ceníku jsou zatím vzorové ceny. Mění se na jednom místě: v souboru jsou karty ceníku i objekt `WOODS` v JavaScriptu dole (cena musí sedět v obou)
- [ ] **ID Formspree** (krok 3)
- [ ] **Zásady ochrany osobních údajů (GDPR)** – formulář sbírá jméno, telefon a adresu; vhodné je doplnit krátkou stránku nebo odstavec, kdo údaje zpracovává a proč
- [ ] Zápis do **Google Firmy** (Google Business Profile) – pro místní vyhledávání („palivové dřevo Bílina“) je to účinnější než samotný web

## Úpravy

- **Barvy** jsou na začátku `<style>` jako proměnné (`--moss`, `--sand`, …).
- **Příplatky za délku polen**: v JavaScriptu `S25` (25 cm) a `D50` (50 cm) a v textu pod ceníkem.
- Stránka obsahuje strukturovaná data `LocalBusiness` (schema.org) pro vyhledávače – při změně telefonu či otevírací doby je upravte i tam.
