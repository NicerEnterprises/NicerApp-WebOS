#!/bin/bash
cd /var/www

echo "Your website will be installed under /var/www"
echo "Q1/3 : What is the name of your website (your MYDOMAIN.COM / MYDOMAIN.TLD)?"
read DOMAIN_TLD

read "Q2/3 : Under what domain name (localhost / MYDOMAIN.COM) or IP address do you want to publish your website?"
read SERVER_NAME

echo "Q3/3 : What email address do you wish to use for webserver level errors and notifications?"
read APACHE_EMAIL

set -o xtrace

apt update

apt upgrade

apt dist-upgrade

apt install aptitude

aptitude install composer apache2 php php8.1-gd php-dev libapache2-mod-php php-imap curl php-curl php-mailparse curl git imagemagick npm net-tools apt-transport-https gnupg wordnet libauthen-ntlm-perl libclass-load-perl libcrypt-ssleay-perl libdata-uniqid-perl libdigest-hmac-perl libdist-checkconflicts-perl libencode-imaputf7-perl libfile-copy-recursive-perl libfile-tail-perl libio-compress-perl libio-socket-inet6-perl libio-socket-ssl-perl libio-tee-perl libmail-imapclient-perl libmodule-scandeps-perl libnet-dbus-perl libnet-ssleay-perl libpar-packer-perl libreadonly-perl libregexp-common-perl libsys-meminfo-perl libterm-readkey-perl libtest-fatal-perl libtest-mock-guard-perl libtest-mockobject-perl libtest-pod-perl libtest-requires-perl libtest-simple-perl libunicode-string-perl liburi-perl libtest-nowarnings-perl libtest-deep-perl libtest-warn-perl make cpanminus nodejs node-gyp libnode-dev npm dovecot-imapd pass gh

cpanm Mail::IMAPClient

cpanm JSON::WebToken

a2enmod headers rewrite
service apache2 restart

# installing the NicerAppWebOS source files
cd /var/www
git clone https://github.com/NicerEnterprises/NicerApp-WebOS $DOMAIN_TLD

cd $DOMAIN_TLD/NicerAppWebOS/install.scripts
php apache2.virtualHost.php $SERVER_NAME $APACHE_EMAIL $DOMAIN_TLD

cd /var/www/$DOMAIN_TLD/NicerAppWebOS/3rd-party

git clone https://github.com/thephpleague/oauth2-client

git clone https://github.com/NicerAppWebOS/sag

git clone https://github.com/zingchart/zingtouch

cd /var/www/$DOMAIN_TLD/NicerAppWebOS/3rd-party/3D
if [ -d libs ]
    mkdir libs
fi
cd libs
git clone https://github.com/mrdoob/three.js three.js

cd /var/www/$DOMAIN_TLD/NicerAppWebOS/3rd-party/jQuery

git clone https://github.com/seballot/spectrum

cd /var/www/$DOMAIN_TLD/NicerAppWebOS/3rd-party/vendor

composer require adodb/adodb-php ^5.22

composer require defuse/php-encryption

composer require league/oauth2-facebook

composer require league/oauth2-google

composer require league/oauth2-instagram

composer require league/oauth2-linkedin

# couchdb
apt install libmozjs-78-0
dpkg -i /var/www/$DOMAIN_TLD/NicerAppWebOS/install.scripts/couchdb_3.2.2-2_jammy_amd64.deb

# mysql
apt install mysql

# postgresql
apt install postgresql

mv /var/www/$DOMAIN_TLD/NicerAppWebOS/apps/manufacturerNameForDomainName_127.0.0.1_val.txt /var/www/$DOMAIN_TLD/NicerAppWebOS/apps/manufacturerNameForDomainName_$DOMAIN_TLD\_val.txt

chmod a+x /var/www/$DOMAIN_TLD/NicerAppWebOS/maintenance.scripts/setPermissions.sh

/var/www/$DOMAIN_TLD/NicerAppWebOS/maintenance.scripts/setPermissions.sh


