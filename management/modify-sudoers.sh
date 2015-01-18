#!/bin/bash
if [ -z "$1" ]; then

  # When you run the script, you will run this block since $1 is empty.

  echo "Starting up visudo with this script as first parameter"

  # We first set this script as the EDITOR and then starts visudo.
  # Visudo will now start and use THIS SCRIPT as its editor
  export EDITOR="`pwd`/$0" && sudo -E visudo
else

  # When visudo starts this script, it will provide the name of the sudoers 
  # file as the first parameter and $1 will be non-empty. Because of that, 
  # visudo will run this block.

  echo "Changing sudoers"

  # We change the sudoers file and then exit  
cat << EOF >> $1

#custom entries for LEDscape
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart ledscape.service
www-data ALL=(ALL) NOPASSWD: /bin/systemctl stop ledscape.service
www-data ALL=(ALL) NOPASSWD: /sbin/shutdown -r now
www-data ALL=(ALL) NOPASSWD: /bin/netstat
EOF

fi
