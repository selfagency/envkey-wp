**An unofficial package for using EnvKey with WordPress**

*This is a work in progress and not presently intended for use in production environments.*

[EnvKey](https://envkey.com) is "a password manager for API keys, credentials, and config."

1.  Install [envkey-fetch](https://github.com/envkey/envkey-fetch) on your web server.
2.  Drop a `.env` file in your site's root path with your environment's `ENVKEY=key` and `chmod 440 .env`.
3.  Edit the `settings.php` file to configure your settings.
