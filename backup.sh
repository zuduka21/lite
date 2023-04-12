#!/bin/bash
# Script will output dumps for all databases using seperate files
# Derived from this post: http://www.cyberciti.biz/faq/ubuntu-linux-mysql-nas-ftp-backup-script/

cd /home/www/

USER="www"
PASSWORD="1b5gRWiIeN2Xfe79"
HOST="localhost"
MYSQL="$(which mysql)"
MYSQLDUMP="$(which mysqldump)"
OUTPUT_DIR="/home/www/backup"

# Parse options
while getopts ":u:p:h:o:" opt; do
    case $opt in
        u)
            USER=$OPTARG
            ;;
        p)
            PASSWORD=$OPTARG
            ;;
        h)
            HOST=$OPTARG
            ;;
        o)
            OUTPUT_DIR=$OPTARG
            ;;
        \?)
            echo "Invalid option: -$OPTARG" >&2
            exit 1
            ;;
        :)
            echo "Option -$OPTARG requires an argument." >&2
            exit 1
            ;;
    esac
done

VALIDATION_ERROR=false

if [ -z "$USER" ]; then
    echo "User has not been specified" >&2
    VALIDATION_ERROR=true
fi

if [ -z "$PASSWORD" ]; then
    echo "Password has not been specified" >&2
    VALIDATION_ERROR=true
fi

if [ -z "$OUTPUT_DIR" ]; then
    echo "Output dir has not been specified" >&2
    VALIDATION_ERROR=true
fi

if $VALIDATION_ERROR ; then
    exit 1
fi

dd=`date +%u`

DBS="$($MYSQL -u $USER -h $HOST -p$PASSWORD -Bse 'show databases')"
for db in $DBS
do
    if [ $db != "information_schema" ]; then
  FILE=$OUTPUT_DIR/$db$dd.sql
        $MYSQLDUMP -u $USER -h $HOST -p$PASSWORD --skip-lock-tables $db > $FILE
    fi
done

# Delete all backups older than 7 days
find $OUTPUT_DIR -mtime +7 -exec rm -f {} \;

rsync -rvzt /home/www/ --exclude="logs/" --exclude="live/cache/" --exclude="cache/" --exclude=".ssh/" acc_90268@5.45.78.16:~/


