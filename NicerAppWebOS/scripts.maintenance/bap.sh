# bap.sh = backup and publish.sh
#!/bin/bash
DATE=$(date +'%Y-%m-%d %H:%M:%S')
set -x # echo on
source ./do_upgrade_globals_manufacturer.sh

sourceDomain=127.0.0.1
declare -a targetDomains=("nicer.app" "said.by")

for TD in "${targetDomains[@]}"; do
	echo "--- NOW WORKING ON SITE $TD"
	mv /var/www/$TD "/var/www/$DATE $TD"
	cp -rv /var/www/$sourceDomain /var/www/$TD
	cp "/var/www/$DATE $TD/NicerAppWebOS/scripts.maintenance/setPermissions.sh" /var/www/$TD/NicerAppWebOS/scripts.maintenance
	mv /var/www/$TD/NicerAppWebOS/domainConfigs/$sourceDomain /var/www/$TD/NicerAppWebOS/domainConfigs/$TD
	cp "/var/www/$DATE $TD/NicerAppWebOS/domainConfigs/$TD/index.javascripts.json" /var/www/$TD/NicerAppWebOS/domainConfigs/$TD
	cp "/var/www/$DATE $TD/NicerAppWebOS/domainConfigs/$TD/frontpage.siteContent.php" /var/www/$TD/NicerAppWebOS/domainConfigs/$TD
	cp "/var/www/$DATE $TD/NicerAppWebOS/domainConfigs/$TD/index.title.php" /var/www/$TD/NicerAppWebOS/domainConfigs/$TD
	chown -R gavan:www-data /var/www/$TD
	chmod -R 770 /var/www/$TD
done

~/setPermissions_onAllSites.sh
