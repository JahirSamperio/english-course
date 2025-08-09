# SISTEMA DE APRENDIZAJE DE INGLÉS - DOCUMENTACIÓN DE MÓDULOS

## 1. DESCRIPCIÓN GENERAL DEL SISTEMA

El Sistema de Aprendizaje de Inglés es una aplicación web educativa desarrollada en PHP con arquitectura MVC que permite la gestión integral del proceso de enseñanza-aprendizaje del idioma inglés para estudiantes de diferentes niveles.

## 2. MÓDULOS DEL SOFTWARE

### 2.1 MÓDULO DE AUTENTICACIÓN Y GESTIÓN DE USUARIOS

**Descripción:** Maneja el registro, autenticación y gestión de perfiles de usuarios del sistema.

**Funcionalidades:**
- Login/Logout de usuarios
- Gestión de sesiones
- Validación de credenciales
- Control de acceso por roles (Estudiante, Profesor, Padre)
- Recuperación de contraseñas

**Clases Principales:**
- `AuthController`: Controlador de autenticación
- `Usuario`: Modelo base de usuarios
- `Estudiante`: Modelo específico para estudiantes
- `Profesor`: Modelo específico para profesores
- `Padre`: Modelo específico para padres

### 2.2 MÓDULO DE GESTIÓN ACADÉMICA

**Descripción:** Administra el contenido educativo, planes de estudio y estructura curricular.

**Funcionalidades:**
- Creación y gestión de temas
- Administración de planes de estudio
- Gestión de unidades didácticas
- Asignación de contenido a estudiantes
- Control de niveles de dificultad

**Clases Principales:**
- `Tema`: Gestión de temas educativos
- `Plan_de_estudios`: Administración de planes curriculares
- `Unidad`: Gestión de unidades didácticas
- `Estudiantes_asignados`: Relación estudiante-plan

### 2.3 MÓDULO DE EJERCICIOS Y EVALUACIONES

**Descripción:** Maneja la creación, administración y ejecución de ejercicios y evaluaciones.

**Funcionalidades:**
- Creación de ejercicios por tipo (múltiple opción, completar, etc.)
- Gestión de evaluaciones
- Corrección automática
- Registro de resultados
- Generación de reportes de rendimiento

**Clases Principales:**
- `Ejercicio`: Gestión de ejercicios
- `Evaluacion`: Administración de evaluaciones
- `Resultado_de_evaluacion`: Registro de resultados
- `TeacherController`: Control de creación de contenido

### 2.4 MÓDULO DE SEGUIMIENTO Y PROGRESO

**Descripción:** Monitorea el progreso académico de los estudiantes y genera estadísticas.

**Funcionalidades:**
- Seguimiento de progreso individual
- Cálculo de porcentajes de avance
- Sistema de puntos y gamificación
- Registro de racha de días
- Generación de reportes de progreso

**Clases Principales:**
- `Progreso`: Seguimiento del avance estudiantil
- `StudentController`: Control de actividades del estudiante
- `ParentController`: Visualización para padres

### 2.5 MÓDULO DE CONTENIDO MULTIMEDIA

**Descripción:** Gestiona recursos multimedia como audios, videos y materiales de apoyo.

**Funcionalidades:**
- Gestión de archivos de audio
- Transcripciones de contenido
- Asociación multimedia-tema
- Reproducción de contenido
- Control de calidad de audio

**Clases Principales:**
- `Audio`: Gestión de archivos de audio
- Integración con modelos de `Tema`

### 2.6 MÓDULO DE DASHBOARDS Y REPORTES

**Descripción:** Proporciona interfaces específicas para cada tipo de usuario con información relevante.

**Funcionalidades:**
- Dashboard de estudiantes
- Panel de control para profesores
- Vista de seguimiento para padres
- Generación de reportes
- Visualización de estadísticas

**Clases Principales:**
- Controladores específicos por rol
- Vistas especializadas por usuario
- Sistema de notificaciones

## 3. DIAGRAMA DE CLASES

### 3.1 DIAGRAMA PRINCIPAL - GESTIÓN DE USUARIOS

```
┌─────────────────────────────────────────────────────────────────┐
│                           Usuario                                │
├─────────────────────────────────────────────────────────────────┤
│ - id: int                                                       │
│ - nombre: string                                                │
│ - email: string                                                 │
│ - password: string                                              │
│ - tipo: enum('estudiante', 'padre', 'profesor')                 │
│ - fecha_registro: timestamp                                     │
├─────────────────────────────────────────────────────────────────┤
│ + login(email, password): boolean                               │
│ + logout(): void                                                │
│ + validateCredentials(): boolean                                │
└─────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
        ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐
        │   Estudiante    │ │     Profesor    │ │      Padre      │
        ├─────────────────┤ ├─────────────────┤ ├─────────────────┤
        │ - usuario_id    │ │ - usuario_id    │ │ - usuario_id    │
        │ - grado: enum   │ │ - especialidad  │ │ - telefono      │
        │ - edad: int     │ │ - experiencia   │ └─────────────────┘
        │ - nivel_actual  │ │ - certificacion │
        ├─────────────────┤ ├─────────────────┤
        │ + getProgress() │ │ + createPlan()  │
        │ + updateLevel() │ │ + assignPlan()  │
        └─────────────────┘ │ + manageContent()│
                            └─────────────────┘
```

