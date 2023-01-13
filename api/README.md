# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.

# JWT Token Authentication

Once you have started your docker environnement with `docker compose up -d`, you can generate the JWT token.

## Generate the certificates

First, you have to generate the private and public certificates in `api/config/jwt`:
```bash
$ docker compose exec php openssl genrsa -out config/jwt/private.pem -aes256 4096
$ docker compose exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

In case the above commands don't work:
```
docker-compose exec php sh -c '
    set -e
    apk add openssl
    php bin/console lexik:jwt:generate-keypair --overwrite
    setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
    setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
'
```

## .env

Then, add your passphrase in the .env file :

```
JWT_PASSPHRASE=<YOUR-PASSPHRASE>
```

That's it ! You're ready to generate the token.
