# SISTEMA DE APRENDIZAJE DE INGLÉS - DOCUMENTACIÓN DE BASE DE DATOS

## 1. DIAGRAMA ENTIDAD-RELACIÓN

```
                    ┌─────────────────┐
                    │     Usuario     │
                    │ PK: id          │
                    │    nombre       │
                    │    email        │
                    │    password     │
                    │    tipo         │
                    │    fecha_reg    │
                    └─────────────────┘
                            │
            ┌───────────────┼───────────────┐
            │               │               │
            ▼               ▼               ▼
    ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
    │ Estudiante  │ │  Profesor   │ │    Padre    │
    │ PK: id      │ │ PK: id      │ │ PK: id      │
    │ FK: usuario │ │ FK: usuario │ │ FK: usuario │
    │    grado    │ │ especialidad│ │   telefono  │
    │    edad     │ │ experiencia │ └─────────────┘
    │ nivel_actual│ │certificacion│        │
    └─────────────┘ └─────────────┘        │
            │               │              │
            │               │              ▼
            │               │      ┌─────────────┐
            │               │      │    Hijo     │
            │               │      │ PK: id      │
            │               │      │ FK: padre   │
            │               │      │ FK: estud.  │
            │               │      └─────────────┘
            │               │
            │               ▼
            │       ┌─────────────────┐
            │       │ Plan_de_estudios│
            │       │ PK: id          │
            │       │    titulo       │
            │       │    descripcion  │
            │       │    nivel        │
            │       │    duracion     │
            │       │    unidades     │
            │       └─────────────────┘
            │               │
            │               ▼
            │    ┌─────────────────────┐
            └───▶│Estudiantes_asignados│
                 │ PK: id              │
                 │ FK: estudiante_id   │
                 │ FK: plan_estudios   │
                 │    fecha_asignacion │
                 │    fecha_inicio     │
                 │    fecha_fin_est    │
                 └─────────────────────┘

    ┌─────────────────┐           ┌─────────────────┐
    │      Tema       │           │    Ejercicio    │
    │ PK: id          │◄──────────│ PK: id          │
    │    nombre       │           │ FK: tema_id     │
    │    descripcion  │           │    titulo       │
    │    nivel_req    │           │    contenido    │
    │    audios       │           │    respuesta    │
    │    contenidos   │           │    tipo         │
    │    duracion     │           │    nivel        │
    └─────────────────┘           │    puntos       │
            │                     └─────────────────┘
            │                             │
            ▼                             │
    ┌─────────────────┐                   │
    │     Audio       │                   │
    │ PK: id          │                   │
    │ FK: tema_id     │                   │
    │ archivo_audio   │                   │
    │    titulo       │                   │
    │    duracion     │                   │
    │ transcripcion   │                   │
    └─────────────────┘                   │
                                          │
    ┌─────────────────┐                   │
    │     Unidad      │                   │
    │ PK: id          │                   │
    │ FK: tema_id     │                   │
    │    titulo       │                   │
    │    descripcion  │                   │
    │    orden        │                   │
    └─────────────────┘                   │
                                          │
    ┌─────────────────┐                   │
    │   Evaluacion    │◄──────────────────┘
    │ PK: id          │
    │ FK: estudiante  │
    │ FK: profesor    │
    │    titulo       │
    │    descripcion  │
    │    fecha        │
    │    tiempo_lim   │
    │    puntos_total │
    │    resultado    │
    └─────────────────┘
            │
            ▼
    ┌─────────────────────┐
    │Resultado_evaluacion │
    │ PK: id              │
    │ FK: evaluacion_id   │
    │ FK: ejercicio_id    │
    │    calificaciones   │
    │    comentarios      │
    │    fecha_realizacion│
    │    tiempo_empleado  │
    │    respuesta_est    │
    │    es_correcta      │
    └─────────────────────┘

    ┌─────────────────┐
    │    Progreso     │
    │ PK: id          │
    │ FK: estudiante  │
    │ ejerc_complet   │
    │ ejerc_correctos │
    │    porcentaje   │
    │ nivel_actual    │
    │ puntos_acumul   │
    │    racha_dias   │
    │ ultima_actividad│
    └─────────────────┘
```

## 2. DESCRIPCIÓN DE TABLAS

