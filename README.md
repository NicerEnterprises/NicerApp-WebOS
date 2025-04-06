# NicerApp WebOS
this is a revolutionary and constantly evolving, well-maintained repository of HTML, CSS, JS and PHP code with which you can build websites that use a tiled image, photo or youtube video as site background for information and apps that are put over that background in a semi-transparent way.
It is suitable for beginner programmers who aren't even fluent in English or the programming languages used, because it is mostly functions-based code with a slight overlap into object oriented programming.
Installation scripts are being worked on in this latest version (5.y.z)

# Installation - overview
Nicerapp servers can be run on windows, linux and macOS systems, possibly even on smartphones,
and all it requires is a webserver that can serve up PHP scripts,
and the **couchdb database server[0]** which works with **JSON data**.

# Installation on Windows(tm)

On Windows(tm)(r), the https://wampserver.com/en WAMP stack (windows, apache, mysql, php) is well-suited,

and it can also be done on **linux systems[3]** from the **terminal** OS-level app, as such :

# Installation on Ubuntu or Kubuntu

(1) edit .../NicerAppWebOS/scripts.maintenance/do_upgrade_globals_manufacturer.sh, change settings where necessary.
NA_MAIN_USER is the Operating System main user that you want the webserver files to be registred under.

(2) on the commandline, do :
> sudo su -
>
> apt update
>
> apt upgrade
>
> apt install apache2 nginx php8 curl git unzip zip
>
> cd /var/www
>
> mkdir MYDOMAIN.TLD
>
> git clone https://github.com/NicerEnterprises/NicerApp-WebOS MYDOMAIN.TLD
>
> mkdir MYDOMAIN.TLD/downloads
>
> curl -LO https://nicer.app/downloads/3rd-party.zip MYDOMAIN.TLD/downloads
>
> unzip MYDOMAIN.TLD/downloads/3rd-party.zip MYDOMAIN.TLD/NicerAppWebOS
>
> mv -r MYDOMAIN.TLD/NicerAppWebOS/var/www/nicer.app/NicerAppWebOS MYDOMAIN.TLD/NicerAppWebOS
>
> rm -rf MYDOMAIN.TLD/NicerAppWebOS/var
>
> ... = /var/www/MYDOMAIN.TLD
> 
> cd .../NicerAppWebOS/scripts.maintenance/
>
> chmod u+x setPermissions.sh
>
> ./setPermissions.sh
>
> cd .../NicerAppWebOS/scripts.install/
>
> chmod u+x *.sh
>
> ./install-NicerAppWebOS.OS.(K)ubuntu-22.04LTS.sh
>
> OR
>
> ./install-NicerAppWebOS.OS.(K)ubuntu-20.04LTS.sh

# temporary flaws aptitude installation step :
missing when comparing 22.04 LTS to 20.04 LTS : php7.4-mbstring python-chardet libnode64 nodejs-legacy

# three.js (for 3D apps)

> cd .../NicerAppWebOS/3rd-party/3D
>
> mkdir libs
>
> cd libs
>
> git clone https://github.com/mrdoob/three.js/

# Installation - database
However, it can be augmented with a **SQL server** like mysql or postgresql[1] **which puts data in tables, rows and columns**.

[0] see https://docs.couchdb.org/en/stable/install/index.html
and for Kubuntu 22.04, you can install it on the commandline via
````
    dpkg -i .../NicerAppWebOS/scripts.install/couchdb_3.2.2-2_jammy_amd64.deb
````

[1] see https://adodb.org

The default database for nicerapp is couchdb. I find it more flexible and a lot easier to use than SQL data.

The couchdb server software and it's instructions can be found on https://couchdb.apache.org

Regardless of what mix-up of database servers that you use for your site, 
one guiding principle of developing web-apps with nicerapp is that we shield our database servers from the outside world as much as possible.

This means all requests for data by the browsers go via the **browser's jQuery.com** (.../NicerAppWebOS/3rd-party/jQuery) **AJAX** (asynchronous javascript and XML) code **to PHP scripts** that are all specific to the requested functionality, **and from there to the actual database server** and back to PHP and finally to the **browser**, which in non-debug mode **gets back only FAILED or SUCCESS (or the requested data)**.
All error handling, database sanitation, and cleanliness code is in the PHP scripts and the PHP libraries[2] used to access the database.

