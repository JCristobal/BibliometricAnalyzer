# BibliometricAnalyzer ![logo](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/BibliometricAnalyzer_icon.png?raw=true)
Herramienta web para el análisis bibliométrico de temas o autores extraídos automáticamente de las bases de datos de Scopus y Google Académico

***

Puedes consultar [BibliometricAnalyzer en OpenShift](http://bibliometricanalyzer-jcristobal.rhcloud.com/), con el análisis por temas completo y con la funcionalidad de análisis de autores reducida (sin desambiguación ni información personal de éstos). 




A continuación puedes ver varias capturas de pantalla mostrando algunos resultados:

En el análisis de un autor su "arbol de relaciones con autores" y los temas que trata a lo largo de los años:

![](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/screenshots/arbol%20en%20analisis%20autor.png?raw=true)

![](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/screenshots/varios%20temas%20en%20analisis%20autor.png?raw=true)


Y en el análisis de un tema su distribución por paises y éstos localizados geográficamente. También se puede ver los autores más citados y las citas que tienen:

![](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/screenshots/donut%20en%20analisis%20tema.png?raw=true)

![](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/screenshots/mapa%20en%20analisis%20tema.png?raw=true)

![](https://github.com/JCristobal/BibliometricAnalyzer/blob/gh-pages/screenshots/citas%20en%20analisis%20tema.png?raw=true)



***

Puedes acceder a la portada:
http://jcristobal.github.io/BibliometricAnalyzer/
pero para desplegar las funcionalidades debes: 

>
>0 - Instalar un [servidor web](https://www.apachefriends.org/download.html). 
>
>1 - Sustituir en contenido de la carpeta htdocs por la del repositorio
>
>2 - Importar la tabla de "publicaciones" (en "BD") al gestor de bases de datos (MySQL) del servidor.
>
>3 - Editar el archivo 'conexion.php' para conectarse a ella.
>
>4 - Desplegar la web en el servidor. 
>

