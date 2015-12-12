
echo "Despliega dentro de la carpeta de BibliometricAnalyzer"


#Instalamos XAMPP 
add-apt-repository ppa:upubuntu-com/xampp
apt-get update && apt-get install xampp
#Lo arrancamos 
/opt/lampp/lampp start



#Copiamos la aplicación dentro de "htdocs" del servidor
cp -r  * /opt/lampp/htdocs


#Importamos "publicaciones"
cd BD
echo '\nIntroduce la contraseña de mysql'
#mysql CREATE DATABASE `bibliometricanalyzer`; 
#mysql USE `bibliometricanalyzer`;
mysql -u root -p  < publicaciones.sql
	

echo '\nAccede a la aplicación desde http://localhost/index.html \n'

#firefox http://localhost/index.html
#google-chrome http://localhost/index.html



