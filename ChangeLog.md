
## Unreleased (2026-06-15)

#### :rocket: Enhancement
* Création rapide : cliquer-glisser sur une plage horaire ouvre un popup de création pré-rempli avec la date et l'heure sélectionnées. Boutons Ajouter, Clôturer. ([@frederic34](https://github.com/frederic34))
* Masquage des calendriers : décocher un calendrier dans le panneau gauche masque instantanément ses événements via CSS, sans rechargement. ([@frederic34](https://github.com/frederic34))
* Popup d'édition rapide : clic sur un événement ouvre un dialogue jQuery UI avec tous les champs éditables (libellé, dates, lieu, pourcentage, note). Boutons Enregistrer, Supprimer, Voir la fiche, Clôturer. Les événements en lecture seule (ICS, anniversaires, auto) affichent un dialogue d'information non modifiable. ([@frederic34](https://github.com/frederic34))
* Filtres tiers et projets convertis en Select2 à défilement infini (20 résultats par page, chargement immédiat sans minimum de caractères). ([@frederic34](https://github.com/frederic34))
* Filtre utilisateurs converti en Select2 à défilement infini. ([@frederic34](https://github.com/frederic34))
* Largeur uniforme de 200 px pour tous les selects de filtrage. ([@frederic34](https://github.com/frederic34))
* Label « Journée » (all-day) traduit via l'option `allDayContent` d'EventCalendar. ([@frederic34](https://github.com/frederic34))

#### :bug: Bug Fix
* Anti-scintillement : fusion de toutes les sources d'événements (Dolibarr, anniversaires, ICS) en un seul `Promise.all` → `successCallback` appelé une seule fois, plus de flash au rechargement. ([@frederic34](https://github.com/frederic34))
* Calendriers ICS externes : correction du cache — le contenu brut `.ics` est désormais stocké sur disque et reparsé via `ICal::initString()`, évitant la perte des méthodes lors de la sérialisation JSON. ([@frederic34](https://github.com/frederic34))
* Calendriers ICS externes : correction du chargement dans EventCalendar v5. ([@frederic34](https://github.com/frederic34))
* Événements en lecture seule (ICS, anniversaires) : glisser-déposer et redimensionnement désormais bloqués via `startEditable: false` / `durationEditable: false`. ([@frederic34](https://github.com/frederic34))
* Famille du module corrigée : `agenda` → `projects`. ([@frederic34](https://github.com/frederic34))

#### :house: Internal
* GitHub Actions restructurés : `main.yml` = CI lint pur (PHPCS, Parallel Lint, VarDump) ; `changelog.yml` = release (traductions + bump version + zip). Suppression de `lerna-changelog` (incompatible avec les commits directs). Correction de la boucle infinie de bump. Mise à jour des actions : `checkout@v4`, `setup-node@v4` + Node 22, `git-auto-commit-action@v5`. ([@frederic34](https://github.com/frederic34))

#### :memo: Documentation
* README entièrement mis à jour : nouvelles fonctionnalités, famille du module, API AJAX complète. ([@frederic34](https://github.com/frederic34))
* Captures d'écran régénérées (Dolibarr 24.0-beta). Nouvelles : `popup-edition.png`, `popup-creation.png`, `calendrier-masque.png`. ([@frederic34](https://github.com/frederic34))

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
