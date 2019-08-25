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

Außerdem gibt es noch PWD, eine Methode, welche auf sichere Art und Weise das Passwort überprüfen kann, ohne es zu leaken. Im Prinzip vereint es die Vorteile von WPA-PSK (einfache Konfiguration im Client) mit Teilen der Sicherheit von Enterprise (eigene PMKs pro Client), ohne jedoch gegen MITM Angriffe (Man\*-in-the-middle, ein Mensch gibt vor, dein Zielnetzwerk zu sein, um deinen Datenverkehr über sich zu leiten. Das Man\* in diesem Fachausdruck bezieht sich auf Menschen oder Maschinen allgemein, ohne auf das Geschlecht des Angreifenden anzuspielen) geschützt zu sein, sofern das Passwort allgemein bekannt ist.

In der ersten Implementierung, welche noch weitere Iterationen und Kommentare benötigt, gibt es mindestens zwei Sätze an Zugangsdaten:
* Bewohni-Zugangsdaten, welche ein einigermaßen geheimes Passwort haben, welches nicht weitergegeben wird (Benutzer resident). Hier landen Menschen im alles-dürfenden "Heimnetz".
* Gast-Zugangsdaten: Benutzer guest mit einem einfachen Passwort. Dieser Benutzer landet automatisch im limitierten Gastnetzwerk.
* Gedanke: Weitere Gast-Zugangsdaten mit Zugriff aufs Heimnetz, bei diesem wird das Passwort alle paar Monate gewechselt.

Optional könnten Menschen auch eigene Zugangsdaten bekommen, was jedoch mit erhöhtem Aufwand verbunden ist.
Derzeit liegen die Zugangsdaten auch im Klartext auf einem unserer AccessPoints, was dann eventuell nicht so schön ist.

### Und wie geht das... technisch?
Das Kanthaus nutzt TP Link Archer C5 Access Points mit OpenWRT. Einer davon - der macht auch DHCP für uns - hat [FreeRADIUS](https://openwrt.org/docs/guide-user/network/wifi/freeradius) installiert und spielt damit den Authentifizierungsserver. Alle AccessPoints machen ein WPA-Enterprise Wlan auf, welche auf diesen RADIUS Server verweisen.
Um die Clients in Abhängigkeit des Benutzendennamens in verschiedene Netze zu stecken, verwenden wir VLANs.
Das sind erstmal "virtuelle Netzwerke" über dasselbe Kabel.
Hostapd, die Accesspoint Software in OpenWRT, unterstützt `dynamic vlan`, um vom RADIUS Server die VLAN Zugehörigkeit eines Users mitgeteilt zu bekommen. Leider sind in OpenWRT aufgrund der ganzen automatischen Funktionen einige Umwege nötig, welche unter [802.1x Dynamic VLANs on an OpenWRT Router](https://openwrt.org/docs/guide-user/network/wifi/wireless.security.8021x) ganz gut beschrieben sind.
Leider hat zudem der Wlan-Treiber für die Archer C5 (ath10k) ein fehlendes Feature an der Stelle... und erforderte viele Stunden rumprobieren und OpenWRT neu bauen, bis dynamic vlan auch hier funktioniert :-) [OpenWRT #488](https://bugs.openwrt.org/index.php?do=details&task_id=488)

Der Ausschnitt aus der `/etc/config/wireless`, welcher für dynamic vlan relevant ist:
```
	option network 'lan'
	option encryption 'wpa2+ccmp'
	option dynamic_vlan '1'
	option vlan_tagged_interface 'eth0'
	option vlan_bridge 'br-vlan'
	option vlan_naming '0'
	option dtim_period '5'
	option ft_bridge 'br-lan'
	option ssid 'kanthaus'
```

Das Hauptnetz heißt bei uns trotzem `lan` - Hauptbenutzer bekommen einfach keine VLAN ID vom RADIUS zurück. Das Gastnetz ist dann br-vlan100 und wird per Kabel zwischen allen AccessPoints verteilt.

### Was kann denn im Wlan noch komplizierter gemacht werden?
Ganz einfach! Alles :-)

Im Kanthaus haben wir derzeit 3 AccessPoints, tendenziell kommt da nochmal einer irgendwann dazu. Nun gibt es da diese Sache namens Roaming: Wie wandert ein Client zwischen den AccessPoints hin und her?
Wlan ist da schon garnicht so schlecht - es gibt die Annahme, dass gleich heißende Wlans auch die gleichen Netze sind. Soweit funktioniert das also out-of-the-box ganz gut.
Doch Optimierungspotential ist immer ;-)
Denn die Authentifizierung in einem Wlan dauert in der Praxis so 500..1500 ms. Ganz schön lange also, wenn z.B. gerade eine Telefonkonferenz läuft.
802.11r oder fast BSS transition oder fast roaming heißt die Praktik, die Übergangszeit zu verkürzen.

