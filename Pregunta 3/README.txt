### PREGUNTA 3: Manejo de Ramas y Conflictos en Git

## Descripción
Este proyecto muestra cómo manejar ramas y resolver conflictos en Git utilizando un ejemplo de un CRUD en PHP.

## Pasos para Crear el Repositorio y Manejar Conflictos

### Crear un Repositorio en GitHub y Subir el Proyecto PHP del CRUD
1. Inicialización de un repositorio Git en la carpeta del proyecto:

   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin <URL_DEL_REPOSITORIO>
   git push -u origin main
Creacion de la rama fearure
   git checkout -b feature/add-validation
   git add .
   git commit -m "Added email validation in Employee model"
   git push origin feature/add-validation
   git checkout main
   git merge feature/add-validation


