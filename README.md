# apiCalculator

lien du repository : https://github.com/nuht/apiCalculator.git

# Marche à suivre pour mettre en place le projet :

1. Cloner le repository.
2. Faire la commande : `$composer install`
3. Créer une base de donnée pour accueillir les différentes tables avec un utilisateur spécifique à cette base de donnée.
4. Modifier le fichier .env avec les informations de la base de donnée et de l'utilisateur crée précédemment.
5. Faire la commande : `$php bin/console make:migration`
6. Faire la commande : `$php bin/console doctrine:migrations:migrate`

# Tester l'api avec Postman

1. Récupérer la collection Postman avec ce lien https://www.getpostman.com/collections/305cf142c58e21930a3b

2. Utiliser la requête "Create an Api User" pour créer un user avec l'username, l'email et le password voulu (l'username est unique, l'email doit être valide et le mot de passe doit faire au moins 8 caractères minimum).

exemple du body :
{
	"username": "user",
	"email": "user@email.com",
	"password": "useruser"
}

3. Utiliser la requête "Create an Api Client" puis copier le "client_id" et "client_secret" récupéré.

exemple du résultat :   `"client_id": "1_1ntd1vyxi9a8swcsowck0co8cco88ccc0gwkos88cscockkck",
            "client_secret": "p48gsvqpqaokowc840w44kc4gkk8c84k8k4488s040okg48ks"`

4. Utiliser la requête "Get User Token" et modifier le json dans le body avec comme client_id et client_secret le résultat de la requête obtenu au 2
Ainsi que l'username et password de l'user crée à la requête du 3. 
exemple du body :
`{
    "client_id": "1_1ntd1vyxi9a8swcsowck0co8cco88ccc0gwkos88cscockkck",
    "client_secret": "p48gsvqpqaokowc840w44kc4gkk8c84k8k4488s040okg48ks",
    "grant_type": "password",
    "username": "user",
    "password": "useruser"
}`

exemple du résultat :

`{
    "access_token": "Njc0OTU3ZmVjZjU2YTA0M2FiOTBkZWY1MTFlMzc5YmQ0Y2Y2OTIyMjRkYjBhODdhZjU5N2ZkNzZhY2JjOWIwOQ",
    "expires_in": 86400,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "OTNmNGYzOWEyZDk4YTgzZWY1NWQ3MmU5OWU0Y2ZkZDg1N2NjOWEyOTBjZjg0OTBmMTI2OWE5NTk1YmEzNGNiOQ"
}`

Puis copier l'access_token obtenu. Celui ci servira de jeton d'accès dans toutes les autres requêtes de l'api.

5. Tester les autres requêtes en modifiant le header 'authorization' avec comme valeur 'Bearer' et l'access_token précédemment obtenu.
exemple : `Bearer YTU0NDIzODczY2UwMGJmNTc0MzgzNDg0ZGQ2N2JjMzc4MDE2ZTNmNDMwMGRlZTQ3MDQyOGQ0ODAzZjU3ZWUwNA`
