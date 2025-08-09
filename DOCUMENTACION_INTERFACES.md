# SISTEMA DE APRENDIZAJE DE INGLÉS - DOCUMENTACIÓN DE INTERFACES

## 1. INTERFAZ DE LOGIN

### Título: Pantalla de Autenticación

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│                    🎓 Welcome! / ¡Bienvenido!                   │
│                Start learning English / Comienza a aprender     │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│    ┌─────────────────────────────────────────────────────────┐  │
│    │                    🎆 Login                             │  │
│    │                                                         │  │
│    │  📧 Email: [________________________]                  │  │
│    │                                                         │  │
│    │  🔒 Password: [________________________]               │  │
│    │                                                         │  │
│    │  🎭 I am / Soy: [▼ Select / Selecciona]               │  │
│    │                 - Student / Estudiante                 │  │
│    │                 - Teacher / Profesor                   │  │
│    │                 - Parent / Padre                       │  │
│    │                                                         │  │
│    │              [🚀 Enter / Entrar]                       │  │
│    └─────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Permite el acceso al sistema mediante autenticación de credenciales y selección de rol de usuario.

### Datos:
- **Capturados:** Email, contraseña, tipo de usuario
- **Validados:** Credenciales contra base de datos
- **Recuperados:** Información del usuario autenticado

### Validaciones:
- Email válido y existente en BD
- Contraseña correcta
- Rol seleccionado coincide con el usuario
- Campos obligatorios completos
- Sanitización de datos de entrada

---

## 2. DASHBOARD DE ESTUDIANTE

### Título: Panel Principal del Estudiante

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│  🌟 Hello John! | Level: Beginner | Points: 150 | Streak: 5    │
│  📋 Plan: Beginner English Course (Beginner)                   │
│  Progress: [████████░░] 80% completado                         │
├─────────────────────────────────────────────────────────────────┤
│  [📚 My Content] [🎯 Practice] [🚪 Exit]                      │
├─────────────────────────────────────────────────────────────────┤
│                    🏆 My Progress                               │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐              │
│  │    150      │ │      5      │ │     12      │              │
│  │   Points    │ │    Days     │ │ Exercises   │              │
│  └─────────────┘ └─────────────┘ └─────────────┘              │
├─────────────────────────────────────────────────────────────────┤
│  📚 English Topics        🎮 Fun Exercises    🏆 Achievements  │
│  ┌─────────────────────┐ ┌─────────────────┐ ┌───────────────┐ │
│  │ Grammar Basics      │ │ [My Content]    │ │ Accuracy: 85% │ │
│  │ Level: Beginner     │ │ [Practice]      │ │ Level: Begin. │ │
│  │ Duration: 90 min    │ │                 │ │               │ │
│  └─────────────────────┘ └─────────────────┘ └───────────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Proporciona una vista general del progreso del estudiante y acceso rápido a funcionalidades principales.

### Datos:
- **Capturados:** Interacciones del usuario (clicks, navegación)
- **Calculados:** Porcentaje de progreso, puntos acumulados, racha de días
- **Recuperados:** Información del estudiante, temas asignados, estadísticas

### Validaciones:
- Sesión activa de estudiante
- Datos de progreso actualizados
- Acceso solo a contenido asignado

---

## 3. MY LEARNING PATH

### Título: Contenido Asignado del Estudiante

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│                    📚 My Learning Path                          │
│              Content assigned specifically for you              │
├─────────────────────────────────────────────────────────────────┤
│  [🏠 Dashboard] [🎯 Practice]                                  │
├─────────────────────────────────────────────────────────────────┤
│                   📋 Your Study Plan                           │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ Beginner English Course                                     │ │
│  │ Complete beginner program for English learning              │ │
│  │ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐           │ │
│  │ │ Level   │ │Duration │ │ Started │ │  Ends   │           │ │
│  │ │Beginner │ │16 weeks │ │01/12/24 │ │15/04/25 │           │ │
│  │ └─────────┘ └─────────┘ └─────────┘ └─────────┘           │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                   📖 Your Topics (3)                           │
│  ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐  │
│  │ 📝 Grammar      │ │ 🗣️ Vocabulary   │ │ 👂 Listening    │  │
│  │ Basic rules     │ │ Essential words │ │ Comprehension   │  │
│  │ Level: Beginner │ │ Level: Beginner │ │ Level: Element. │  │
│  │ Duration: 90min │ │ Duration: 75min │ │ Duration: 120min│  │
│  │ Content: Verb.. │ │ Content: Family │ │ Content: Greet..│  │
│  │ [📖 Read] [🎯 Practice] │ [📖 Read] [🎯 Practice] │ [📖 Read] [🎯 Practice] │  │
│  └─────────────────┘ └─────────────────┘ └─────────────────┘  │
├─────────────────────────────────────────────────────────────────┤
│              [🚀 Start Practice Exercises]                     │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Muestra el plan de estudios asignado y los temas disponibles para el estudiante.