Wie funktionierts?

Die AccessPoints kennen sich untereinander und tauschen den PMK miteinander aus - der Client muss sich also nicht neu authentifizieren sondern kann mit ganz wenig hin-und-her einfach zwischen den AccessPoints springen. Dies dauert zwischen 30-50ms.

### Jetzt nochmal technisch
Eigentlich ist das bei OpenWRT ganz einfach:
```
	option ieee80211r '1'
	option mobility_domain 'affd'
	option ft_psk_generate_local '1'
```

Zumindest für PSK Netze: Denn hier kann aufgrund des bekannten Zusammenhangs zwischen SSID, PSK und PMK dieser einfach auf jedem AccessPoint ausgerechnet werden.
Pitfall: `rsn_preauth` musste ich deaktivieren, das führte sowohl mit Notebook als auch mit Android zu fehlgeschlagenem Roaming.
Achja, und es scheint nen Bug zu geben, dass einige Geräte nicht mit 80211r und 80211w (protected management frames) zurechtkommen.
Auch wenn ich 80211w sehr sinnvoll finde, so hab ichs dann jetzt ausgelassen :-(

Und für Enterprise Netze?

```
	option ft_over_ds '1'
	option ft_psk_generate_local '0'
	option pmk_r1_push '1'
	option ft_bridge 'br-lan'
	option ssid 'kanthaus'
	list r0kh '30:B5:C2:75:97:05,30b5c2759705,AESKEYHERE'
	list r0kh '32:B5:C2:75:97:06,32b5c2759706,AESKEYHERE'
	list r0kh '30:B5:C2:E4:A4:E5,30b5c2e4a4e5,AESKEYHERE'
	list r0kh '30:B5:C2:E4:A4:E6,30b5c2e4a4e6,AESKEYHERE'
	list r0kh 'E8:DE:27:83:4F:1D,e8de27834f1d,AESKEYHERE'
	list r1kh '30:B5:C2:75:97:05,30:B5:C2:75:97:05,AESKEYHERE'
	list r1kh '32:B5:C2:75:97:06,32:B5:C2:75:97:06,AESKEYHERE'
	list r1kh '30:B5:C2:E4:A4:E5,30:B5:C2:E4:A4:E5,AESKEYHERE'
	list r1kh '30:B5:C2:E4:A4:E6,30:B5:C2:E4:A4:E6,AESKEYHERE'
	list r1kh 'E8:DE:27:83:4F:1D,E8:DE:27:83:4F:1D,AESKEYHERE'
```

Der Mechanismus lautet "fast transition over distribution system" - der Accesspoint, hier auch in der Rolle als R0 Key Holder, sendet den PMK AES verschlüsselt über Kabel an alle anderen (potentiellen) R1 Key Holder.
Deswegen müssen diese auch mit der relativ kryptischen Syntax bekannt gemacht werden.

Theoretisch hat hostapd eine Wildcard/Broadcast Möglichkeit, die [in diesem Dokument der FEM TU Ilmenau beschrieben ist](https://blog.fem.tu-ilmenau.de/archives/1002-HowTo-enable-WiFi-roaming-with-hostapd-and-VLANs.html).
Leider hab ich das nie zum Laufen bekommen - ich habe die Broadcast Pakete nicht sehen können und bin beim Lesen des Sourcecodes von Hostapd unschlüssig, ob das überhaupt so funktionieren kann, wie der Artikel bzw. ich uns das vorstellen. Vorteil wäre, dass dann nur 2 Zeilen statt (2 x Anzahl AccessPoints) benötigt werden.

Und weil das so kompliziert aufzusetzen ist, hab ich mir dafür ein kleines Script geschrieben:
[OpenWRT Config Generator](https://github.com/NerdyProjects/OpenWRT-Config-Generator)
