# Synthèse — corrections SEO post-migration (https://www.zytho.ca/)

Date : 2026-10-23. Sauvegarde de la base avant écriture : 8df6b380-126d-4d6c-a616-7cf67493463f (copie externe en échec, copie sur le site). Journal complet : `rapport/journal-modifications.csv` (2 256 lignes). Points à trancher : `rapport/a-valider.md`.

## 1. Ce qui a été fait

| Tâche | Résultat | Volume |
|---|---|---|
| 1. CTA « Discuss your needs with an expert » retiré | Fait sur https://www.zytho.ca/distribution/ (ID 18814) et https://www.zytho.ca/fr/nouvelle-distribution/ (ID 20943), HTML d'origine dans `rapport/avant/` | 2 pages |
| 2. Liens `Zythoprocess.com` | Remplacés par l'équivalent interne de la même langue dans les 4 fiches Ampco demandées (ex. https://www.zytho.ca/product/ampco-lc-series/ et https://www.zytho.ca/fr/produit/serie-ampco-lc/) ; liens morts `ampco-ld/lf/lm/lh` corrigés aussi | 14 liens de contenu, 2 extraits |
| 3. Yoast | Titres/descriptions des pages (≤ ~60 car. pour les titres, descriptions 140–155 car.) et **337 des 343** méta-descriptions de produits (166 EN, 171 FR, lots de 50) | 30 pages, 337 produits |
| 4. Alt des images | Posés dans la langue de chaque version, aucun alt existant remplacé (5 conservés) | 1 854 images ; couverture 1 859 sur 1 915 (97 %) |
| 5a. Données structurées produit | Diagnostic uniquement (rien à corriger simplement) : le `Product` est bien présent sur les fiches avec prix | — |
| 5b. URL de filtres | `robots.txt` physique : `Disallow: /*?*zytho_categories=` et `/*?*zytho_brands=` ; /shop/, /product/, /product-category/ et équivalents FR intacts | 1 fichier |
| 6. Liens du catalogue | Balayage de 293 URL uniques, résultat dans `rapport/liens-catalogue.csv` ; aucun lien interne cassé, donc rien corrigé | 0 modification |
| 7. Sélecteur de langue mobile | Diagnostic et captures ; non corrigé (gabarit) | voir ci-dessous |

Aucun H1 touché, pages `distribution-2` (EN 3895, FR 20945) intactes, rien dans Search Console, ni le constructeur ni le gabarit modifiés. Cache de pages WP Rocket vidé après chaque lot ; pages contrôlées en 200 (ex. https://www.zytho.ca/fr/, https://www.zytho.ca/distribution/, https://www.zytho.ca/fr/nouvelle-distribution/).

## 2. Ce qui a échoué ou a été contourné
- `create_backup` a expiré côté outil ; la sauvegarde a tout de même été créée sur le site (copie externe en échec, comme les sauvegardes Google Drive planifiées depuis le 22 octobre).
- `execute_php` est désactivé, `bulk_alt_text` plafonne à ~49 images par appel : le reste des alt a été écrit par requêtes SQL ciblées sur `_wp_attachment_image_alt`.
- Le robots.txt modifié est servi par le serveur, mais **Cloudflare garde l'ancienne version** (Hari ne peut pas la purger, site non relié à Hostinger).
- `site_info` affiche `can_write: false` : faux positif confirmé, les écritures fonctionnent.

## 3. Ce qui reste à valider (détails dans `rapport/a-valider.md`)
- **À faire par vous : purger `/robots.txt` dans Cloudflare** (https://www.zytho.ca/robots.txt).
- Section CTA retirée : elle contenait aussi l'embed HubSpot Meetings ; confirmer qu'il ne doit pas rester. Le lien erp.nxtprocess.com reste sur les pages `distribution-2` (interdites).
- 5 fiches vides sans méta-description, ignorées : EN 9375, 18642 ; FR 14227, 16098, 18643 (la 6e, ID 18682, est faite).
- 500 produits sur 969 ont un titre Yoast trop long (`… - Pour brasseries professionnelles | Zytho`) : proposition de retirer ce segment, non appliquée.
- Slug FR corrigé le 23/10 : https://www.zytho.ca/fr/sonde-pour-gaz-dissous/ (redirection 301 depuis l'ancien).
- Fiches FR retravaillées le 23/10 (câblable, carbonatation, titres traduits) ; restent les fautes EN (« Hygenic »).
- Les 56 dernières images ont un alt tiré du nom de fichier (peu descriptif) ; relecture visuelle des alt des pages d'accueil, « Why Zytho », « Consultation », « Distribution ».
- Champ `documentation` des 10 fiches (PDF Zythoprocess.com) : non affiché sur le site, ignoré à la demande du client.
- Produits sur devis (87 sans prix, 9 à 0 $) : pas de `Product` structuré (normal, Google exige un prix) ; défauts à corriger : double encodage `&amp;amp;`, deux `BreadcrumbList`, fiche 4360 « Uncategorized » ; recontrôler « Extraits de produits » dans Search Console dans quelques jours.

## 3 bis. Mise à jour du 23/10 (après validation du client)
- robots.txt : nouvelle version bien servie (8 `Disallow`), cache Cloudflare purgé par le client. Point clos.
- Sélecteur de langue mobile : corrigé, lien FR/EN à côté du panier (captures `apres-*`).
- Titres Yoast produits : 519 raccourcis (51 restent longs car le nom seul dépasse 60 caractères).
- Liens 404 : retirés de 98 fiches (contenu) et 14 champs `documentation` ; seules les pages `distribution-2` (interdites) gardent le lien erp.nxtprocess.com.
- Données structurées : doublon de fil d'Ariane et double encodage corrigés (mu-plugin) ; fiche 4360 recatégorisée.
- À décider : fiche 18682 (contenu FR classé EN) et fiche 4355 (doublon FR orphelin) ; 12 produits encore « Uncategorized » ; fiches vides ignorées.

## 4. Liens cassés restants (`rapport/liens-catalogue.csv`)
- **40 en 404/410** : 34 PDF Dixon (www.dixonvalve.com, dixonvalve.com, canada.dixonvalve.com), 3 brochures Ampco sur ampcopumps.com (14 fiches EN/FR), https://erp.nxtprocess.com/book/003a8b37 (page `distribution-2`, intouchable).
- **5 erreurs DNS** : les PDF Zythoprocess.com ci-dessus.
- **59 en 403/429** : pare-feu Dixon/YouTube, à vérifier dans un navigateur ; 3 redirections de tiers (gormansmith.com ×2, article Microsoft/Internet Explorer) à confirmer.
- **Liens internes zytho.ca** : 64 testés, 0 cassé.

## 5. Sélecteur de langue sur mobile (`rapport/selecteur-langue-mobile.md`)
- **État** : absent sur mobile (≤ 767 px), visible sur tablette et bureau. Captures : `rapport/captures/avant-accueil-en-mobile.png`, `avant-accueil-fr-mobile.png`, `avant-accueil-en-tablette.png`.
- **Cause** : le sélecteur WPML est dans la barre supérieure de l'en-tête du thème, qui est masquée sur mobile (`elementor-hidden-mobile`), et le menu hamburger n'a aucun élément de langue.
- **Non corrigé** (touche au gabarit et à un choix de design). Solution proposée : ajouter un élément de langue dans le menu mobile (bloc « Language Switcher » WPML) ; pas de capture « après » puisque rien n'a changé.