### Datos:
- **Capturados:** Selección de temas, navegación
- **Calculados:** Progreso por tema, tiempo estimado
- **Recuperados:** Plan asignado, temas del plan, contenidos

### Validaciones:
- Plan asignado válido
- Temas correspondientes al nivel del estudiante
- Contenido actualizado

---

## 4. START TOPIC

### Título: Inicio de Tema Específico

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│           🎯 Present Simple Tense | Level: Beginner             │
│                    Duration: 45 minutes                        │
├─────────────────────────────────────────────────────────────────┤
│  [📚 Back to Content] [🏠 Dashboard]                           │
├─────────────────────────────────────────────────────────────────┤
│                      📖 Topic Overview                         │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ Present Simple Tense                                        │ │
│  │ Learn how to use present simple for daily routines...      │ │
│  │ ┌─────────┐ ┌─────────┐ ┌─────────┐                       │ │
│  │ │ Level   │ │Duration │ │Exercise │                       │ │
│  │ │Beginner │ │ 45 min  │ │   8     │                       │ │
│  │ └─────────┘ └─────────┘ └─────────┘                       │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                   📝 What you'll learn:                        │
│  PRESENT SIMPLE TENSE - COMPLETE GUIDE                         │
│  📚 WHAT IS PRESENT SIMPLE?                                    │
│  The present simple tense is used to describe...               │
├─────────────────────────────────────────────────────────────────┤
│              [🚀 Start Practice Exercises]                     │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Presenta información detallada de un tema específico antes de comenzar los ejercicios.

### Datos:
- **Capturados:** Interacción con contenido, tiempo de lectura
- **Calculados:** Progreso de lectura
- **Recuperados:** Contenido del tema, ejercicios asociados

### Validaciones:
- Tema válido y asignado al estudiante
- Contenido formateado correctamente
- Ejercicios disponibles para el tema

---

## 5. VIEW CONTENT

### Título: Visualización de Contenido Educativo

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│              📖 Present Simple Tense | Level: Beginner         │
│                  Learn the fundamentals                        │
├─────────────────────────────────────────────────────────────────┤
│  [🎯 Practice] [📚 Back to Content]                            │
├─────────────────────────────────────────────────────────────────┤
│                   Present Simple Tense                         │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │                   📝 Topic Overview                         │ │
│  │ Learn how to use the present simple tense for daily...     │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                    📖 Learning Content                         │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ PRESENT SIMPLE TENSE - COMPLETE GUIDE                      │ │
│  │                                                             │ │
│  │ 📚 WHAT IS PRESENT SIMPLE?                                 │ │
│  │ The present simple tense is used to describe:              │ │
│  │ • Daily routines and habits                                │ │
│  │ • General facts and truths                                 │ │
│  │ • Permanent situations                                     │ │
│  │                                                             │ │
│  │ 🔤 STRUCTURE:                                              │ │
│  │ Positive: Subject + Verb (base form) + Object             │ │
│  │ • I work in an office                                      │ │
│  │ • She plays tennis                                         │ │
│  │                                                             │ │
│  │ ⚠️ IMPORTANT RULES:                                        │ │
│  │ 1. Third person singular (he, she, it) adds -s or -es     │ │
│  │ ✅ He works, She watches, It flies                        │ │
│  │ ❌ He work (WRONG)                                         │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│  ┌─────────┐ ┌─────────┐ ┌─────────┐                          │
│  │ Level   │ │Duration │ │ Created │                          │
│  │Beginner │ │ 45 min  │ │15/12/24 │                          │
│  └─────────┘ └─────────┘ └─────────┘                          │
├─────────────────────────────────────────────────────────────────┤
│        [🎯 Practice Exercises] [📚 Back to Topics]             │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Muestra el contenido educativo completo de un tema con formato estructurado.

