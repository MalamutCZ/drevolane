<?php
/**
 * Poptávkový formulář – pilabilina.cz
 * Přijme data z formuláře na index.html a pošle je e-mailem.
 * Po odeslání vrátí návštěvníka zpět na web s ?poptavka=ok nebo ?poptavka=chyba.
 */

// ---- Nastavení -------------------------------------------------------------
const PRIJEMCE   = 'info@pilabilina.cz';      // kam chodí poptávky
const ODESILATEL = 'web@pilabilina.cz';       // musí být na vlastní doméně (kvůli SPF)
const NAVRAT     = '/';                       // kam se vrátit po odeslání
const LIMIT_SEK  = 30;                        // min. odstup dvou odeslání z jedné IP
// ----------------------------------------------------------------------------

mb_internal_encoding('UTF-8');

function zpet(string $stav): void {
    header('Location: ' . NAVRAT . '?poptavka=' . $stav . '#poptavka', true, 303);
    exit;
}

// Jen POST
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    zpet('chyba');
}

// Ochrana proti robotům: skryté pole "web" musí zůstat prázdné.
// Robota tváříme jako úspěch, ať to nezkouší znovu.
if (!empty($_POST['web'])) {
    zpet('ok');
}

// Jednoduchý limit četnosti podle IP (soubor v dočasném adresáři)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'x';
$zamek = sys_get_temp_dir() . '/poptavka_' . hash('sha256', $ip);
if (is_file($zamek) && (time() - (int) @filemtime($zamek)) < LIMIT_SEK) {
    zpet('chyba');
}

// Načtení a očištění vstupů (odstraní řídicí znaky a zalomení řádků v jednořádkových polích)
function pole(string $klic, int $max, bool $viceradku = false): string {
    $v = trim((string) ($_POST[$klic] ?? ''));
    $v = $viceradku
        ? preg_replace('/[^\P{C}\n\t]/u', '', $v)
        : preg_replace('/[\p{C}]/u', ' ', $v);
    return mb_substr((string) $v, 0, $max);
}

$jmeno    = pole('jmeno', 100);
$telefon  = pole('telefon', 40);
$email    = pole('email', 120);
$adresa   = pole('adresa', 200);
$drevo    = pole('drevo', 60);
$mnozstvi = pole('mnozstvi', 6);
$uprava   = pole('uprava', 20);
$termin   = pole('termin', 20);
$poznamka = pole('poznamka', 2000, true);
$souhlas  = !empty($_POST['souhlas']);

// Povinná pole a kontroly
$telefonOk = (bool) preg_match('/^[0-9 +()\/-]{9,20}$/', $telefon);
$emailOk   = $email === '' || filter_var($email, FILTER_VALIDATE_EMAIL);
if ($jmeno === '' || !$telefonOk || $adresa === '' || !$emailOk || !$souhlas) {
    zpet('chyba');
}

// Složení zprávy
$radky = [
    'Nová poptávka z webu www.pilabilina.cz',
    '',
    'Jméno:      ' . $jmeno,
    'Telefon:    ' . $telefon,
    'E-mail:     ' . ($email !== '' ? $email : '–'),
    'Adresa:     ' . $adresa,
    'Druh dřeva: ' . $drevo,
    'Úprava:     ' . $uprava,
    'Množství:   ' . $mnozstvi . ' prms',
    'Termín:     ' . ($termin !== '' ? $termin : '–'),
    '',
    'Poznámka:',
    $poznamka !== '' ? $poznamka : '–',
    '',
    '---',
    'Odesláno: ' . date('j. n. Y H:i') . ' z IP ' . $ip,
];
$telo = implode("\n", $radky);

$hlavicky = [
    'From: =?UTF-8?B?' . base64_encode('Web Pila Bílina') . '?= <' . ODESILATEL . '>',
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];
if ($email !== '') {
    $hlavicky[] = 'Reply-To: ' . $email;   // "Odpovědět" půjde rovnou zákazníkovi
}

$predmet = '=?UTF-8?B?' . base64_encode('Poptávka: ' . $drevo . ', ' . $mnozstvi . ' prms – ' . $jmeno) . '?=';

$odeslano = mail(PRIJEMCE, $predmet, $telo, implode("\r\n", $hlavicky), '-f' . ODESILATEL);

if ($odeslano) {
    @touch($zamek);
    zpet('ok');
}
zpet('chyba');
