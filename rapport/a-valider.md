# À valider

## Tâche 1 — CTA « Discuss your needs with an expert »
- Le bloc retiré (conteneur `zx-c6451ad`) contenait aussi l'embed HubSpot Meetings (`meetings.hubspot.com/olivier-lachapelle`), le lien texte « Book a meeting » et le bouton. L'embed fait partie de la même section et a été retiré avec elle. À confirmer si le client veut le conserver (le HTML de l'avant est dans `rapport/avant/`).
- Le lien https://erp.nxtprocess.com/book/003a8b37 est toujours présent dans les pages suivantes, non modifiées :
  - https://www.zytho.ca/distribution-2/ (ID 3895, publiée, interdit de modifier)
  - https://www.zytho.ca/fr/distribution-2/ (ID 20945, publiée, interdit de modifier ; URL FR à confirmer)
  - brouillons : 3835 (distribution-2-elementor-ancienne), 18816 (nouvelle-distribution-elementor-ancienne) ; corbeille : 20905, 20910.

## Note technique
- `site_info` indique `can_write: false` alors que l'écriture fonctionne (faux positif confirmé par le client et par les éditions réussies).
- `create_backup` (db) a expiré côté outil (60 s). La sauvegarde 8df6b380-126d-4d6c-a616-7cf67493463f (29,6 Mo, 2026-10-23 15:44 UTC) est enregistrée sur le site ; sa copie externe a échoué (SignatureDoesNotMatch). Les sauvegardes planifiées vers Google Drive sont aussi en échec partiel depuis le 22 octobre.
- `execute_php` est désactivé par le plugin Hari ; les lectures se font par `db_query`.
