#!/usr/bin/env bash

cd $(dirname $0)

echo "Putting apache configs in place..."
cp site-config /etc/apache2/sites-available/LEDscape
ln -s /etc/apache2/sites-available/LEDscape /etc/apache2/sites-enabled/

echo "Generating identity file..."
mac=`ifconfig | awk '/eth0/{print $5}'`
color=`ifconfig | awk -F: '/eth0/{printf $5 $6 $7}' | sed 's/ //g'`
cat << EOF > server-root/identity.json
{
    "mac": "$mac",
    "color": "$color"
}
EOF

echo "Setting up server root..."
cp -r server-root /var/www/LEDscape
chown www-data /var/www/LEDscape/config.json

echo "Modifying sudoers..."
sh modify-sudoers.sh

echo "Installing php..."
apt-get install libapache2-mod-php5

echo "Restarting Apache..."
/etc/init.d/apache2 restart

