# Sélecteur de langue EN/FR sur mobile — diagnostic (2026-10-23)

## Résultat
**Le sélecteur de langue n'est pas visible sur mobile (≤ 767 px). Aucune modification n'a été faite** : la correction touche au gabarit d'en-tête (thème enfant) et demande un choix de design, donc documentée dans `rapport/a-valider.md`.

## Captures (état actuel, « avant » ; pas de capture « après » puisque rien n'a été modifié)
| Appareil | Page | Fichier | Sélecteur visible ? |
|---|---|---|---|
| Mobile 390×844 | https://www.zytho.ca/ | `rapport/captures/avant-accueil-en-mobile.png` | Non (logo, panier, recherche, hamburger) |
| Mobile 390×844 | https://www.zytho.ca/fr/ | `rapport/captures/avant-accueil-fr-mobile.png` | Non |
| Tablette 768×1024 | https://www.zytho.ca/ | `rapport/captures/avant-accueil-en-tablette.png` | Oui (« English ▾ » en haut à gauche) |

## Analyse du HTML rendu et du code
- L'en-tête est rendu par le thème enfant (option `zytho_hf_live` = 1) : `inc/zytho-hf.php`, gabarits `zy-hf/header-en.php` et `header-fr.php`, CSS `zy-css/hf-common.css`.
- Le sélecteur est le shortcode `[wpml_language_selector_widget]` (menu déroulant WPML « legacy dropdown click », classes `wpml-ls-legacy-dropdown-click`), placé dans le premier conteneur de l'en-tête (`zytho-header-upper`) avec le numéro de téléphone (514) 613-6535 et « My Account ».
- Ce conteneur porte `elementor-hidden-mobile`, et le CSS `@media (max-width:767px){ .elementor .elementor-hidden-mobile{display:none} }` le masque sur téléphone, sélecteur compris.
- Le menu hamburger (`top-menu-en`, 59 éléments ; `menu-mobile-fr`, 12 éléments) ne contient aucun élément de langue. La règle `nav .wpml-ls-item{display:none!important}` (≥ 1025 px) ne joue pas ici : elle cache seulement un éventuel sélecteur inséré dans un menu sur bureau.
- Réglages WPML : 2 langues actives (en, fr), langue dans un répertoire (`/fr/`), `icl_lso_link_empty` = 1 (le sélecteur renvoie vers l'accueil de la langue si une page n'a pas de traduction), pas de masquage des sélecteurs côté WPML ; ce n'est donc pas un réglage WPML.

## Liens du sélecteur (traduction de la page courante)
Contrôlés en 200 : https://www.zytho.ca/ ↔ https://www.zytho.ca/fr/ ; https://www.zytho.ca/distribution/ ↔ https://www.zytho.ca/fr/nouvelle-distribution/ ; https://www.zytho.ca/product/ampco-lc-series/ ↔ https://www.zytho.ca/fr/produit/serie-ampco-lc/ (paires WPML liées). Non contrôlé page par page sur mobile, puisque le sélecteur n'y est pas affiché.

## Solution proposée
1. Ajouter dans le menu mobile un élément de langue : bloc « Language Switcher » de WPML dans le menu (Apparence > Menus), ou, dans `zytho_hf_menu()`, un `<li>` généré par `apply_filters('wpml_active_languages')` qui pointe vers la traduction de la page courante.
2. Ou sortir le sélecteur seul du conteneur masqué et l'afficher à côté du panier sur mobile.
3. Après la modification : vider WP Rocket et Cloudflare, puis refaire les captures 390/768/bureau.

## Correction appliquée le 2026-10-23 (validée par le client : « le sélecteur seul à côté du panier »)
- Ajout d'un lien de langue (« FR » sur les pages EN, « EN » sur les pages FR) à côté du panier, visible uniquement ≤ 767 px. Il pointe vers la traduction de la page courante (fonction WPML `wpml_active_languages`) ; les menus et la barre du haut (bureau/tablette) ne changent pas.
- Fichiers : `zy-hf/header-en.php`, `zy-hf/header-fr.php`, `zy-css/hf-extra.css` du thème enfant. Copies de sauvegarde : `header-en.php.bak-20261023` et `header-fr.php.bak-20261023` dans le même dossier. Retour arrière : remettre ces copies et retirer le bloc `.zy-ls-mobile` du CSS.
- Captures « après » : `rapport/captures/apres-distribution-en-mobile.png` (bouton FR, page https://www.zytho.ca/distribution/) et `rapport/captures/apres-accueil-fr-mobile.png` (bouton EN, page https://www.zytho.ca/fr/).
- Contrôles : les deux pages répondent 200 ; le lien de https://www.zytho.ca/distribution/ vise la traduction FR (https://www.zytho.ca/fr/nouvelle-distribution/).