### 3.2 DIAGRAMA DE CONTENIDO ACADÉMICO

```
┌─────────────────────────────────────────────────────────────────┐
│                            Tema                                 │
├─────────────────────────────────────────────────────────────────┤
│ - id: int                                                       │
│ - nombre: string                                                │
│ - descripcion: text                                             │
│ - nivel_requerido: enum                                         │
│ - contenidos: text                                              │
│ - duracion_estimada: int                                        │
├─────────────────────────────────────────────────────────────────┤
│ + getById(id): Tema                                             │
│ + getByLevel(nivel): Tema[]                                     │
│ + getAssignedToStudent(estudiante_id): Tema[]                   │
└─────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
        ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐
        │    Ejercicio    │ │     Audio       │ │     Unidad      │
        ├─────────────────┤ ├─────────────────┤ ├─────────────────┤
        │ - id: int       │ │ - id: int       │ │ - id: int       │
        │ - titulo        │ │ - archivo_audio │ │ - titulo        │
        │ - contenido     │ │ - titulo        │ │ - descripcion   │
        │ - tipo: enum    │ │ - duracion      │ │ - orden_unidad  │
        │ - nivel: enum   │ │ - transcripcion │ │ - tema_id       │
        │ - puntos: int   │ │ - tema_id       │ ├─────────────────┤
        │ - tema_id       │ ├─────────────────┤ │ + getByTema()   │
        ├─────────────────┤ │ + play()        │ └─────────────────┘
        │ + getByTema()   │ │ + getByTema()   │
        │ + getByLevel()  │ └─────────────────┘
        │ + checkAnswer() │
        └─────────────────┘
```

### 3.3 DIAGRAMA DE EVALUACIÓN Y PROGRESO

```
┌─────────────────────────────────────────────────────────────────┐
│                         Evaluacion                              │
├─────────────────────────────────────────────────────────────────┤
│ - id: int                                                       │
│ - titulo: string                                                │
│ - descripcion: text                                             │
│ - fecha: date                                                   │
│ - tiempo_limite: int                                            │
│ - puntos_total: int                                             │
│ - estudiante_id: int                                            │
│ - profesor_id: int                                              │
├─────────────────────────────────────────────────────────────────┤
│ + create(): boolean                                             │
│ + getByStudent(estudiante_id): Evaluacion[]                     │
│ + calculateScore(): float                                       │
└─────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────┐
│                   Resultado_de_evaluacion                       │
├─────────────────────────────────────────────────────────────────┤
│ - id: int                                                       │
│ - calificaciones: decimal                                       │
│ - comentarios: text                                             │
│ - fecha_realizacion: timestamp                                  │
│ - tiempo_empleado: int                                          │
│ - evaluacion_id: int                                            │
│ - ejercicio_id: int                                             │
│ - respuesta_estudiante: text                                    │
│ - es_correcta: boolean                                          │
├─────────────────────────────────────────────────────────────────┤
│ + saveResult(): boolean                                         │
│ + getByEvaluation(evaluacion_id): Resultado[]                   │
└─────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────┐
│                          Progreso                               │
├─────────────────────────────────────────────────────────────────┤
│ - id: int                                                       │
│ - ejercicios_completados: int                                   │
│ - ejercicios_correctos: int                                     │
│ - porcentaje: decimal                                           │
│ - nivel_actual: enum                                            │
│ - puntos_acumulados: int                                        │
│ - racha_dias: int                                               │
│ - ultima_actividad: timestamp                                   │
│ - estudiante_id: int                                            │
├─────────────────────────────────────────────────────────────────┤
│ + updateProgress(): void                                        │
│ + calculatePercentage(): float                                  │
│ + updateStreak(): void                                          │
│ + getByStudent(estudiante_id): Progreso                         │
└─────────────────────────────────────────────────────────────────┘
```

### 3.4 DIAGRAMA DE CONTROLADORES MVC

