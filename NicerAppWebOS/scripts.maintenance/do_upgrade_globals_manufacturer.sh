#!/bin/bash
NA_MAIN_HTDOCS_RELATIVE_PATH="/var/www"
NA_MAIN_SITE_FOLDER="127.0.0.1"
NA_MAIN_GROUP="www-data"
NA_MAIN_USER="reneajmveerman"

NA_MAIN_PERMISSIONS=660 # PHP needs this +x permission to load scripts!
NA_USERDATA_PERMISSIONS=660
NA_SHELLSCRIPTS_PERMISSIONS=700
NA_SITE_APPS=( restart_allApps.sh )