### 2.1 TABLA USUARIO
**Propósito:** Almacena información básica de todos los usuarios del sistema.
**Tipo:** Tabla principal de autenticación
**Relaciones:** Padre de Estudiante, Profesor y Padre

### 2.2 TABLA ESTUDIANTE
**Propósito:** Información específica de estudiantes incluyendo nivel académico.
**Tipo:** Tabla de especialización de Usuario
**Relaciones:** Hijo de Usuario, relacionado con Progreso y Evaluaciones

### 2.3 TABLA PROFESOR
**Propósito:** Datos profesionales de los docentes del sistema.
**Tipo:** Tabla de especialización de Usuario
**Relaciones:** Hijo de Usuario, relacionado con Evaluaciones creadas

### 2.4 TABLA PADRE
**Propósito:** Información de contacto de padres de familia.
**Tipo:** Tabla de especialización de Usuario
**Relaciones:** Hijo de Usuario, relacionado con Hijo

### 2.5 TABLA HIJO
**Propósito:** Relación entre padres e hijos estudiantes.
**Tipo:** Tabla de relación muchos a muchos
**Relaciones:** Conecta Padre con Estudiante

### 2.6 TABLA TEMA
**Propósito:** Contenido educativo organizado por temas de aprendizaje.
**Tipo:** Tabla de contenido académico
**Relaciones:** Padre de Ejercicio, Audio y Unidad

### 2.7 TABLA AUDIO
**Propósito:** Archivos multimedia asociados a temas educativos.
**Tipo:** Tabla de recursos multimedia
**Relaciones:** Hijo de Tema

### 2.8 TABLA UNIDAD
**Propósito:** Organización de temas en unidades didácticas.
**Tipo:** Tabla de estructura curricular
**Relaciones:** Hijo de Tema

### 2.9 TABLA PLAN_DE_ESTUDIOS
**Propósito:** Planes curriculares con duración y nivel específico.
**Tipo:** Tabla de planificación académica
**Relaciones:** Relacionado con Estudiantes_asignados

### 2.10 TABLA ESTUDIANTES_ASIGNADOS
**Propósito:** Asignación de planes de estudio a estudiantes específicos.
**Tipo:** Tabla de relación muchos a muchos
**Relaciones:** Conecta Estudiante con Plan_de_estudios

### 2.11 TABLA EJERCICIO
**Propósito:** Ejercicios prácticos con diferentes tipos y niveles.
**Tipo:** Tabla de contenido interactivo
**Relaciones:** Hijo de Tema, relacionado con Resultado_de_evaluacion

### 2.12 TABLA EVALUACION
**Propósito:** Evaluaciones formales con tiempo límite y puntuación.
**Tipo:** Tabla de assessment
**Relaciones:** Relacionado con Estudiante, Profesor y Resultado_de_evaluacion

### 2.13 TABLA RESULTADO_DE_EVALUACION
**Propósito:** Resultados detallados de evaluaciones por ejercicio.
**Tipo:** Tabla de resultados académicos
**Relaciones:** Hijo de Evaluacion y Ejercicio

### 2.14 TABLA PROGRESO
**Propósito:** Seguimiento del avance académico de cada estudiante.
**Tipo:** Tabla de métricas y estadísticas
**Relaciones:** Hijo de Estudiante

## 3. DICCIONARIO DE DATOS

### 3.1 TABLA: Usuario
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del usuario |
| nombre | VARCHAR | 100 | NO | - | Nombre completo del usuario |
| email | VARCHAR | 100 | NO | UNIQUE | Correo electrónico único |
| password | VARCHAR | 255 | NO | - | Contraseña encriptada |
| tipo | ENUM | - | NO | - | Tipo: estudiante, padre, profesor |
| fecha_registro | TIMESTAMP | - | NO | - | Fecha de registro en el sistema |

### 3.2 TABLA: Estudiante
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del estudiante |
| usuario_id | INT | - | SÍ | FK | Referencia a tabla Usuario |
| grado | ENUM | - | NO | - | Nivel: Beginner, Elementary, etc. |
| edad | INT | - | SÍ | - | Edad del estudiante |
| nivel_actual | VARCHAR | 50 | SÍ | - | Nivel actual de inglés |