[2] 
couchdb : https://github.com/NicerAppWebOS/sag

please note : to update the cookie timeout length for couchdb to 1 week (measured in seconds), you have to enter the following command on the linux commandline :
>  curl http://admin:validpass@192.168.178.xyz:5984/_node/_local/_config/couch_httpd_auth/timeout -X PUT -d '"604800"'
curl http://admin:xcsd708KLJAPWUINZNASP0124kz8zlk3wjkajJKO2309z5230a9JAhziIALQAOu21uo124p14005253@192.168.178.xyz:5984/_node/_local/_config/couch_httpd_auth/timeout -X PUT -d '"604800"'


SQL : https://adodb.org


# Adding background image files
The backgrounds are stored under 
.../NicerAppWebOS/siteMedia/backgrounds/,

These backgrounds can be downloaded from Google Drive after installation,
via the URL https://tinyurl.com/NicerAppWebOS-bgs-favs-3

# serving the site from an encrypted setup using HTTPS:// (SSL)
	
> sudo apt install nginx letsencrypt certbot
	
https://nginx.com is a gateway server, which you can put in front of your webserver software and database servers.
We need it to serve database connections over SSL connections, and to be able to serve multiple domain names (nicer.app, zoned.at, said.by, etc) from just one outgoing aka public IP address.

Next : put the following code snippet as a template in **/etc/nginx/sites-available/DOMAIN_TLD-default-ssl.conf**
After that : 
> sudo ln -s /etc/nginx/sites-available/na-default-ssl.conf /etc/nginx/sites-enabled/DOMAIN_TLD-default-ssl.conf
	
````
#
# Note: This file must be loaded before other virtual host config files.
# NOTE: This file configures 2 web servers, running on the same LAN, maybe even the same PC, as this nginx installation. (https://nicer.app, and https://said.by)
#
# HTTPS
server {
  listen 45000 ssl http2;
  listen [::]:45000 ssl http2;

  server_name DOMAIN_TLD;
  # DOMAIN_TLD can be nicer.app, said.by or myShop.com for instance
  # you'd then have to foward your external IP address to your LAN card's IP address in the web administration interface of
  # your internet modem. you can find out your LAN card's IP addresses (which have to be in the 192.168.178.[0-255] range
  # i think) with the linux 'ifconfig' commandline command.

  root /var/www/DOMAIN_TLD;
  # actually : root /var/www/nicer.app or /var/www/mysite.com, of course.
    
  ssl_certificate /etc/letsencrypt/live/DOMAIN_TLD/fullchain.pem;
  ssl_certificate_key /etc/letsencrypt/live/DOMAIN_TLD/privkey.pem;

  ssl_session_cache shared:SSL:10m;
  ssl_session_timeout 10m;
  ssl_protocols TLSv1.2 TLSv1.1 TLSv1;
  ssl_ciphers 'kEECDH+ECDSA+AES128 kEECDH+ECDSA+AES256 kEECDH+AES128 kEECDH+AES256 kEDH+AES128 kEDH+AES256 DES-CBC3-SHA +SHA !aNULL !eNULL !LOW !kECDH !DSS !MD5 !RC4 !EXP !PSK !SRP !CAMELLIA !SEED';
  ssl_prefer_server_ciphers on;
  ssl_dhparam /etc/nginx/dhparam.pem;

  add_header 'Access-Control-Allow-Origin' 'https://fiddle.jshell.net' always;
  add_header 'Access-Control-Allow-Credentials' 'true' always;
  add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS' always;
  add_header 'Access-Control-Allow-Headers' 'Accept,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Requested-With' always;
  # required to be able to read Authorization header in frontend
  #add_header 'Access-Control-Expose-Headers' 'Authorization' always;

  location / {
    # forward traffic to your server's LAN (Local Area Network) IP Address, apache2 at port 45000:
    proxy_pass https://192.168.178.21:45000/;
	
    proxy_redirect off;
    proxy_buffering off;
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Ssl on;

    proxy_connect_timeout 159s;
    proxy_send_timeout   60;
    proxy_read_timeout   60;
    send_timeout 60;
    resolver_timeout 60;
  }
}
server {
  listen 45001 ssl http2;
  listen [::]:45001 ssl http2;

  server_name DOMAIN2_TLD;
  root /var/www/DOMAIN2_TLD;
  # actually : root /var/www/nicer.app or /var/www/mysite.com, of course.

  ssl_certificate /etc/letsencrypt/live/DOMAIN2_TLD/fullchain.pem;
  ssl_certificate_key /etc/letsencrypt/live/DOMAIN2_TLD/privkey.pem;

  ssl_session_cache shared:SSL:10m;
  ssl_session_timeout 10m;
  ssl_protocols TLSv1.2 TLSv1.1 TLSv1;
  ssl_ciphers 'kEECDH+ECDSA+AES128 kEECDH+ECDSA+AES256 kEECDH+AES128 kEECDH+AES256 kEDH+AES128 kEDH+AES256 DES-CBC3-SHA +SHA !aNULL !eNULL !LOW !kECDH !DSS !MD5 !RC4 !EXP !PSK !SRP !CAMELLIA !SEED';
  ssl_prefer_server_ciphers on;
  ssl_dhparam /etc/nginx/dhparam.pem;

  add_header 'Access-Control-Allow-Origin' 'https://fiddle.jshell.net' always;
  add_header 'Access-Control-Allow-Credentials' 'true' always;
  add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS' always;
  add_header 'Access-Control-Allow-Headers' 'Accept,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Requested-With' always;
  # required to be able to read Authorization header in frontend
  #add_header 'Access-Control-Expose-Headers' 'Authorization' always;

  location / {
    # forward traffic to your server's LAN (Local Area Network) IP Address, apache2 at port 45001:
    proxy_pass https://192.168.178.21:45001/;

    proxy_redirect off;
    proxy_buffering off;
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Ssl on;

    proxy_connect_timeout 159s;
    proxy_send_timeout   60;
    proxy_read_timeout   60;
    send_timeout 60;
    resolver_timeout 60;
  }
}
````


