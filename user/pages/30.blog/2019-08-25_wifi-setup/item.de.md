---
title: 'Das Wifi im Kanthaus'
date: "2019-08-25"
taxonomy:
    tag: [blog]
    author: Matthias
---

Wlan, Wifi, 802.11 oder wie auch immer ihr es nennt: Es geht um das Funkzeug, mit dem dein Gerät "zu Haus" oder sonstewo ins Internet kommt. Das, was zu Haus einfach aus nem Kasten kommt, wo das Passwort auf dem Klebi untendrunter steht.

Du hast es schon erahnt: Es geht auch komplizierter als so. Doch warum eigentlich?

* Du kennst es vielleicht von der Uni: Fürs `eduroam` brauchst du spezielle Zugangsdaten, welche nur während deines Studiums gültig sind. Es gibt offenbar Menschen, die Interesse daran haben, dass nicht alle anderen Menschen das Internet nutzen können. Die hier verwendete Technik nennt sich WPA Enterprise und hat nicht nur den Vorteil (& Nachteil) der speziellen Zugangsdaten.
* Was viele nicht wissen: Ein "klassisch" verschlüsseltes Wlan - der Technik-Slang lautet WPA PSK (PreSharedKey - verteilter Schlüssel) oder WPA Personal - ist dann nicht effektiv verschlüsselt, wenn alle den Schlüssel kennen.

### Historie: wuppdays Wlan

Das wuppdays Wlan mit dem bekannten Passwort wurde im September 2015 erstmals gesehen, auf den ersten yunity Wuppdays. Seitdem hat es sich rasant verbreitet: Zuhause ist, wo mein Gerät mit wuppdays automatisch im Internet ist. So kam es auch ins Kanthaus.

Ist das eigentlich ein Problem, dass alle Menschen den Schlüssel kennen?
Wie genau funktioniert eigentlich die Verschlüsselung von Wlan?
Wovor möchte ich mich schützen?
Wer soll was in meinem Netz dürfen?

Als technikaffiner Mensch fallen mir die ersten 2 Fragen leichter als die letzten beiden...

### Wie genau funktioniert die Verschlüsselung im Wlan?

Nun, vereinfacht gesagt benötigen die Wlan Endgeräte einen Schlüssel, mit dem sie ihre Datenpakete füreinander verschlüsseln. Das ist nicht etwa der Schlüssel, den du beim Verbinden angibst, sondern etwas, was der AccessPoint und dein Gerät miteinander ... verhandeln. Nennen wir ihn mal PMK, Pairwise Master Key.

* WPA PSK: Hier wird der PMK ganz einfach aus dem PSK und der SSID (Service Set Identifier - oder einfach Name) des Netzwerks generiert. Alle Clients haben denselben PMK.
* WPA Enterprise: Hier wird der PMK vereinfacht gesagt vom Access-Point, genauer dem Authentifizierungs-Server dahinter, bestimmt, und dem Client mitgeteilt. Jeder Client bekommt einen eigenen PMK

In Wirklichkeit wird auch der PMK nicht direkt für die Verschlüsselung benutzt, allerdings können die eigentlichen Schlüssel daraus berechnet werden.

Einfach gesagt: Hab ich den PMK, kann ich den Datenverkehr entschlüsseln.

### Ist das eigentlich ein Problem, dass alle Menschen den Schlüssel kennen?

Ich würde sagen: Ja!
Auch wenn heute fast der vollständige Datenverkehr im Internet (zusätzlich) Ende-zu-Ende verschlüsselt ist (Stichwort HTTPS), so gibt es dennoch Dienste, die unverschlüsselt laufen (Namensauflösung: DNS), zudem sind natürlich die eigentlichen Verbindungsdaten nicht verschlüsselt.
Heißt also: Alle Menschen mit Kenntnis des Wlan Schlüssels können schauen, welche Computer da so drin sind und was die so für Internetseiten aufrufen, wenn sie auch nicht den Inhalt der Internetseiten bekommen.

Überzeugt?

### Wovor möchte ich mich schützen
Jetzt wird es schwieriger:
Ich find es cool, Menschen so einfach wie möglich eine Internetverbindung anzubieten.
Ich finde es uncool, wenn Menschen, die ich nicht kenne/denen ich nicht vertraue, Services in meinem Netz nutzen können. Das kann sein:
  * Drucker (Angst, nen Stapel Schmierpapier im Office vorzufinden)
  * Öffentlicher Upload Ordner auf dem Server (Angst, dass der von Menschen vollgemüllt oder mit Viren versehen wird)
  * Nicht genügend geschützte Geräte meiner Freunde werden einer Gefahr ausgesetzt
  * Ungeschützte Geräte, welche ich selbst ins Netzwerk hänge, weil "ist ja sonst keiner drin"

Das geht eng einher mit der letzten Frage.

### Wie lösen wir das Problem?
Zum Glück hat die moderne Technik Lösungen für alle Probleme parat :-)

* Nur-Internet-Netz: Ein zweites Netzwerk-im-Netzwerk erlaubt den Zugriff ausschließlich auf das Internet. Zugriff der Clients untereinander auf sich selbst sowie Zugriff aufs private Heimnetz wird blockiert. Zusätzlich kann der Zugriff ins Internet in der Geschwindigkeit limitiert werden.
* privates Heimnetz: Wie es überall so ist, alle dürfen alles :-)
* separierte Netze für spezielle Geräte: Optional kann z.B. der Drucker in ein eigenes Netzwerk um vom Internet abgekapselt zu werden. Dies kann sinnvoll sein, wenn es z.B. keine Updates mehr gibt.

### Wie lösen wir im Kanthaus das Problem?
Das Wlan wird zum Wlan "kanthaus" und nutzt WPA Enterprise. Bitte wähle als Authentifizierungsmethode
* EAP-TTLS-MSCHAPv2
* oder PEAP

und aktiviere die Überprüfung des CA Zertifikats, welches du [hier](/user/pages/media/kanthaus_ca.pem) herunterladen kannst. Damit stellt dein Gerät beim Verbinden sicher, dass er sich wirklich nur mit dem Kanthaus-Netzwerk verbindet und nicht etwa mit einem gleichnamigen Netzwerk des Nachbarn (oder einer sonstigen Entität, welche ein Interesse daran haben könnte, dass du deinen Datenverkehr über sie abwickelst).
Wenn du das CA-Zertifikat prüfst, darfst du auch EAP-TTLS-GTC als Authentifizierungsmethode verwenden: Diese sendet dein Passwort im Klartext an das Kanthaus-Netzwerk.