```
┌─────────────────────────────────────────────────────────────────┐
│                      AuthController                             │
├─────────────────────────────────────────────────────────────────┤
│ + login(): void                                                 │
│ + logout(): void                                                │
│ + validateUser(credentials): boolean                            │
└─────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
        ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐
        │StudentController│ │TeacherController│ │ParentController │
        ├─────────────────┤ ├─────────────────┤ ├─────────────────┤
        │ + dashboard()   │ │ + dashboard()   │ │ + dashboard()   │
        │ + assignedContent()│ + createPlan() │ │ + viewProgress()│
        │ + startTopic()  │ │ + managePlans() │ │ + getReports()  │
        │ + startUnit()   │ │ + createTopic() │ └─────────────────┘
        │ + startEvaluation()│ + manageTopics()│
        │ + viewContent() │ │ + createExercise()│
        │ + interactiveExercises()│ + manageExercises()│
        └─────────────────┘ │ + assignPlan()  │
                            │ + results()     │
                            └─────────────────┘
```

### 3.5 DIAGRAMA DE BASE DE DATOS (Singleton Pattern)

```
┌─────────────────────────────────────────────────────────────────┐
│                         Database                                │
├─────────────────────────────────────────────────────────────────┤
│ - instance: Database (static)                                   │
│ - connection: PDO                                               │
│ - host: string                                                  │
│ - dbname: string                                                │
│ - username: string                                              │
│ - password: string                                              │
├─────────────────────────────────────────────────────────────────┤
│ - __construct(): void (private)                                 │
│ + getInstance(): Database (static)                              │
│ + getConnection(): PDO                                          │
│ - connect(): void                                               │
└─────────────────────────────────────────────────────────────────┘
```

## 4. PATRONES DE DISEÑO IMPLEMENTADOS

### 4.1 Model-View-Controller (MVC)
- **Modelos:** Gestión de datos y lógica de negocio
- **Vistas:** Presentación e interfaz de usuario
- **Controladores:** Lógica de control y coordinación

### 4.2 Singleton Pattern
- **Database:** Una única instancia de conexión a BD
- **Gestión eficiente** de recursos de conexión

### 4.3 Factory Pattern
- **Creación de objetos** según tipo de usuario
- **Instanciación dinámica** de controladores

## 5. TECNOLOGÍAS UTILIZADAS

- **Backend:** PHP 7.4+
- **Base de Datos:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Servidor Web:** Apache
- **Arquitectura:** MVC Pattern

## 6. ESTRUCTURA DE DIRECTORIOS

```
englishdemo/
├── assets/                 # Recursos estáticos
│   ├── css/               # Hojas de estilo
│   ├── js/                # Scripts JavaScript
│   ├── img/               # Imágenes
│   └── audio/             # Archivos de audio
├── config/                # Configuración
│   └── Database.php       # Conexión BD (Singleton)
├── controllers/           # Controladores MVC
│   ├── AuthController.php
│   ├── StudentController.php
│   ├── TeacherController.php
│   └── ParentController.php
├── models/                # Modelos de datos
│   ├── Usuario.php
│   ├── Estudiante.php
│   ├── Profesor.php
│   ├── Padre.php
│   ├── Tema.php
│   ├── Ejercicio.php
│   ├── Evaluacion.php
│   └── Progreso.php
├── views/                 # Vistas por rol
│   ├── auth/             # Autenticación
│   ├── student/          # Vistas de estudiante
│   ├── teacher/          # Vistas de profesor
│   └── parent/           # Vistas de padre
├── index.php             # Router principal
└── database.sql          # Esquema de BD
```

## 7. FUNCIONALIDADES POR MÓDULO

### 7.1 Módulo de Estudiantes
- Dashboard personalizado
- Visualización de contenido asignado
- Ejecución de ejercicios interactivos
- Seguimiento de progreso personal
- Sistema de gamificación

### 7.2 Módulo de Profesores
- Panel de administración
- Gestión CRUD de planes, temas y ejercicios
- Asignación de contenido a estudiantes
- Monitoreo de resultados
- Generación de reportes

### 7.3 Módulo de Padres
- Dashboard de seguimiento
- Visualización del progreso de hijos
- Historial de evaluaciones
- Recomendaciones personalizadas
- Estadísticas detalladas

## 8. SEGURIDAD Y VALIDACIONES

- **Autenticación:** Validación de credenciales
- **Autorización:** Control de acceso por roles
- **Sanitización:** Limpieza de datos de entrada
- **Prepared Statements:** Prevención de SQL Injection
- **Sesiones seguras:** Gestión de sesiones PHP

## 9. ESCALABILIDAD Y MANTENIMIENTO

- **Arquitectura modular:** Fácil extensión
- **Separación de responsabilidades:** Mantenimiento simplificado
- **Código reutilizable:** Componentes compartidos
- **Documentación completa:** Facilita el mantenimiento
- **Patrones estándar:** Desarrollo consistente

---

**Documento generado para:** Sistema de Aprendizaje de Inglés  
**Versión:** 2.0  
**Fecha:** Diciembre 2024  
**Arquitectura:** MVC con PHP/MySQL