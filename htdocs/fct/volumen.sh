#!/bin/bash

archivo_html="/var/www/html/htdocs/fct/html/discos_temp.html"
archivo_por="/var/www/html/htdocs/fct/txt/porcentaje.txt"
cuenta_td=1
n_tablas=0
ini=1
fin=0
i=1
j=1

echo -e ${1} | sudo -S rm -f ${archivo_html} &> /dev/null
echo -e ${1} | sudo -S  rm -f ${archivo_por} &> /dev/null

for linea in `cat /var/www/html/htdocs/fct/log/resultado_ping.txt`
do
	resultado=`echo $linea | awk -F "#" '{print $2}'`
	ip=`echo $linea | awk -F "#" '{print $1}'`
	
	if [ $resultado = 'correcto' ]
	then

		if [ $ip != '192.168.1.1' ] && [ $ip != '192.168.1.2' ]
		then
			comando="df -h"
			sshpass -p ${1} ssh administrador@${ip} ${comando} > num_${ip}.txt
			
			cat num_${ip}.txt | grep "^/dev/sd*" | awk -F ' ' '{print $5}' | tr "%" " " > resumen_${ip}.txt
			suma=0
		        for numerito in `cat resumen_${ip}.txt`
		        do
		                let suma=${numerito}+${suma}
		        done
		        echo ${ip}"#"${suma} >> ${archivo_por}

#		    rm -f num_${ip}.txt
#                   rm -f resumen_${ip}.txt
		else
			touch ${archivo_por}
		fi
	fi

done

n_lineas=`wc ${archivo_por} | awk -F " " '{print $1}'`

let resto=${n_lineas}%10
if [ ${resto} -eq 0 ]
then
        let n_tablas=$n_lineas/10
else
        let n_tablas=($n_lineas/10)+1
fi

cuantos_tds=`wc ${archivo_por} | awk -F " " '{print $1}'`

#formado del HTML
        echo "<html>" >> ${archivo_html}
        echo "<head>" >> ${archivo_html}
        echo "<meta charset=\"utf-8\">" >> ${archivo_html}
      	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/estilos.css\"/>" >> ${archivo_html}
        echo "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">" >> ${archivo_html}
        echo "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>" >> ${archivo_html}
        echo "<link href=\"https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap\" rel=\"stylesheet\">" >> ${archivo_html}
		echo "<style>" >> ${archivo_html}
		
		echo "#tds{" >> ${archivo_html}
		echo "width: 200px;" >> ${archivo_html}
		echo "}" >> ${archivo_html}
		
		for linea in `cat ${archivo_por}`
		do
           suma=`echo ${linea} | awk -F "#" '{print $2}'`
           let barra=100-${suma}
				echo "#div${i}{" >> ${archivo_html}
				echo "border-radius: 5px;" >> ${archivo_html}
				echo "text-align: center;" >> ${archivo_html}
				echo "margin-right: ${barra}%;" >> ${archivo_html}
				echo "font-size: 10px;" >> ${archivo_html}
				
				if [ $suma -le 20 ]
				then
					echo "background-color:green" >> ${archivo_html}
				else
					if [ $suma  -gt 20 ] && [ $suma -le 70 ]
					then
						echo "background-color:orange" >> ${archivo_html}	
					else
						echo "background-color:red" >> ${archivo_html}					
					fi
				fi	
				echo "}" >> ${archivo_html}
				
				let i=${i}+1
		done	
				echo "</style>" >> ${archivo_html}
        		echo "</head>" >> ${archivo_html}
        		echo "<body>" >> ${archivo_html}
        		echo "<div id=\"div0\">" >> ${archivo_html}
			echo "<h1>ESPACIO USADO EN DISCO</h1>" >> ${archivo_html}
        		echo "<img src=\"./img/logo.png\" id=\"logo\"><br>" >> ${archivo_html}
        		echo "</div>" >> ${archivo_html}
		
        for ((k=0;k<$n_tablas;k++))
        do
                echo "<table border='1'>" >> ${archivo_html}
                echo "<tr>" >> ${archivo_html}
                echo "<td>IP-Activa</td>" >> ${archivo_html}
                echo "<td>Porcentaje</td>" >> ${archivo_html}
                echo "</tr>" >> ${archivo_html}
                echo "<tr>" >> ${archivo_html}
                let fin=$ini+9
                for linea in `echo -e ${1} | sudo -S  cat ${archivo_por} | awk -v ini=$ini -v fin=$fin 'NR==ini, NR==fin'`
                do
                        ip=`echo ${linea} | awk -F "#" '{print $1}'`
                        suma=`echo ${linea} | awk -F "#" '{print $2}'`
						echo "<td>${ip}</td>" >> ${archivo_html}
                        echo "<td id=\"tds\">" >> ${archivo_html}
			#############
						echo "<div id=\"div${j}\">${suma}</div>" >> ${archivo_html}						
			#############			
						echo "</td>" >> ${archivo_html}
                        echo "</tr>" >> ${archivo_html}
                        let j=${j}+1
                done
                echo "</table>" >> ${archivo_html}
                let ini=$ini+10
        done
        echo "</body>" >> ${archivo_html}
        echo "</html>" >> ${archivo_html}

echo -e ${1} | sudo -S cp -f /var/www/html/htdocs/fct/html/discos_temp.html /var/www/html/htdocs/fct/html/discos.html

