# This is the exam for prog
This project will be using
- PHP
- HTML
- CSS
- JS
- bootswatch/bootstrap

## Requirement
- ~~Une liste (ordonnée ou non) (select)~~
- Deux tableaux (table, td, tr)
- ~~Deux images (img)~~

Un à deux formulaire(s) d'envoi de données, qui contiennent au moins :
- ~~Quatre zones de texte (input text)~~
- ~~Une liste déroulante (select)~~
- ~~Un champ adresse email (email)~~
- ~~Un champ mot de passe (password)~~
- ~~Des boutons radio et checkbox~~
- ~~Un bouton annuler (qui permet d'annuler la saisie)~~
- ~~Deux boutons submit~~

## Ideas for website
Boutique de chaussure
bootswatch theme : Quartz (https://bootswatch.com/quartz/)
nom du site : Shoes pro shop (like bass pro shop)
Promo
- ~~Buy 1 get one half~~
- ~~order 200 or more get a free tshirt~~

### New idea
You can just wishlist shoes and it shows where it is avalaible with links and photo

## What is left to do 
### PHP
- Nullable checkbox for each filter (so you can deactivate the filter)
- [Shop] Reset btn doesnt work
- Combine images/colors/sizes into array
- [Shop] Filter size do not return just 10.5, but 10 too
- Offset product (Product.class)
- [Shop] sql query should only return the first 50
- [Account] show input in value information already in bd
- [Index] Suggestion de soulier
- [DB] Add more dummy data
- Show successfull alert when good thing (inscription successfull, changed information successfully)
- Ajouter pagination
- Add Phone number bd...
- Add admin in db to add products
- Remove sub directory in url and not show index page
ex : localhost/Login
localhost/Product/[id]
- Remove index.php and make htaccess redirect to the real index
- Female/male shoes db ?
- Breadcrumbs
- Alt text for image in db

### Design
- [nav] Register and Connection should be right aligned
- [nav] little bar that separate login and register (hr)
- [Shop] Change color of size slider point
- [Shop] No product better style
- [Home] Hover card for brands
- [Shop] Hover card product
- [error] cooler 404 page
- [Shop] margin-top pagination
- background needs a gradient


### Xavier
- [nav] Page active (dans le menu de navigation)
- Traduction anglaise
- Page produit
- Contenu de la page a propos
    - faire deux tableaux a linterieur
- [Footer] Better aligned text in footer
- [Shop] Ajouter images de produits
- Filmer la video pour montrer le site



## Resources
Storing hex code for color : https://www.itsolutionstuff.com/post/mysql-hexadecimal-color-code-store-in-binary-datatype

Database schema : https://lucid.app/lucidchart/8c993271-8345-4c3d-92a4-f496740a3991/edit?invitationId=inv_716db6c2-8fc1-47ac-bd14-c1fc1626d4db

color palette : https://coolors.co/252323-70798c-f5f1ed-dad2bc-a99985

### fonts
Poster          : Eras
Logo            : Harlow Solid Italic
Web             : 


## Production
Be SURE to do all the steps below before going into prod :
- NO default password in database
- Create special user for application in db
- Deactivate the __DEBUG__ constant in src/constants.php
