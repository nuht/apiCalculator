# apiCalculator

lien du repository : https://github.com/nuht/apiCalculator.git

Je vous remercie de m'avoir donné la chance de réaliser cet exercice. Je me suis inspiré des explications de cette personne car je n'avais jamais eu la chance de créer une api avant : https://www.adcisolutions.com/knowledge/getting-started-rest-api-symfony-4 
J'ai par la suite regretté le bundle fosuserbundle car je n'ai pas réussi à utiliser la validation des données avec les formulaires et j'ai donc dû faire ma validation moi même lors de la création d'un user. L'expérience a été très enrichissante pour moi, j'espère que vous serez satisfait du résultat.
C'est aussi la première fois que j'utilise Postman.

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

exemple du résultat : 

`{
    "client_id": "1_1ntd1vyxi9a8swcsowck0co8cco88ccc0gwkos88cscockkck",
    "client_secret": "p48gsvqpqaokowc840w44kc4gkk8c84k8k4488s040okg48ks"
}`

4. Utiliser la requête "Get User Token" et modifier le json dans le body avec comme client_id et client_secret le résultat de la requête obtenu au 2.
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

5. Tester les autres requêtes en modifiant le header 'Authorization' avec comme valeur 'Bearer' et l'access_token précédemment obtenu.
exemple : `Bearer YTU0NDIzODczY2UwMGJmNTc0MzgzNDg0ZGQ2N2JjMzc4MDE2ZTNmNDMwMGRlZTQ3MDQyOGQ0ODAzZjU3ZWUwNA`

# Pour réaliser un calcul

1. Il suffit d'utiliser la requête correspondante au type de calcul voulu et de modifier dans le body les différent paramètres en fonction des nombres voulus. Sans oublier de joindre l'access_token de notre user dans l'header de la requête comme expliqué précédemment dans le 5.

exemple du body :
`{
    "parameterOne": "6",
    "parameterTwo": "15"
}`

Le résultat est ensuite obtenu sous cette forme dans le retour de la requête:

`{
    "result :": 21
}`

2. Il est possible de supprimer le dernier calcul de l'utilisateur connecté actuellement avec la requête "Delete last user calculation". Il suffit juste de joindre l'access_token de l'user correspondant dans l'header de la requête.

3. Il est aussi possible de récupérer l'historique des calculs d'un user avec la requête "Get all calculates" en n'oubliant pas de joindre l'access_token de l'user voulu dans l'header de la requête.

