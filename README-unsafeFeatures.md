# To put an SSL encryption layer on the couchdb database server, do this :

(this technique is considered HIGHLY UNSAFE FOR ALL USE PURPOSES,
because any user-interface code stack is much better off with
'business logic code'[1] that checks variables for sanity and
user permissions validity and which outputs JSON or an error
message)

[1] seperated into folders, code object files, function library files
and short AJAX-call scripts.

if you still want to do this, to address the database through
the pouchdb javascript library for instance, then :

put the following in **/etc/nginx/sites-available/couchdb.conf**

````
server {
  listen 7205;
  server_name MYDOMAIN.TLD;
    ssl_certificate /etc/letsencrypt/live/MYDOMAIN.TLD/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/MYDOMAIN.TLD/privkey.pem; # managed by Certbot

  ssl on;
  ssl_session_cache shared:SSL:10m;
  ssl_session_timeout 10m;
  ssl_protocols TLSv1.2 TLSv1.1 TLSv1;
  ssl_ciphers 'kEECDH+ECDSA+AES128 kEECDH+ECDSA+AES256 kEECDH+AES128 kEECDH+AES256 kEDH+AES128 kEDH+AES256 DES-CBC3-SHA +SHA !aNULL !eNULL !LOW !kECDH !DSS !MD5 !RC4 !EXP !PSK !SRP !CAMELLIA !SEED';
  ssl_prefer_server_ciphers on;
  ssl_dhparam /etc/nginx/dhparam.pem;

  location / {
    # forward traffic to your server's LAN (Local Area Network) couchdb port 5984 (the default, unencrypted port) :
    proxy_pass http://localhost:5984;
    proxy_redirect off;
    proxy_buffering off;
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Ssl on;
  }
}
````

after that do this :
> sudo apt install certbot
>
> certbot -d MYDOMAIN.TLD --nginx
>
> sudo ln -s /etc/nginx/sites-available/couchdb.conf /etc/nginx/sites-enabled/couchdb.conf
>
> sudo service nginx restart
