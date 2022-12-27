# setting up the OS functionality for the webmail features

add the following line in /etc/apache2/mods-enabled/php7.4.load :
> LoadModule php7_module /var/www/YOURDOMAIN.TLD/NicerAppWebOS/3rd-party/mailparse-3.1.3/modules/mailparse.so

edit /etc/dovecot/dovecot.conf, add / change the following line :
> protocols = imaps
>
> mail_location = maildir:~/Maildir
>
> log_path = /var/log/dovecot.log
>
> info_log_path = /var/log/dovecot-info.log
>
> auth_verbose = yes
>
> auth_mechanisms = sha256-crypt
>
> passdb {
>
>  driver = passwd-file
>
>  args = /etc/dovecot/passwd
>
> }
>
> userdb {
>
>  driver = static
>
>  args = uid=vmail gid=vmail home=/home/vmail/%u
>
> }


edit /etc/dovecot/conf.d/10-ssl.conf, change the following lines :
> ssl_cert = </etc/letsencrypt/live/YOURDOMAIN.TLD/fullchain.pem
>
> ssl_key = </etc/letsencrypt/live/YOURDOMAIN.TLD/privkey.pem
