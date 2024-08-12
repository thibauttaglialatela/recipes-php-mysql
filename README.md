# Site de recettes de cuisine utilisant PHP, MySQL et PHPMyAdmin
## Prérequis
Assurez vous d'avoir sur votre machine :
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Installation
1. **Cloner le projet**

Cloner ce dépôt Github sur votre machine en locale :
```bash
git clone git@github.com:thibauttaglialatela/recipes-php-mysql.git
cd recipes-php-mysql
```
2. **Créer les fichiers de secrets**
```bash
mkdir secrets
echo "votre-mot-de-passe-root" > secrets/secrets_mysql_root_password.txt
echo "votre-mot-de-passe-utilisateur" > secrets/secrets_mysql_password.txt
```
- Remplacez *votre-mot-de-passe-root* par le mot de passe de votre choix pour l'utilisateur root et *votre-mot-de-passe-utilisateur* par le mot de passe de votre choix pour l'utilisateur user.
- Ces 2 fichiers sont déjà présents dans le .gitignore

## Utilisation
Une fois que les secrets sont configurés, vous pouvez démarrer les services Docker en lançant la commande
suivante :
```bash
docker-compose up -d
```
### Accés aux services
- **Application Web** : Accéder à votre application sur http://localhost:8000
- **PHPMyAdmin** : Accéder à PhpMyAdmin sur http://localhost:8081

### Gestion des données
Les données MySQL sont persistés dans un volume Docker. Aprés l'arrêt du conteneur, elles sont conservées.   
Pour réinitialiser les données, vous pouvez supprimer le volume Docker avec la commande :
```bash
docker compose down -v
```
ou en passant par Docker desktop, si ce dernier est installé sur votre machine.  

Afin de pouvoir utiliser le module de transfert d'images du formulaire de contact, veuillez créer un dossier **uploads/**  
Celui-ci est déjà inclus dans le fichier .gitignore.

