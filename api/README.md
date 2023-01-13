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

## .env

Then, add your passphrase in the .env file :

```
JWT_PASSPHRASE=<YOUR-PASSPHRASE>
```

That's it ! You're ready to generate the token.