### 3.3 TABLA: Padre
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del padre |
| usuario_id | INT | - | SÍ | FK | Referencia a tabla Usuario |
| telefono | VARCHAR | 20 | SÍ | - | Número de teléfono de contacto |

### 3.4 TABLA: Hijo
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único de la relación |
| padre_id | INT | - | SÍ | FK | Referencia a tabla Padre |
| estudiante_id | INT | - | SÍ | FK | Referencia a tabla Estudiante |

### 3.5 TABLA: Profesor
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del profesor |
| usuario_id | INT | - | SÍ | FK | Referencia a tabla Usuario |
| especialidad | VARCHAR | 100 | SÍ | - | Área de especialización |
| experiencia_anos | INT | - | SÍ | - | Años de experiencia docente |
| certificacion | VARCHAR | 200 | SÍ | - | Certificaciones profesionales |

### 3.6 TABLA: Tema
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del tema |
| nombre | VARCHAR | 255 | NO | - | Nombre del tema educativo |
| descripcion | TEXT | - | SÍ | - | Descripción detallada del tema |
| nivel_requerido | ENUM | - | SÍ | - | Nivel mínimo requerido |
| audios | TEXT | - | SÍ | - | Referencias a archivos de audio |
| contenidos | TEXT | - | SÍ | - | Contenido educativo del tema |
| duracion_estimada | INT | - | SÍ | - | Duración estimada en minutos |

### 3.7 TABLA: Audio
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del audio |
| archivo_audio | VARCHAR | 255 | NO | - | Nombre del archivo de audio |
| titulo | VARCHAR | 255 | NO | - | Título descriptivo del audio |
| duracion | INT | - | SÍ | - | Duración en segundos |
| transcripcion | TEXT | - | SÍ | - | Transcripción del audio |
| tema_id | INT | - | SÍ | FK | Referencia a tabla Tema |

### 3.8 TABLA: Unidad
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único de la unidad |
| titulo | VARCHAR | 255 | NO | - | Título de la unidad didáctica |
| descripcion | TEXT | - | SÍ | - | Descripción de la unidad |
| orden_unidad | INT | - | SÍ | - | Orden secuencial de la unidad |
| tema_id | INT | - | SÍ | FK | Referencia a tabla Tema |

### 3.9 TABLA: Plan_de_estudios
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del plan |
| titulo | VARCHAR | 255 | NO | - | Título del plan de estudios |
| descripcion | TEXT | - | SÍ | - | Descripción detallada del plan |
| nivel | ENUM | - | SÍ | - | Nivel del plan de estudios |
| duracion_semanas | INT | - | SÍ | - | Duración en semanas |
| unidades | TEXT | - | SÍ | - | Unidades incluidas en el plan |
| fecha_creacion | TIMESTAMP | - | NO | - | Fecha de creación del plan |

### 3.10 TABLA: Estudiantes_asignados
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único de asignación |
| estudiante_id | INT | - | SÍ | FK | Referencia a tabla Estudiante |
| plan_estudios_id | INT | - | SÍ | FK | Referencia a Plan_de_estudios |
| fecha_asignacion | TIMESTAMP | - | NO | - | Fecha de asignación del plan |
| fecha_inicio | DATE | - | SÍ | - | Fecha de inicio del plan |
| fecha_fin_estimada | DATE | - | SÍ | - | Fecha estimada de finalización |

### 3.11 TABLA: Ejercicio
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del ejercicio |
| titulo | VARCHAR | 255 | NO | - | Título del ejercicio |
| contenido | TEXT | - | NO | - | Contenido/pregunta del ejercicio |
| respuesta_correcta | TEXT | - | NO | - | Respuesta correcta del ejercicio |
| tipo | ENUM | - | NO | - | Tipo: multiple_choice, fill_blank, etc. |
| nivel | ENUM | - | SÍ | - | Nivel de dificultad |
| puntos | INT | - | SÍ | - | Puntos otorgados por respuesta correcta |
| tema_id | INT | - | SÍ | FK | Referencia a tabla Tema |