**don't forget : you need to tell apache to run on the right ports, 
which are 444 and 447 in this example case, 
and those ports should NOT be forwarded from your modem / ADSL router / fiber internet connection device to your LAN. 
port 80 should be disabled in all files in /etc/apache2/sites-available/, by modifying the line(s) containing 'VirtualHost'**

**edit /etc/apache2/ports.conf** to become the following, but **be sure to change 192.168.178.77 your server's LAN IP address**, which can be found with the 'ifconfig' terminal app :
````
Listen 80

<IfModule ssl_module>
        Listen 192.168.178.77:45000
        Listen 192.168.178.77:45001
</IfModule>

<IfModule mod_gnutls.c>
        Listen 192.168.178.77:45000
        Listen 192.168.178.77:45001
</IfModule>
````

	
i'll provide an example apache2 config file for https://DOMAIN_TLD
the following is in /etc/apache2/sites-available/001-DOMAIN_TLD.conf
````
<VirtualHost *:45000>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #  ServerName www.example.com
        ServerName DOMAIN_TLD

        ServerAdmin YOUR_EMAIL@SOME_EMAIL_PROVIDER.COM
        DocumentRoot /var/www/DOMAIN_TLD

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn
        #LogLevel info ssl:warn
        LogLevel info ssl:warn

        #ErrorLog ${APACHE_LOG_DIR}/error.45000.log
        #CustomLog ${APACHE_LOG_DIR}/access.45000.log combined
        SetEnvIf X-Forwarded-For "^.*\..*\..*\..*" forwarded
        LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
        LogFormat "%{X-Forwarded-For}i %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" forwarded
        ErrorLog ${APACHE_LOG_DIR}/error.447.log
        CustomLog ${APACHE_LOG_DIR}/access.447.log combined env=!forwarded
        CustomLog ${APACHE_LOG_DIR}/access.447.log forwarded env=forwarded



        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".

        <Directory /var/www/DOMAIN_TLD>
                Options -Indexes +FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on
        SSLProtocol all -SSLv2 -SSLv3
        SSLHonorCipherOrder on
        SSLCipherSuite "EECDH+ECDSA+AESGCM EECDH+aRSA+AESGCM EECDH+ECDSA+SHA384 EECDH+ECDSA+SHA256 EECDH+aRSA+SHA384 EECDH+aRSA+SHA256 EECDH+aRSA+RC4 EECDH EDH+aRSA RC4 !aNULL !eNULL !LOW !3DES !MD5 !EXP !PSK !SRP !DSS +RC4 RC4"

        SSLCertificateFile /etc/letsencrypt/live/DOMAIN_TLD/cert.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/DOMAIN_TLD/privkey.pem
        SSLCertificateChainFile /etc/letsencrypt/live/DOMAIN_TLD/fullchain.pem
