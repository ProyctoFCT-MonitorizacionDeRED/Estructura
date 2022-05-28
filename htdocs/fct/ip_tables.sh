#!/bin/bash

echo -e "0Sistemas1" | sudo -S rm -f /var/www/html/htdocs/fct/maxfecha.txt &>/dev/null
echo -e "0Sistemas1" | sudo -S sed -i '43,$d' /var/www/html/htdocs/fct/ip_tables.sh
for linea in `echo -e "0Sistemas1" | sudo -S cat /var/www/html/htdocs/fct/iptablestemp.txt`
do
	fecha=`echo "$linea" | awk -F "#" '{print $1}'`
	iptable=`echo "$linea" | awk -F "#" '{print $2}'`
	mayor=$fecha
	for linea2 in ` echo -e "0Sistemas1" | sudo -S cat /var/www/html/htdocs/fct/iptablestemp.txt`
	do
		fecha2=`echo "$linea2" | awk -F "#" '{print $1}'`
	        iptable2=`echo "$linea2" | awk -F "#" '{print $2}'`

		if [ $iptable = $iptable2 ]
		then
			 if [ $fecha2 -gt $mayor ]
		         then
	               	 	mayor=${fecha2}
			 fi
		fi
	done
echo -e "0Sistemas1" | sudo -S touch /var/www/html/htdocs/fct/maxfecha.txt
echo -e "0Sistemas1" | sudo -S chmod 777 /var/www/html/htdocs/fct/maxfecha.txt
echo $mayor"#"${iptable} >> /var/www/html/htdocs/fct/maxfecha.txt
done
#######################

for filtrado in `echo -e "0Sistemas1" | sudo -S cat /var/www/html/htdocs/fct/maxfecha.txt |  tr "@" " " | sort -k5n,5 -k1nr,1 | uniq | tr " " "@"`
do
        fila=`echo "$filtrado" | awk -F "#" '{print $2}'`
	echo -e "0Sistemas1" | sudo -S echo $fila | tr "@" " ">> /var/www/html/htdocs/fct/ip_tables.sh
done


###### POLITICAS POR DEFECTO #####
iptables -P INPUT ACCEPT
iptables -P OUTPUT ACCEPT
iptables -P FORWARD ACCEPT
##### BORRADO DE FLUSH ACLs #####
iptables -F
##### SCRIPTS DE IPTABLES ####
iptables -A FORWARD -s 192.168.1.4 -i ens33 -p tcp  --dport https -j ACCEPT 
iptables -A INPUT -s 192.168.1.4 -i ens33 -p tcp  --dport https -j ACCEPT 
iptables -A FORWARD -s 192.168.1.4 -i ens33 -p tcp  --dport https -j DROP 
iptables -A INPUT -s 192.168.1.4 -i ens33 -p tcp  --dport https -j DROP 
iptables -A INPUT -s 192.168.1.3 -i ens33 -d 192.168.1.1 -p icmp -j ACCEPT 
iptables -A INPUT -s 192.168.1.3 -i ens33 -d 192.168.1.1 -p icmp -j DROP
