# Incidencias-Tecnicas
Actividad 8 - Administración de proyectos de software
#  Incidencias Tecnicas - Sistema de Gestión de Incidencias Técnicas

Este es un sistema web desarrollado bajo el patrón de arquitectura MVC (simplificado) para gestionar, asignar y dar seguimiento a incidencias técnicas dentro de una organización. 

El proyecto cumple con los requerimientos de la evaluación técnica, aplicando principios SOLID, DRY y separación de responsabilidades.

## Características Principales

- **Gestión de Tickets:** Creación de incidencias con niveles de prioridad (Alta, Media, Baja).
- **Asignación Inteligente:** Asignación de tickets a técnicos disponibles. Regla de negocio: Un técnico no puede tomar una nueva incidencia si ya tiene una activa.
- **Flujo de Estatus:** Transición de estados (Abierta -> En proceso -> Cerrada).
- **Bitácora de Seguimiento:** Historial inmutable de comentarios y notas de avance por incidencia.
- **Dashboard y Filtros:** Vista principal con filtrado dinámico por estatus.
- **Exportación a PDF:** Generación de reportes formales usando la librería TCPDF al cerrar un ticket.

##  Stack Tecnológico

- **Backend:** PHP 8.x (Arquitectura procedimental modular).
- **Base de Datos:** MySQL / MariaDB (Conexión segura vía PDO).
- **Frontend:** HTML5 y CSS3 nativo.
- **Librerías Externas:** TCPDF (para generación de reportes).

## Estructura del Proyecto

/sistema-incidencias
├── /config         # Conexión a BD y variables de entorno
├── /controladores    # Lógica de negocio e interacciones con la BD
├── /libs           # Librerías de terceros (TCPDF)
├── /vistas          # Vistas de usuario (Frontend), Header y Footer modulares
├── .gitignore      # Exclusión de archivos para el repositorio
└── README.md       # Documentación del proyecto
