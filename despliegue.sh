
echo "Despliega dentro de la carpeta de BibliometricAnalyzer"

if [[ $EUID -ne 0 ]]; then
	echo "Debes tener permisos de administrador para ejecutar el script"

else	
	
	if [ -d /opt/lampp/lampp ]; then
		#Arrancamos XAMPP si ya lo tenemos
		/opt/lampp/lampp start
	else
		#Instalamos XAMPP si no lo tenemos
		add-apt-repository ppa:upubuntu-com/xampp
		apt-get update && apt-get install xampp
		#Lo arrancamos 
		/opt/lampp/lampp start
	fi




	#Copiamos la aplicación dentro de "htdocs" del servidor
	cd Aplicación
	cp -r  * /opt/lampp/htdocs

	# Instalamos mysql si fuese necesario
	if [[ $(dpkg-query -W -f='${Status}\n' mysql) != 'install ok installed' ]]; then
		echo 'Instalamos mysql'
		apt-get install mysql-client-core-5.5
	fi

	#Importamos "publicaciones", introduce la contraseña de mysql cuando te lo pida
	cd BD
	#mysql CREATE DATABASE `bibliometricanalyzer`; 
	#mysql USE `bibliometricanalyzer`;
	mysql -u root -p  < publicaciones.sql
	

	#Abrimos la aplicación en el navegador (firefox o chrome)
	if [[ $(dpkg-query -W -f='${Status}\n' firefox) == 'install ok installed' ]]; then
		firefox http://localhost/index.html
	else
		google-chrome http://localhost/index.html
	else
		echo 'Accedente a la aplicación desde http://localhost/index.html'
	fi



fi
