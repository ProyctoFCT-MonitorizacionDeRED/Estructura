#!/bin/bash

archivo_html="/var/www/html/htdocs/fct/html/temcomando.html"

sshpass -p "0Sistemas1" ssh administrador@${1} ${2} > resultado.txt

echo "<html>" >> ${archivo_html}
echo "<body>" >> ${archivo_html}
echo "<meta charset=\"utf-8\">" >> ${archivo_html}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/estilos.css\"/>" >> ${archivo_html}
echo "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">" >> ${archivo_html}
echo "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>" >> ${archivo_html}
echo "<link href=\"https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap\" rel=\"stylesheet\">" >> ${archivo_html}
echo "<div id=\"div0\">" >> ${archivo_html}
echo "<h1>RESULTADO COMANDO</h1>" >> ${archivo_html}
echo "<img src=\"./img/logo.png\" id=\"logo\"><br>" >> ${archivo_html}
echo "</div>" >> ${archivo_html}

for linea in `cat resultado.txt | tr -s " " "." `
do
	lineamod=`echo $linea | tr "." " "`
	echo "<p>"$lineamod"</p>" >> ${archivo_html}
done
echo "</body>" >> ${archivo_html}
echo "</html>" >> ${archivo_html}

cp -f ${archivo_html} /var/www/html/htdocs/fct/html/comando.html
chmod 777 /var/www/html/htdocs/fct/html/comando.html

rm -f ${archivo_html}
#rm -f /var/www/html/htdocs/fct/resultado.txt
