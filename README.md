Pour que ça marche 

Dans le .env.local que vous devez créer

DATABASE_URL="mysql://root:@127.0.0.1:3306/webforcegame?serverVersion=5.7"

Faire ça pour récuperer la db à chaque pull

php bin/console d:s:u -f