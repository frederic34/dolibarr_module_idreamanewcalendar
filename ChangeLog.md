
## Unreleased (2026-06-15)

#### :rocket: Enhancement
* Popup d'édition rapide : clic sur un événement ouvre un dialogue jQuery UI avec tous les champs éditables (libellé, dates, lieu, pourcentage, note). Boutons Enregistrer, Supprimer, Voir la fiche, Clôturer. Les événements en lecture seule (ICS, anniversaires, auto) affichent un dialogue d'information non modifiable. ([@frederic34](https://github.com/frederic34))
* Filtres tiers et projets convertis en Select2 à défilement infini (20 résultats par page, chargement immédiat sans minimum de caractères). ([@frederic34](https://github.com/frederic34))
* Filtre utilisateurs converti en Select2 à défilement infini. ([@frederic34](https://github.com/frederic34))
* Largeur uniforme de 200 px pour tous les selects de filtrage. ([@frederic34](https://github.com/frederic34))
* Label « Journée » (all-day) traduit via l'option `allDayContent` d'EventCalendar. ([@frederic34](https://github.com/frederic34))

#### :bug: Bug Fix
* Anti-scintillement : fusion de toutes les sources d'événements (Dolibarr, anniversaires, ICS) en un seul `Promise.all` → `successCallback` appelé une seule fois, plus de flash au rechargement. ([@frederic34](https://github.com/frederic34))
* Calendriers ICS externes : correction du cache — le contenu brut `.ics` est désormais stocké sur disque et reparsé via `ICal::initString()`, évitant la perte des méthodes lors de la sérialisation JSON. ([@frederic34](https://github.com/frederic34))
* Calendriers ICS externes : correction du chargement dans EventCalendar v5 (pas de `addEventSource`, intégration dans la source unifiée). ([@frederic34](https://github.com/frederic34))
* Événements en lecture seule (ICS, anniversaires) : glisser-déposer et redimensionnement désormais bloqués via `startEditable: false` / `durationEditable: false`. ([@frederic34](https://github.com/frederic34))
* Correction d'une erreur de syntaxe PHP (`\$langs` → `$langs`) dans le code du popup. ([@frederic34](https://github.com/frederic34))

#### :memo: Documentation
* README entièrement mis à jour : nouvelles fonctionnalités, API AJAX (`getaction`, `updateaction`, pagination `getcustomers`/`getprojects`), format des événements EventCalendar v5. ([@frederic34](https://github.com/frederic34))
* Toutes les captures d'écran régénérées (Dolibarr 24.0-beta). Nouvelle capture `popup-edition.png`. ([@frederic34](https://github.com/frederic34))

#### Committers: 1
- Frédéric FRANCE ([@frederic34](https://github.com/frederic34))

---

## 0.1.0 (2026-05-xx)

#### :rocket: Enhancement
* [#1](https://github.com/frederic34/dolibarr_module_idreamanewcalendar/pull/1) add translation ([@frederic34](https://github.com/frederic34))

#### :bug: Bug Fix
* [#3](https://github.com/frederic34/dolibarr_module_idreamanewcalendar/pull/3) rename trigger ([@frederic34](https://github.com/frederic34))

#### Committers: 1
- Frédéric FRANCE ([@frederic34](https://github.com/frederic34))
