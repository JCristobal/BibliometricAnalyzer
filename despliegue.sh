
if [[ $EUID -ne 0 ]]; then
	echo "Debes tener permisos de administrador para ejecutar el script"

else	

	# Instalamos git si fuese necesario
	if [[ $(dpkg-query -W -f='${Status}\n' git) != 'install ok installed' ]]; then
		echo 'Instalamos Git'
		apt-get install git-all
	fi

	# Clonamos el repositorio
	git clone https://github.com/JCristobal/BibliometricAnalyzer.git

	
	# Instalamos XAMPP
 	add-apt-repository ppa:upubuntu-com/xampp
	apt-get update && apt-get install xampp


	#Arrancamos XAMPP
	/opt/lampp/lampp start


	# Instalamos mysql si fuese necesario
	if [[ $(dpkg-query -W -f='${Status}\n' mysql) != 'install ok installed' ]]; then
		echo 'Instalamos mysql'
		apt-get install mysql-client-core-5.5
	fi

	#Importamos "publicaciones", introduce la contraseña de mysql cuando te lo pida
	cd ~/BibliometricAnalyzer/Aplicación/BD
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