</VirtualHost>
````

**Finally**, you need to create the actual encryption keys for apache2.
This is free and fairly simple.
You can choose between **certbot** or **letsencrypt**.
You can find tutorials on how to use them via google searches for either 'certbot example' or 'letsencrypt example'.

After that, the only remaining step is to restart all the server software :
> sudo service couchdb restart
> 
> sudo service apache2 restart
> 
> sudo service nginx restart

# Initializing a couchdb database

You'll have to use the commandline OS app to start
````
  php .../NicerAppWebOS/scripts.maintenance/htaccess.build.php
````

You'll have to edit .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/naLAN.json
to enter your local area network's outside-world IP address.

After this, you'll have to browse once to https://YOURDOMAIN.TLD/NicerAppWebOS/db_init.php
and after that to https://YOURDOMAIN.TLD
	
# Modifying the HTML for a nicerapp site
This is done by modifying .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/index.template.php
and possibly .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/desktop.source.js as well.

# Adding new URLs and apps into a nicerapp site
All apps and pages on a nicerapp site are loaded through a URL that looks somewhat like this :
http://localhost/view/eyJtdXNpYyI6eyJzZXQiOiJpbmRleCJ9fQ

You will notice the "strange" sequence after /view/ in that URL.
It's strange because it's base64-encoded JSON, allowing for multiple settings to be passed into the nicerapp PHP code, while avoiding the "old" practice of using http://localhost/apps/someApp.php?setting1=x&setting2=y (which forces non-ASCII characters to be 'urlEncoded' which makes for really difficult reading).

If you want to simplify things for use in Search Engine Optimization (SEO), you can have http://localhost/abc automatically translated into http://localhost/apps/eyJtdXNpYyI6eyJzZXQiOiJpbmRleCJ9fQ in **.../.htaccess** - there are already some examples supplied.

The creation of new NicerApp URL entries for use in PHP, HTML, and .htaccess is done by .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/mainmenu.items.php and
> php /var/www/YOURDOMAIN.TLD/NicerAppWebOS/scripts.maintenance/htaccess.build.php

You would store any new apps that you might create under .../NicerAppWebOS/apps/YOURNAME/PATH/TO/YOUR_APPNAME/app.dialog.siteContent.php or .../NicerAppWebOS/apps/YOURNAME/PATH/TO/YOUR_APPNAME/app.dialog.siteToolbarLeft.php or any other main DIV name with class="vividDialog" as found in .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/index.template.php

And .../NicerAppWebOS/logic.AJAX/ajax_get_content.php is responsible for AJAX mapping your http://localhost/apps/eyJtdXNpYyI6eyJzZXQiOiJpbmRleCJ9fQ to the right code.

One would ask, rightfully so, how to create these /apps/* URLs on the fly in PHP.
Well, that's done with the always available .../NicerAppWebOS/functions.php::**base64_encode_url()** and .../NicerAppWebOS/functions.php::**base64_decode_url()**
in JavaScript, it's done with the always available **na.m.base64_encode_url()** and **na.m.base64_decode_url()**

# Questions, bug-reports, feature-requests?
you can post these to rene.veerman.netherlands@gmail.com, and i will try to respond within 72 hours, even on weekends.

