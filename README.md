Pour faire fonctionner le tout : 

- Dans le dossier config créer un dossier JWT et y mettre les deux fichier private.pem et public.pem 
généré via openssl (Voir tuto du jwt sous symfony ici : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#prerequisites).
  
Ou les commandes  via openssl :

-  mkdir -p config/jwt 
- openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 
- openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
  
Configurer les paramètres du JWT de la base de donnée etc dans le .env.local ou .env 

Lancer :
symfony server:start 
  

