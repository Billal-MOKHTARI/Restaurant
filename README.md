## Environnement d'exécution : Windows/Linux

## installation des packages (node modules)
```bash
npm install json-server@0.17.3
```
## Partie client
```bash
cd restaurant/client/ && npm install
cd ../server/ && npm install 
```
## Démarrage des serveurs; JSON, Node et React respectivement. 

```bash
json-server --watch restaurant/data/panier.json --port 8888
nodemon restaurant/server/index.js
cd restaurant/client
npm run start
```
## Partie administrateur
1 - Création d'un virtual host dont le dossier racine (root) est "restaurant\"
2 - Importation de la base de données sous le nom de "restaurant" se trouvant dans le dossier "restaurant\data"
