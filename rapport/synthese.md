# Synthèse — corrections SEO post-migration (https://www.zytho.ca/)

Date : 2026-10-23

## État : mission arrêtée avant toute écriture

Règle 1 : « Si l'écriture est refusée, arrête-toi et note-le dans le rapport. »

- `site_info(site="https://www.zytho.ca")` retourne `"can_write": false` (`"safety": true`).
- `list_sites()` confirme `can_write: false` pour https://www.zytho.ca (db_id 36051b5a-273c-4d4e-b687-1250170f36d9).
  Les 14 sites appariés au compte Hari sont tous en `can_write: false`.
- Aucune sauvegarde (`create_backup`) n'a été lancée. Elle n'aurait de toute façon pas protégé de modifications, puisqu'aucune n'est permise.

## Ce qui a été fait
Rien n'a été modifié : 0 page, 0 produit, 0 image.

## Ce qui a échoué
Les tâches 1 à 7 n'ont pas été exécutées, faute d'accès en écriture.

## Ce qui reste à valider
Tout le plan reste à faire. Pour reprendre :
1. Activer l'écriture pour https://www.zytho.ca dans Hari (appairage ou mode lecture seule/« safety » du site, dans le tableau de bord Hari).
2. Relancer la mission. Elle recommencera par `site_info`, puis `create_backup` (mode=db).

Les tâches 5a, 6 et 7 (diagnostics, balayage de liens, captures) sont surtout en lecture. Je les ai laissées de côté pour respecter l'ordre prévu et la consigne « arrête-toi ». Elles peuvent être faites en lecture seule si vous le souhaitez.

## Liens cassés restants
Non analysés. Connus d'avance : https://erp.nxtprocess.com/book/003a8b37 (404), le lien mort https://www.Zythoprocess.com/product/ampco-lc-series/, le PDF Dixon `1447 58-01.pdf` (404) et `STC-360-R100.PDF` (403).

## Sélecteur de langue sur mobile
Non vérifié.
