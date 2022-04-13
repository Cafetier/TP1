# This is the exam for prog
This project will be using
- PHP
- HTML
- CSS
- JS
- bootswatch/bootstrap

## Requirement
- Une liste (ordonnée ou non) (select)
- Deux tableaux (table, td, tr)
- Deux images (img)

Un à deux formulaire(s) d'envoi de données, qui contiennent au moins :
- Quatre zones de texte (input text)
- Une liste déroulante (select)
- Un champ adresse email (email)
- Un champ mot de passe (password)
- Des boutons radio et checkbox
- Un bouton annuler (qui permet d'annuler la saisie)
- Deux boutons submit

## Ideas for website
Boutique de chaussure
bootswatch theme : Quartz (https://bootswatch.com/quartz/)
nom du site : Shoes pro shop (like bass pro shop)
Promo
- Buy 1 get one half
- order 200 or more get a free tshirt

## What is left to do 
### PHP
- [Index] _getproducts needs to set param of function with get value
- [Index] sql query should only return the first 50
- [Account] show input in value information already in bd
- [Register] if 16 yo or more, cannot signup
- [Index] faire un picturama promotions
- [Index] async Search function shoes
- Add admin in db to add products
- Remove sub directory in url and not show index page
ex : localhost/Login
localhost/Product/[id]
- Remove index.php and make htaccess redirect to the real index
- Better error handling
- Female/male shoes db ?
- Forgot password

### Design
- [nav] Register and Connection should be right aligned
- [nav] Sticky nav
- [nav] responsive hamburger cursor : pointer
- [footer] need to be at bottom of page
- [error] cooler 404 page
- [more] More footer stuff
- Favicon
- Fix transition on chrome
- [Home] A filter menu


### Xavier
- Page active (dans le menu de navigation)
- Traduction, fautes
- Picturama de promo sur la page d'accueil
- Contenu de la page a propos
- Affichage des produits dans la page principal
- Ajouter les inputs de la page Mon compte



## Resources
Storing hex code for color : https://www.itsolutionstuff.com/post/mysql-hexadecimal-color-code-store-in-binary-datatype

Database schema : https://lucid.app/lucidchart/8c993271-8345-4c3d-92a4-f496740a3991/edit?invitationId=inv_716db6c2-8fc1-47ac-bd14-c1fc1626d4db


## Production
Be SURE to do all the steps below before going into prod :
- NO default password in database
- Create special user for application in db
