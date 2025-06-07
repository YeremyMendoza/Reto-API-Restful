<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# 🧪 Reto API RESTful con Laravel 12

Este proyecto consiste en el desarrollo de una API RESTful utilizando **Laravel 12** para gestionar empleados dentro de una empresa.

## 🎯 Objetivos Planteados

Implementar un sistema backend con las siguientes funcionalidades:

- Autenticación de usuarios mediante **JWT**.
- Gestión de empleados: crear, editar, eliminar y listar empleados con filtros (nombre, departamento, estado, fecha de ingreso, etc.).
- Gestión de departamentos y asociación con empleados.
- **Opcional**: asignación de jefes por departamento (solo un jefe por departamento).
- **Opcional**: reporte jerárquico por departamento (estructura de supervisión).

## 🎯 Objetivos logrados

Implementar un sistema backend con las siguientes funcionalidades:

- ✅ Autenticación de usuarios mediante **JWT**.
- ✅ Gestión de empleados: crear, editar, eliminar y listar empleados con filtros (nombre, departamento, estado, fecha de ingreso, etc.).
- ✅ Gestión de departamentos y asociación con empleados.
- ✅ **Opcional**: asignación de jefes por departamento (solo un jefe por departamento).
- ✅ **Opcional**: reporte jerárquico por departamento (estructura de supervisión).

## ⚙️ Consideraciones técnicas

- Uso de migraciones, seeders y factories.
- Validaciones robustas y manejo adecuado de errores.
- Documentación API (opcional con Swagger).
- Pruebas automáticas integradas.
- **Bonus:** frontend adicional (opcional).

---

## 💻 Requisitos previos

- PHP 8.2+
- Composer
- Laravel 12
- Node.js y NPM (o Bun)
- MySQL / MariaDB / PostgreSQL / SQLite
- **XAMPP** (para entorno local con Apache y MySQL)

---

## 🚀 Instalación

```bash
# Clonar el repositorio
git clone https://github.com/YeremyMendoza/Reto-API-Restful.git

# Entrar al directorio del proyecto
cd Reto-API-Restful

# Instalar dependencias de PHP
composer install

# Crear archivo de entorno
copy .env.example .env   # En Windows con XAMPP

# Generar claves
php artisan key:generate
php artisan jwt:secret
```
## 🛠️ Configuración de base de datos
Edita el archivo .env con tus datos locales de XAMPP:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base
DB_USERNAME=root
DB_PASSWORD=  # en blanco por defecto en XAMPP
```
## 🧱 Migraciones y datos iniciales
```bash
# Crear las tablas
php artisan migrate

# (Opcional) Poblar la base de datos con datos de ejemplo
php artisan db:seed
```
# 🧪 Ejecutar pruebas
```bash
php artisan test
```
Deberias ver resultados como
```bash
 🟩 **PASS** Tests\Feature\AuthTest
  ✔️ Registro de nuevo usuario                                                       2.76s  
  ✔️ Inicio de sesión                                                                0.05s  
  ✔️ Cierre de sesión                                                                0.04s  

🟩 **PASS** Tests\Feature\DepartamentoTest
  ✔️ puede visualizar datos de todos los departamentos                               0.05s  
  ✔️ puede visualizar la jerarquia de todos los departamentos tipo arbol             0.08s  
  ✔️ puede visualizar la jerarquia de un departamento mostrando departamento, encar… 0.05s  
  ✔️ puede registrar un nuevo departamento                                           0.06s  
  ✔️ puede actualizar un departamento existente con datos correctos                  0.06s  
  ✔️ no puede actualizar un departamento no existente                                0.05s  
  ✔️ no puede eliminar un departamento no existente                                  0.04s  
  ✔️ puede eliminar un departamento existente                                        0.05s  

🟩 **PASS** Tests\Feature\EmpleadoTest
  ✔️ puede visualizar datos de todos los empleados                                   0.05s  
  ✔️ puede registrar un nuevo empleado con datos correctos                           0.05s  
  ✔️ puede actualizar un empleado existente con datos correctos                      0.06s  
  ✔️ no puede actualizar un empleado no existente                                    0.05s  
  ✔️ no puede eliminar un empleado no existente                                      0.04s  
  ✔️ puede eliminar un empleado existente                                            0.06s  

🟩 **PASS** Tests\Feature\ExampleTest
  ✔️ the application returns a successful response                                   0.08s  

  Tests:    19 passed (92 assertions)
  Duration: 4.03s
```
## 📬 Documentación API

Este proyecto incluye documentación completa de la API generada con Swagger (OpenAPI 3) mediante el paquete L5-Swagger.

```bash
php artisan l5-swagger:generate
```
Si quieres regenerar la documentación después de cambios en los controladores o rutas, usa el comando anterior.

🔍 Puedes acceder a la documentación interactiva localmente desde la ruta: localhost/api/documentation


## 📌 Notas
- Este proyecto no incluye frontend, pero puede consumirse desde Postman, Insomnia u otra herramienta API.
- Se recomienda utilizar HTTPS en producción.
- Si necesitas una versión Dockerizada.
## 🤝 Autor
Yeremy Mendoza
