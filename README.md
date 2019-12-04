# apiCalculator

lien du repository : https://github.com/nuht/apiCalculator.git

# Marche à suivre pour mettre en place le projet :

1. Cloner le repository.
2. Faire la commande : $composer install
3. Créer une base de donnée pour accueillir les différentes tables avec un utilisateur spécifique à cette base de donnée.
4. Modifier le fichier .env avec les informations de la base de donnée et de l'utilisateur crée précédemment.
5. Faire la commande : `$php bin/console make:migration`
6. Faire la commande : `$php bin/console doctrine:migrations:migrate`
7. 