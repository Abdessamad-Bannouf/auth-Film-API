
# Authentification pour l'API des films

# Contexte

API's d'authentification de films



# Installation du projet :  
  
    ● Cloner le projet : git clone https://github.com/Abdessamad-Bannouf/auth-Film-API.git

    ● Lancer la commande : docker-compose up -d

    ● Lancer la commande : docker exec -it sf-auth bash
    
    ● Installer le gestionnaire de dépendance : composer  
        
    ● Lancer la commande : php bin/console doctrine:database:create  
      
    ● Lancer la commande : php bin/console make:migration  

    ● Lancer la commande : php bin/console doctrine:migrations:migrate  

    ● Lancer la commande : php bin/console doctrine:fixtures:load

    ● Créer le dossier jwt sous le dossier config.

    ● Avec un terminal allez dans le dossier jwt

    ● Ensuite créer la clé privée avec la commande :  openssl genrsa -out private.pem 409

    ● Ensuite créer la clé publique avec la commande : openssl rsa -in private.pem -outform PEM -pubout -out public.pem
    
    ● Lancer Postman :
    
    ● Pour le login : 
        ● Allez sur la route :  http://localhost:9900/api/token

        ● dans l'onglet raw de body mettez votre username et password sous forme JSON :

        exemple {
            "username": "admin@test.com",
            "password": "admin"
        }

    ● Pour le refresh token :
        ● Allez sur la route :  http://localhost:9900/api/refresh-token

        ● dans l'onglet raw de body mettez votre refresh token sous forme JSON :

        exemple {
            "refresh_token": "votre refresh token",
        }

    - Le temps pour l'access token est de 1 heure soit 3600 secondes (voir le fichier lexik_jwt_authentication.yaml)
    - Le temps pour le refresh token est de 2 heures soit 7200 secondes (voir le fichier gesdinet_jwt_refresh_token.yaml)

    PS : le contrat d'interface n'a pas pu être respecté entre autres pour le refresh token et la validation de l'access token