### Datos:
- **Capturados:** Tiempo de lectura, scroll del contenido
- **Calculados:** Progreso de lectura
- **Recuperados:** Contenido completo del tema, metadatos

### Validaciones:
- Contenido existe y está disponible
- Formato correcto del contenido
- Acceso autorizado al tema

---

## 6. DASHBOARD DE PROFESOR

### Título: Panel de Control del Docente

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│        👩‍🏫 Teacher Dashboard - Jennifer Miller                  │
│    Specialty: English Grammar and Conversation | 8 years exp   │
├─────────────────────────────────────────────────────────────────┤
│  [📊 Panel] [📝 Create] [👥 Students] [🚪 Logout]             │
├─────────────────────────────────────────────────────────────────┤
│                      📊 Quick Stats                            │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐              │
│  │     15      │ │      8      │ │     45      │              │
│  │  Students   │ │   Plans     │ │   Topics    │              │
│  └─────────────┘ └─────────────┘ └─────────────┘              │
├─────────────────────────────────────────────────────────────────┤
│  📝 Content Management          👥 Student Management          │
│  ┌─────────────────────────────┐ ┌─────────────────────────────┐ │
│  │ [📋 Manage Plans]           │ │ [👤 View Students]          │ │
│  │ [📖 Manage Topics]          │ │ [📊 Student Results]        │ │
│  │ [🎯 Manage Exercises]       │ │ [📈 Progress Reports]       │ │
│  │ [➕ Create New Content]     │ │ [📋 Assign Plans]           │ │
│  └─────────────────────────────┘ └─────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                    📈 Recent Activity                          │
│  • Plan "Intermediate Course" assigned to 5 students          │
│  • Topic "Business English" created successfully              │
│  • 12 exercises completed by students today                   │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Proporciona herramientas de gestión académica y seguimiento de estudiantes para profesores.

### Datos:
- **Capturados:** Acciones de gestión, creación de contenido
- **Calculados:** Estadísticas de estudiantes, progreso general
- **Recuperados:** Planes, temas, ejercicios, resultados de estudiantes

### Validaciones:
- Sesión activa de profesor
- Permisos de creación y edición
- Datos de estudiantes actualizados

---

## 7. MANAGE PLANS

### Título: Gestión de Planes de Estudio

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│                    📋 Manage Study Plans                       │
│                  Create, Edit, and Assign Plans               │
├─────────────────────────────────────────────────────────────────┤
│  [🏠 Dashboard] [➕ Create Plan] [📊 Reports]                  │
├─────────────────────────────────────────────────────────────────┤
│  Search: [________________] [🔍] | Filter: [All Levels ▼]     │
├─────────────────────────────────────────────────────────────────┤
│                        Study Plans (8)                        │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ Plan                    │ Level  │ Duration │ Students │ Actions │
│  ├─────────────────────────────────────────────────────────────┤ │
│  │ Beginner English Course │ Begin. │ 16 weeks │    12    │ [✏️][👥][🗑️] │
│  │ Intermediate Grammar    │ Inter. │ 20 weeks │     8    │ [✏️][👥][🗑️] │
│  │ Advanced Conversation   │ Adv.   │ 24 weeks │     5    │ [✏️][👥][🗑️] │
│  │ Business English Pro    │ Upper  │ 18 weeks │     3    │ [✏️][👥][🗑️] │
│  │ TOEFL Preparation      │ Adv.   │ 12 weeks │     7    │ [✏️][👥][🗑️] │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                    Pagination: [1] 2 3 Next                   │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Permite la gestión completa de planes de estudio con operaciones CRUD y asignación a estudiantes.

### Datos:
- **Capturados:** Datos del plan, filtros, búsquedas
- **Calculados:** Número de estudiantes asignados, progreso
- **Recuperados:** Lista de planes, información de asignaciones

### Validaciones:
- Datos obligatorios del plan completos
- Nivel válido seleccionado
- Duración en rango permitido
- Confirmación para eliminación

---

## 8. CREATE PLAN

