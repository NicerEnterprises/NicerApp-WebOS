#!/bin/bash
NA_MAIN_HTDOCS_RELATIVE_PATH="/var/www/nicer.app-5.8.z"
NA_MAIN_SITE_FOLDER="nicer.app-5.8.0-alpha001c"
NA_MAIN_GROUP="www-data"
NA_MAIN_USER="reneav"

NA_MAIN_PERMISSIONS=660 # PHP needs this +x permission to load scripts!
NA_USERDATA_PERMISSIONS=660
NA_SHELLSCRIPTS_PERMISSIONS=700
NA_SITE_APPS=( restart_allApps.sh )