### 3.12 TABLA: Evaluacion
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único de evaluación |
| titulo | VARCHAR | 255 | NO | - | Título de la evaluación |
| descripcion | TEXT | - | SÍ | - | Descripción de la evaluación |
| fecha | DATE | - | NO | - | Fecha de la evaluación |
| tiempo_limite | INT | - | SÍ | - | Tiempo límite en minutos |
| puntos_total | INT | - | SÍ | - | Puntuación total posible |
| resultado | DECIMAL | 5,2 | SÍ | - | Resultado obtenido |
| estudiante_id | INT | - | SÍ | FK | Referencia a tabla Estudiante |
| profesor_id | INT | - | SÍ | FK | Referencia a tabla Profesor |

### 3.13 TABLA: Resultado_de_evaluacion
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del resultado |
| calificaciones | DECIMAL | 5,2 | NO | - | Calificación obtenida |
| comentarios | TEXT | - | SÍ | - | Comentarios del profesor |
| fecha_de_realizacion | TIMESTAMP | - | NO | - | Fecha y hora de realización |
| tiempo_empleado | INT | - | SÍ | - | Tiempo empleado en minutos |
| evaluacion_id | INT | - | SÍ | FK | Referencia a tabla Evaluacion |
| ejercicio_id | INT | - | SÍ | FK | Referencia a tabla Ejercicio |
| respuesta_estudiante | TEXT | - | SÍ | - | Respuesta dada por el estudiante |
| es_correcta | BOOLEAN | - | SÍ | - | Indica si la respuesta es correcta |

### 3.14 TABLA: Progreso
| Campo | Tipo | Longitud | Nulo | Clave | Descripción |
|-------|------|----------|------|-------|-------------|
| id | INT | - | NO | PK | Identificador único del progreso |
| ejercicios_completados | INT | - | SÍ | - | Número de ejercicios completados |
| ejercicios_correctos | INT | - | SÍ | - | Número de ejercicios correctos |
| porcentaje | DECIMAL | 5,2 | SÍ | - | Porcentaje de progreso |
| nivel_actual | ENUM | - | SÍ | - | Nivel actual del estudiante |
| puntos_acumulados | INT | - | SÍ | - | Puntos totales acumulados |
| racha_dias | INT | - | SÍ | - | Días consecutivos de actividad |
| ultima_actividad | TIMESTAMP | - | NO | - | Fecha de última actividad |
| estudiante_id | INT | - | SÍ | FK | Referencia a tabla Estudiante |

## 4. ÍNDICES Y RESTRICCIONES

### 4.1 CLAVES PRIMARIAS
- Todas las tablas tienen clave primaria `id` auto-incremental
- Garantizan unicidad de registros

### 4.2 CLAVES FORÁNEAS
- Mantienen integridad referencial
- Eliminación en cascada donde corresponde
- Eliminación con SET NULL para referencias opcionales

### 4.3 RESTRICCIONES ÚNICAS
- `Usuario.email`: Email único por usuario
- Combinaciones únicas en tablas de relación

### 4.4 RESTRICCIONES CHECK
- Valores ENUM validados a nivel de base de datos
- Rangos de valores para campos numéricos

## 5. CONSIDERACIONES DE RENDIMIENTO

### 5.1 ÍNDICES RECOMENDADOS
```sql
-- Índices para consultas frecuentes
CREATE INDEX idx_usuario_email ON Usuario(email);
CREATE INDEX idx_estudiante_nivel ON Estudiante(nivel_actual);
CREATE INDEX idx_tema_nivel ON Tema(nivel_requerido);
CREATE INDEX idx_ejercicio_tema ON Ejercicio(tema_id);
CREATE INDEX idx_progreso_estudiante ON Progreso(estudiante_id);
```

### 5.2 OPTIMIZACIONES
- Paginación en consultas de listado
- Consultas preparadas para prevenir SQL injection
- Conexión singleton para eficiencia

## 6. SEGURIDAD

### 6.1 ENCRIPTACIÓN
- Contraseñas hasheadas con algoritmos seguros
- Datos sensibles protegidos

### 6.2 VALIDACIONES
- Restricciones de integridad a nivel de BD
- Validaciones adicionales en capa de aplicación

### 6.3 AUDITORÍA
- Campos de timestamp para trazabilidad
- Registro de actividades críticas

---

**Documento generado para:** Sistema de Aprendizaje de Inglés  
**Versión:** 2.0  
**Fecha:** Diciembre 2024  
**Motor de BD:** MySQL 5.7+  
**Total de Tablas:** 14