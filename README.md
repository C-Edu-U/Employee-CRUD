
# 🧩 Sistema de Gestión de Empleados, Puestos y Usuarios

Este es un sistema web desarrollado en PHP con integración de base de datos MariaDB, enfocado en la gestión de personal. Permite registrar, editar, eliminar y visualizar empleados, puestos de trabajo y usuarios del sistema. Está diseñado con enfoque académico para prácticas de CRUD, validaciones, generación de reportes y mejora de interfaz de usuario.

---

## 🚀 Tecnologías utilizadas

- **PHP 8** con Apache
- **MariaDB 10.6** (con PhpMyAdmin)
- **Bootstrap 5.3**
- **JavaScript + jQuery**
- **DataTables v2.2.2** (para tablas interactivas)
- **SweetAlert2** (para alertas modernas)
- **Dompdf** (para generar PDF de cartas de recomendación)
- **Docker Compose** (para montar los servicios en contenedores)

---

## 🗂️ Estructura del proyecto

```
/html
  ├── index.php                  # Página de inicio (landing)
  ├── /secciones
  │     ├── empleados/           # CRUD de empleados
  │     ├── puestos/             # CRUD de puestos
  │     └── usuarios/            # CRUD de usuarios
  ├── /templates
  │     ├── header.php           # Encabezado común con menú y Bootstrap
  │     └── footer.php           # Scripts comunes (DataTables, SweetAlert)
  ├── /uploads                   # Carpeta para fotos y CVs
  └── db.php                    # Conexión a la base de datos
```

---

## ⚙️ Instalación y configuración

1. Clona este repositorio:

   ```bash
   git clone https://github.com/tu-usuario/nombre-del-repo.git
   ```

2. Inicia los servicios con Docker:

   ```bash
   docker-compose up -d
   ```

3. Abre tu navegador en:

   ```
   http://localhost:8081/TECNOLOGIA/
   ```

4. Importa la base de datos `app` desde PhpMyAdmin (`http://localhost:8080`) o mediante script SQL incluido.

---

## ✅ Funcionalidades principales

### Empleados

- Crear, editar y eliminar registros
- Subida de foto y CV
- Generar carta de recomendación en PDF
- Validación con SweetAlert2

### Puestos

- Crear, editar y eliminar puestos
- Protección para evitar eliminar puestos con empleados asignados
- Validación de formulario

### Usuarios

- Crear, editar y eliminar usuarios
- Validación con alertas visuales

---

## 🧠 Mejoras de interfaz implementadas

- 🔍 Búsqueda instantánea en tablas (DataTables)
- 🔢 Paginación automática
- 📌 Ordenamiento por columnas
- 💬 Confirmación de acciones y validaciones con SweetAlert2
- 📄 Generación automática de PDF con Dompdf

---

## ✍️ Autor

- Carlos Eduardo Ugarteche  
- Proyecto académico - UPDS Bolivia  
- Abril 2025

---

## 📄 Licencia

Este proyecto es de uso académico. Puedes modificarlo o utilizarlo con fines educativos.