### Título: Creación de Plan de Estudios

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│                     ➕ Create Study Plan                       │
│                  Design a new learning path                   │
├─────────────────────────────────────────────────────────────────┤
│  [📋 Back to Plans] [💾 Save] [👁️ Preview]                    │
├─────────────────────────────────────────────────────────────────┤
│  Plan Title: [_________________________________]               │
│                                                                 │
│  Description:                                                   │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ [Detailed description of the study plan...]                │ │
│  │                                                             │ │
│  │                                                             │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  Level: [Beginner ▼]    Duration: [16] weeks                   │
│                                                                 │
│  Units/Topics:                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ [Grammar Basics, Essential Vocabulary, Conversation...]     │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  Start Date: [15/12/2024]  End Date: [Auto-calculated]         │
│                                                                 │
│  ☑️ Active Plan    ☑️ Allow Self-Enrollment                    │
├─────────────────────────────────────────────────────────────────┤
│              [💾 Save Plan] [❌ Cancel]                        │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Formulario para crear nuevos planes de estudio con todos los parámetros necesarios.

### Datos:
- **Capturados:** Título, descripción, nivel, duración, unidades, fechas
- **Calculados:** Fecha de finalización, validaciones de duración
- **Recuperados:** Temas disponibles para selección

### Validaciones:
- Título único y no vacío
- Descripción mínima requerida
- Nivel válido seleccionado
- Duración entre 4-52 semanas
- Fechas coherentes
- Al menos un tema seleccionado

---

## 9. DASHBOARD DE PADRE

### Título: Panel de Seguimiento Parental

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│              👨‍👩‍👧‍👦 Parent Dashboard - Sarah Davis              │
│                    Monitoring John's Progress                  │
├─────────────────────────────────────────────────────────────────┤
│  [👤 Profile] [📊 Reports] [📧 Messages] [🚪 Logout]          │
├─────────────────────────────────────────────────────────────────┤
│                    📊 Child's Progress                         │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ John Smith - Beginner Level                                │ │
│  │ Progress: [████████░░] 80% | Points: 150 | Streak: 5 days  │ │
│  │                                                             │ │
│  │ Current Plan: Beginner English Course                      │ │
│  │ Started: 01/12/2024 | Expected completion: 15/04/2025      │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│  📈 Progress Summary              🎯 Recommendations           │
│  ┌─────────────────────────────┐ ┌─────────────────────────────┐ │
│  │ ┌─────────┐ ┌─────────┐     │ │ • Practice daily for        │ │
│  │ │   85%   │ │   12    │     │ │   better retention          │ │
│  │ │Accuracy │ │Exercise │     │ │ • Focus on grammar          │ │
│  │ └─────────┘ └─────────┘     │ │   exercises                 │ │
│  │ ┌─────────┐ ┌─────────┐     │ │ • Review vocabulary         │ │
│  │ │   5     │ │  150    │     │ │   weekly                    │ │
│  │ │ Streak  │ │ Points  │     │ │ • Join conversation         │ │
│  │ └─────────┘ └─────────┘     │ │   practice sessions         │ │
│  └─────────────────────────────┘ └─────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                   📋 Recent Evaluations                        │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ Student    │ Topic           │ Score │ Date     │ Status     │ │
│  ├─────────────────────────────────────────────────────────────┤ │
│  │ John Smith │ Grammar Basics  │  88%  │ 14/12/24 │ ✅ Passed  │ │
│  │ John Smith │ Vocabulary Quiz │  92%  │ 13/12/24 │ ✅ Passed  │ │
│  │ John Smith │ Listening Test  │  76%  │ 12/12/24 │ ✅ Passed  │ │
│  └─────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Permite a los padres monitorear el progreso académico de sus hijos con estadísticas detalladas.

### Datos:
- **Capturados:** Filtros de fecha, selección de hijo
- **Calculados:** Estadísticas de progreso, promedios, tendencias
- **Recuperados:** Datos del estudiante hijo, evaluaciones, progreso

### Validaciones:
- Relación padre-hijo válida
- Sesión activa de padre
- Datos de progreso actualizados
- Permisos de visualización

---

## 10. INTERACTIVE EXERCISES

