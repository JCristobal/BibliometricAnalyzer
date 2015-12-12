# BibliometricAnalyzer ![logo](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/BibliometricAnalyzer_icon.png)
Herramienta web para el análisis bibliométrico de temas o autores extraídos automáticamente de las bases de datos de Scopus y Google Académico

***

Puedes consultar [BibliometricAnalyzer en OpenShift](http://bibliometricanalyzer-jcristobal.rhcloud.com/), con el análisis por temas completo y con la funcionalidad de análisis de autores reducida (sin desambiguación ni información personal de éstos). 


***

A continuación puedes ver varias capturas de pantalla mostrando algunos resultados:

En el análisis de un autor su "arbol de relaciones con autores" y los temas que trata a lo largo de los años:

![](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/arbol%20en%20analisis%20autor.png)

![](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/varios%20temas%20en%20analisis%20autor.png)


Y en el análisis de un tema su distribución por paises y éstos localizados geográficamente. También se puede ver los autores más citados y las citas que tienen:

![](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/donut%20en%20analisis%20tema.png)

![](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/mapa%20en%20analisis%20tema.png)

![](https://raw.githubusercontent.com/JCristobal/BibliometricAnalyzer/gh-pages/images/citas%20en%20analisis%20tema.png)



***

Para desplegar las funcionalidades debes: 

>
>0 - Instalar un [servidor web](https://www.apachefriends.org/download.html). 
>
>1 - Sustituir en contenido de la carpeta /opt/lampp/htdocs por la del repositorio
>
>2 - Importar la tabla de "publicaciones" (en "BD") al gestor de bases de datos (MySQL) del servidor.
>
>3 - Editar el archivo 'conexion.php' para conectarse a ella.
>
>4 - Desplegar la web en el servidor: `sudo /opt/lampp/lampp start`
>

o desplegar la aplicación automáticamente con mediante el script *despliegue.sh*:

Descarárgate la aplicación con `git clone https://github.com/JCristobal/BibliometricAnalyzer.git`

Sitúate dentro `cd BibliometricAnalyze`

Y despliega con `sudo sh despliegue.sh` 

