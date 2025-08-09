# SISTEMA DE APRENDIZAJE DE INGLÉS - DIAGRAMA DE CLASES

## DIAGRAMA DE CLASES COMPLETO

```
                    ┌─────────────────────────────────────────────────────────────────┐
                    │                        Database                                 │
                    │ <<Singleton>>                                                   │
                    ├─────────────────────────────────────────────────────────────────┤
                    │ - instance: Database                                            │
                    │ - connection: PDO                                               │
                    │ - host: string                                                  │
                    │ - dbname: string                                                │
                    │ - username: string                                              │
                    │ - password: string                                              │
                    ├─────────────────────────────────────────────────────────────────┤
                    │ + getInstance(): Database                                       │
                    │ + getConnection(): PDO                                          │
                    │ - connect(): void                                               │
                    └─────────────────────────────────────────────────────────────────┘
                                                    │
                                                    │ uses
                                                    ▼
    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                           MODELOS                                                                   │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
                                                    │
                    ┌───────────────────────────────┼───────────────────────────────┐
                    │                               │                               │
                    ▼                               ▼                               ▼
    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │         Estudiante          │   │          Profesor           │   │           Padre             │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - db: PDO                   │   │ - db: PDO                   │   │ - db: PDO                   │
    │ - id: int                   │   │ - id: int                   │   │ - id: int                   │
    │ - usuario_id: int           │   │ - usuario_id: int           │   │ - usuario_id: int           │
    │ - grado: string             │   │ - especialidad: string      │   │ - telefono: string          │
    │ - edad: int                 │   │ - experiencia_anos: int     │   ├─────────────────────────────┤
    │ - nivel_actual: string      │   │ - certificacion: string     │   │ + __construct()             │
    ├─────────────────────────────┤   ├─────────────────────────────┤   │ + getById(id): array        │
    │ + __construct()             │   │ + __construct()             │   │ + getChildren(id): array    │
    │ + getById(id): array        │   │ + getById(id): array        │   │ + getAll(): array           │
    │ + getWithProgress(id): array│   │ + getAll(): array           │   │ + create(data): boolean     │
    │ + getAssignedPlan(id): array│   │ + create(data): boolean     │   │ + update(id, data): boolean │
    │ + getAll(): array           │   │ + update(id, data): boolean │   │ + delete(id): boolean       │
    │ + create(data): boolean     │   │ + delete(id): boolean       │   └─────────────────────────────┘
    │ + update(id, data): boolean │   │ + getStats(): array         │
    │ + delete(id): boolean       │   └─────────────────────────────┘
    └─────────────────────────────┘

    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │            Tema             │   │          Ejercicio          │   │           Audio             │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - db: PDO                   │   │ - db: PDO                   │   │ - db: PDO                   │
    │ - id: int                   │   │ - id: int                   │   │ - id: int                   │
    │ - nombre: string            │   │ - titulo: string            │   │ - archivo_audio: string     │
    │ - descripcion: text         │   │ - contenido: text           │   │ - titulo: string            │
    │ - nivel_requerido: string   │   │ - respuesta_correcta: text  │   │ - duracion: int             │
    │ - audios: text              │   │ - tipo: string              │   │ - transcripcion: text       │
    │ - contenidos: text          │   │ - nivel: string             │   │ - tema_id: int              │
    │ - duracion_estimada: int    │   │ - puntos: int               │   ├─────────────────────────────┤
    ├─────────────────────────────┤   │ - tema_id: int              │   │ + __construct()             │
    │ + __construct()             │   ├─────────────────────────────┤   │ + getById(id): array        │
    │ + getById(id): array        │   │ + __construct()             │   │ + getByTema(tema_id): array │
    │ + getByLevel(nivel): array  │   │ + getById(id): array        │   │ + getAll(): array           │
    │ + getAssignedToStudent(): array│ + getByLevel(nivel): array  │   │ + create(data): boolean     │
    │ + getAll(): array           │   │ + getByTemaId(tema_id): array│  │ + update(id, data): boolean │
    │ + create(data): boolean     │   │ + getAll(): array           │   │ + delete(id): boolean       │
    │ + update(id, data): boolean │   │ + create(data): boolean     │   │ + play(): void              │
    │ + delete(id): boolean       │   │ + update(id, data): boolean │   └─────────────────────────────┘
    └─────────────────────────────┘   │ + delete(id): boolean       │
                                      │ + checkAnswer(): boolean    │
                                      └─────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                        CONTROLADORES                                                               │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
                                                    │
                    ┌───────────────────────────────┼───────────────────────────────┐
                    │                               │                               │
                    ▼                               ▼                               ▼
    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │       AuthController        │   │      StudentController      │   │      TeacherController      │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - estudianteModel: Estudiante│  │ - estudianteModel: Estudiante│  │ - temaModel: Tema           │
    │ - profesorModel: Profesor   │   │ - temaModel: Tema           │   │ - ejercicioModel: Ejercicio │
    │ - padreModel: Padre         │   │ - ejercicioModel: Ejercicio │   │ - planModel: Plan           │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ + __construct()             │   │ + __construct()             │   │ + __construct()             │
    │ + login(): void             │   │ + dashboard(id): void       │   │ + dashboard(): void         │
    │ + logout(): void            │   │ + assignedContent(id): void │   │ + createPlan(): void        │
    │ + validateUser(): boolean   │   │ + startTopic(id): void      │   │ + managePlans(): void       │
    │ - loadView(view, data): void│   │ + startUnit(id): void       │   │ + createTopic(): void       │
    └─────────────────────────────┘   │ + startEvaluation(id): void │   │ + manageTopics(): void      │
                                      │ + viewContent(id): void     │   │ + createExercise(): void    │
                                      │ + interactiveExercises(): void│ + manageExercises(): void   │
                                      │ - loadView(view, data): void│   │ + assignPlan(): void        │
                                      └─────────────────────────────┘   │ + results(): void           │
                                                                        │ - loadView(view, data): void│
                                                                        └─────────────────────────────┘

                    ┌─────────────────────────────┐
                    │      ParentController       │
                    ├─────────────────────────────┤
                    │ - padreModel: Padre         │
                    │ - estudianteModel: Estudiante│
                    ├─────────────────────────────┤
                    │ + __construct()             │
                    │ + dashboard(id): void       │
                    │ + viewProgress(id): void    │
                    │ + getReports(id): void      │
                    │ - loadView(view, data): void│
                    └─────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                    MODELOS ADICIONALES                                                             │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘

    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │        Evaluacion           │   │         Progreso            │   │      Plan_de_estudios       │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - db: PDO                   │   │ - db: PDO                   │   │ - db: PDO                   │
    │ - id: int                   │   │ - id: int                   │   │ - id: int                   │
    │ - titulo: string            │   │ - ejercicios_completados: int│  │ - titulo: string            │
    │ - descripcion: text         │   │ - ejercicios_correctos: int │   │ - descripcion: text         │
    │ - fecha: date               │   │ - porcentaje: decimal       │   │ - nivel: string             │
    │ - tiempo_limite: int        │   │ - nivel_actual: string      │   │ - duracion_semanas: int     │
    │ - puntos_total: int         │   │ - puntos_acumulados: int    │   │ - unidades: text            │
    │ - resultado: decimal        │   │ - racha_dias: int           │   │ - fecha_creacion: timestamp │
    │ - estudiante_id: int        │   │ - ultima_actividad: timestamp│  ├─────────────────────────────┤
    │ - profesor_id: int          │   │ - estudiante_id: int        │   │ + __construct()             │
    ├─────────────────────────────┤   ├─────────────────────────────┤   │ + getById(id): array        │
    │ + __construct()             │   │ + __construct()             │   │ + getByStudentId(id): array │
    │ + create(): boolean         │   │ + updateProgress(): void    │   │ + getAll(): array           │
    │ + getByStudent(id): array   │   │ + calculatePercentage(): float│ + create(data): boolean     │
    │ + calculateScore(): float   │   │ + updateStreak(): void      │   │ + update(id, data): boolean │
    │ + getAll(): array           │   │ + getByStudent(id): array   │   │ + delete(id): boolean       │
    │ + update(id, data): boolean │   └─────────────────────────────┘   │ + assignToStudent(): boolean│
    │ + delete(id): boolean       │                                     └─────────────────────────────┘
    └─────────────────────────────┘

    ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │   Resultado_de_evaluacion   │   │    Estudiantes_asignados    │
    ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - db: PDO                   │   │ - db: PDO                   │
    │ - id: int                   │   │ - id: int                   │
    │ - calificaciones: decimal   │   │ - estudiante_id: int        │
    │ - comentarios: text         │   │ - plan_estudios_id: int     │
    │ - fecha_realizacion: timestamp│  │ - fecha_asignacion: timestamp│
    │ - tiempo_empleado: int      │   │ - fecha_inicio: date        │
    │ - evaluacion_id: int        │   │ - fecha_fin_estimada: date  │
    │ - ejercicio_id: int         │   ├─────────────────────────────┤
    │ - respuesta_estudiante: text│   │ + __construct()             │
    │ - es_correcta: boolean      │   │ + create(data): boolean     │
    ├─────────────────────────────┤   │ + getByStudent(id): array   │
    │ + __construct()             │   │ + getByPlan(id): array      │
    │ + saveResult(): boolean     │   │ + update(id, data): boolean │
    │ + getByEvaluation(id): array│   │ + delete(id): boolean       │
    │ + getByStudent(id): array   │   └─────────────────────────────┘
    │ + calculateGrade(): float   │
    └─────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                         VISTAS                                                                     │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘

    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │        auth/login.php       │   │    student/dashboard.php    │   │   teacher/dashboard.php     │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - Formulario de login       │   │ - Panel del estudiante      │   │ - Panel del profesor        │
    │ - Validación de campos      │   │ - Progreso personal         │   │ - Gestión de contenido      │
    │ - Selección de rol          │   │ - Temas asignados           │   │ - Estadísticas generales    │
    │ - Redirección por tipo      │   │ - Navegación principal      │   │ - Herramientas CRUD         │
    └─────────────────────────────┘   └─────────────────────────────┘   └─────────────────────────────┘

    ┌─────────────────────────────┐   ┌─────────────────────────────┐   ┌─────────────────────────────┐
    │   student/start_topic.php   │   │  student/view_content.php   │   │   parent/dashboard.php      │
    ├─────────────────────────────┤   ├─────────────────────────────┤   ├─────────────────────────────┤
    │ - Información del tema      │   │ - Contenido educativo       │   │ - Progreso de hijos         │
    │ - Lista de ejercicios       │   │ - Formato estructurado      │   │ - Evaluaciones recientes    │
    │ - Botón de práctica         │   │ - Navegación de regreso     │   │ - Recomendaciones           │
    └─────────────────────────────┘   └─────────────────────────────┘   └─────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                    ROUTER PRINCIPAL                                                                │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘

                                    ┌─────────────────────────────┐
                                    │         index.php           │
                                    ├─────────────────────────────┤
                                    │ - Router MVC principal      │
                                    │ - Control de sesiones       │
                                    │ - Validación de acceso      │
                                    │ - Instanciación controladores│
                                    │ - Manejo de parámetros GET  │
                                    ├─────────────────────────────┤
                                    │ + route(): void             │
                                    │ + validateSession(): boolean│
                                    │ + loadController(): void    │
                                    └─────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │                                    RELACIONES PRINCIPALES                                                          │
    └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘

    AuthController ──uses──> Estudiante, Profesor, Padre
    StudentController ──uses──> Estudiante, Tema, Ejercicio
    TeacherController ──uses──> Tema, Ejercicio, Plan_de_estudios
    ParentController ──uses──> Padre, Estudiante, Progreso

    Tema ──has many──> Ejercicio, Audio
    Estudiante ──has one──> Progreso
    Evaluacion ──has many──> Resultado_de_evaluacion
    Plan_de_estudios ──many to many──> Estudiante (via Estudiantes_asignados)

    All Models ──uses──> Database (Singleton)
    All Controllers ──loads──> Views
    index.php ──routes to──> Controllers
```

