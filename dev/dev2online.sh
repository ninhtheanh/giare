#!/bin/bash
rsync -vur /var/www/html/dealsoc.vn/source/ /var/www/html/dealsoc.vn/httpdocs/ --exclude="include/compiled/" --exclude="include/configure/" --exclude="static/team/" --exclude="dev/"