### Título: Ejercicios Interactivos

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│              🎯 Interactive English Exercises                  │
│                    Practice and Learn!                         │
├─────────────────────────────────────────────────────────────────┤
│  [📚 Content] [🏠 Dashboard] | Progress: [██░░░] 2/5          │
├─────────────────────────────────────────────────────────────────┤
│                    Present Simple Exercise                     │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ Question 2 of 5                              ⏱️ 02:30      │ │
│  │                                                             │ │
│  │ Complete the sentence with the correct form:                │ │
│  │                                                             │ │
│  │ "She _______ to work every day."                           │ │
│  │                                                             │ │
│  │ ○ A) go                                                    │ │
│  │ ○ B) goes                                                  │ │
│  │ ○ C) going                                                 │ │
│  │ ○ D) gone                                                  │ │
│  │                                                             │ │
│  │              [🔊 Listen] [💡 Hint]                         │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│  Points: 🏆 10 pts | Difficulty: ⭐⭐☆☆☆ | Type: Grammar      │
├─────────────────────────────────────────────────────────────────┤
│              [⏮️ Previous] [✅ Submit] [⏭️ Next]               │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Presenta ejercicios interactivos con diferentes tipos de preguntas y retroalimentación inmediata.

### Datos:
- **Capturados:** Respuestas del estudiante, tiempo empleado
- **Calculados:** Puntuación, progreso del ejercicio, tiempo restante
- **Recuperados:** Preguntas del ejercicio, respuestas correctas

### Validaciones:
- Respuesta seleccionada antes de enviar
- Tiempo límite respetado
- Progreso guardado correctamente
- Puntuación calculada automáticamente

---

## 11. EXERCISE RESULTS

### Título: Resultados de Ejercicios

### Diseño de la Interfaz:
```
┌─────────────────────────────────────────────────────────────────┐
│                    🎉 Exercise Completed!                      │
│                   Great job, keep it up!                      │
├─────────────────────────────────────────────────────────────────┤
│                      📊 Your Results                          │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │                Present Simple Exercise                      │ │
│  │                                                             │ │
│  │  Score: 4/5 (80%) ⭐⭐⭐⭐☆                                 │ │
│  │  Points Earned: +32 🏆                                     │ │
│  │  Time: 04:25 / 10:00 ⏱️                                   │ │
│  │  Accuracy: 80% 📈                                          │ │
│  │                                                             │ │
│  │  ✅ Question 1: Correct (+8 pts)                          │ │
│  │  ✅ Question 2: Correct (+8 pts)                          │ │
│  │  ❌ Question 3: Incorrect (0 pts)                         │ │
│  │     Correct answer: "goes" (3rd person singular)          │ │
│  │  ✅ Question 4: Correct (+8 pts)                          │ │
│  │  ✅ Question 5: Correct (+8 pts)                          │ │
│  └─────────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                    🎯 Recommendations                          │
│  • Review 3rd person singular rules                           │
│  • Practice more present simple exercises                     │
│  • Great improvement from last attempt!                       │
├─────────────────────────────────────────────────────────────────┤
│  [🔄 Try Again] [📚 Study Topic] [➡️ Next Exercise] [🏠 Home] │
└─────────────────────────────────────────────────────────────────┘
```

### Función:
Muestra resultados detallados del ejercicio con retroalimentación y recomendaciones.

### Datos:
- **Capturados:** Ninguno (vista de resultados)
- **Calculados:** Puntuación final, porcentaje, tiempo empleado
- **Recuperados:** Respuestas del estudiante, respuestas correctas, explicaciones

### Validaciones:
- Ejercicio completado válido
- Resultados calculados correctamente
- Progreso actualizado en base de datos

---

## RESUMEN DE VALIDACIONES GENERALES

### Validaciones de Seguridad:
- Autenticación de sesión en todas las interfaces
- Control de acceso por roles
- Sanitización de datos de entrada
- Prevención de SQL Injection con prepared statements
- Validación de permisos por funcionalidad

### Validaciones de Datos:
- Campos obligatorios completos
- Formatos de datos correctos (email, fechas, números)
- Rangos de valores válidos
- Unicidad de datos donde corresponde
- Integridad referencial en relaciones

### Validaciones de Negocio:
- Niveles de acceso apropiados
- Contenido asignado correctamente
- Progreso coherente y actualizado
- Fechas lógicas y consistentes
- Puntuaciones dentro de rangos esperados

---

**Documento generado para:** Sistema de Aprendizaje de Inglés  
**Versión:** 2.0  
**Fecha:** Diciembre 2024  
**Total de Interfaces:** 11 principales + sub-interfaces