## PATRONES DE DISEÑO IMPLEMENTADOS

### 1. **Model-View-Controller (MVC)**
- **Separación clara** de responsabilidades
- **Modelos:** Gestión de datos y lógica de negocio
- **Vistas:** Presentación e interfaz de usuario  
- **Controladores:** Lógica de control y coordinación

### 2. **Singleton Pattern**
- **Database:** Una única instancia de conexión
- **Gestión eficiente** de recursos
- **Prevención** de múltiples conexiones

### 3. **Factory Pattern**
- **Router:** Creación dinámica de controladores
- **Instanciación** basada en parámetros
- **Flexibilidad** en la creación de objetos

## CARACTERÍSTICAS ARQUITECTURALES

### **Modelos (Models)**
- Cada modelo representa una entidad de BD
- Métodos CRUD estándar
- Validaciones de negocio
- Conexión singleton a BD

### **Controladores (Controllers)**
- Un controlador por tipo de usuario
- Métodos específicos por funcionalidad
- Carga de vistas con datos
- Validación de sesiones

### **Vistas (Views)**
- Organizadas por rol de usuario
- Separación de lógica y presentación
- Reutilización de componentes
- Interfaz responsive

### **Router**
- Punto de entrada único
- Control de acceso por roles
- Manejo de sesiones
- Enrutamiento dinámico

---

**Diagrama generado para:** Sistema de Aprendizaje de Inglés  
**Versión:** 2.0  
**Fecha:** Diciembre 2024  
**Arquitectura:** MVC con PHP/MySQL  
**Patrones:** Singleton, Factory, MVC