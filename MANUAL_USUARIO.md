# 📚 Manual de Usuario - Sistema de Aprendizaje de Inglés

## 🎯 Índice
1. [Introducción](#introducción)
2. [Pantalla de Login](#pantalla-de-login)
3. [Dashboard del Estudiante](#dashboard-del-estudiante)
4. [Dashboard del Profesor](#dashboard-del-profesor)
5. [Dashboard del Padre](#dashboard-del-padre)
6. [Ejercicios Interactivos](#ejercicios-interactivos)
7. [Panel de Control del Profesor](#panel-de-control-del-profesor)
8. [Gestión de Contenido](#gestión-de-contenido)
9. [Solución de Problemas](#solución-de-problemas)

---

## 🌟 Introducción

El Sistema de Aprendizaje de Inglés es una plataforma educativa diseñada para estudiantes, profesores y padres. Ofrece ejercicios interactivos, seguimiento de progreso y herramientas de gestión académica.

### Características Principales
- **Interfaz amigable para niños** con colores vibrantes y animaciones
- **Sistema de puntos y logros** para motivar el aprendizaje
- **Seguimiento de progreso** en tiempo real
- **Gestión completa de contenido** para profesores
- **Monitoreo parental** del progreso de los hijos

---

## 🔐 Pantalla de Login

### Acceso al Sistema
**URL:** `http://localhost/englishdemo/`

### Componentes de la Interfaz

#### 1. **Logo del Sistema**
- **Ubicación:** Esquina superior izquierda
- **Texto:** "📚 Learning English"
- **Función:** Identificación visual del sistema

#### 2. **Formulario de Login**
- **Campos requeridos:**
  - **📧 Email:** Dirección de correo electrónico del usuario
  - **🔒 Password:** Contraseña personal
  - **🎭 Rol:** Seleccionar tipo de usuario (Estudiante/Profesor/Padre)

#### 3. **Botón de Acceso**
- **Texto:** "🚀 Enter / Entrar"
- **Función:** Validar credenciales e ingresar al sistema

### Cuentas de Demostración

#### 👨‍🎓 Estudiantes:
- **Email:** john.student@email.com | **Password:** password123 | **Nivel:** Beginner
- **Email:** emma.student@email.com | **Password:** password123 | **Nivel:** Intermediate
- **Email:** michael.student@email.com | **Password:** password123 | **Nivel:** Advanced

#### 👩‍🏫 Profesores:
- **Email:** jennifer.teacher@email.com | **Password:** password123
- **Email:** david.teacher@email.com | **Password:** password123

#### 👨‍👩‍👧‍👦 Padres:
- **Email:** sarah.parent@email.com | **Password:** password123
- **Email:** robert.parent@email.com | **Password:** password123

### Mensajes de Error
- **Credenciales incorrectas:** Aparece mensaje rojo con "❌ Error de autenticación"
- **Campos vacíos:** Validación automática del navegador

---

## 🧒 Dashboard del Estudiante

### Acceso
Después del login exitoso como estudiante, se redirige automáticamente al dashboard.

### Componentes Principales

#### 1. **Mascota Educativa**
- **Ubicación:** Parte superior de la pantalla
- **Función:** Hacer clic reproduce sonido motivacional y muestra confetti
- **Interacción:** Clickeable para efectos de sonido

#### 2. **Header de Bienvenida**
- **Saludo personalizado:** "🌟 Hello [Nombre del Estudiante]!"
- **Información del nivel:** Muestra grado y nivel actual de inglés
- **Animación:** Efecto bounce al cargar

#### 3. **Menú de Navegación**
- **🎯 Mis ejercicios / My Exercises**
  - Redirige a ejercicios interactivos
  - URL: `?controller=student&action=interactiveExercises`
- **📈 Mi progreso / My Progress**
  - Ancla a la sección de progreso en la misma página
- **🚪 Salir / Exit**
  - Cierra sesión y regresa al login

#### 4. **Sección de Progreso**
- **Barra de progreso visual**
  - Muestra porcentaje de completitud
  - Color verde para progreso positivo
- **Estadísticas del estudiante:**
  - **⭐ Puntos acumulados:** Total de puntos ganados
  - **📅 Días de racha:** Días consecutivos de práctica
  - **🎯 Ejercicios completados:** Número total de ejercicios realizados

#### 5. **Tarjetas de Contenido**

##### **📚 English Topics / Temas de Inglés**
- Lista de temas asignados al estudiante
- Información mostrada:
  - Nombre del tema
  - Nivel requerido
  - Duración estimada en minutos

##### **🎮 Fun Exercises / Ejercicios Divertidos**
- Botones de acceso rápido:
  - **My Content:** Contenido asignado específicamente
  - **Practice:** Ejercicios interactivos generales

##### **🏆 My Achievements / Mis Logros**
- **Precisión:** Porcentaje de respuestas correctas
- **Nivel actual:** Nivel de inglés del estudiante

##### **📄 My Evaluations / Mis Evaluaciones**
- **Botón:** "👁️ Ver PDFs"
- **Función:** Acceso a evaluaciones en formato PDF

### Funcionalidades Interactivas

#### **Efectos de Sonido**
- **Sonido de motivación:** Al hacer clic en la mascota
- **Archivos de audio:** correct.mp3, incorrect.mp3, motivation.mp3
- **Fallback:** Generación de sonidos con Web Audio API

#### **Animaciones**
- **Confetti:** Partículas coloridas que caen al interactuar
- **Efectos CSS:** Bounce, fade-in, sparkle
- **Transiciones suaves:** En hover y clicks

---

## 👩‍🏫 Dashboard del Profesor

### Acceso
Login con credenciales de profesor para acceder al panel docente.

### Componentes de la Interfaz

#### 1. **Header del Dashboard**
- **Título:** "👩🏫 Panel del Profesor"
- **Descripción:** "Gestiona el aprendizaje de tus estudiantes"
- **Estadísticas en tiempo real:**
  - **👥 Número de estudiantes**
  - **📋 Total de evaluaciones**
  - **🎯 Ejercicios disponibles**

#### 2. **Botón de Logout**
- **Ubicación:** Esquina superior derecha
- **Texto:** "🚪 Salir"
- **Función:** Cerrar sesión y regresar al login

#### 3. **Lista de Estudiantes**
- **Información por estudiante:**
  - Nombre completo
  - Grado académico
  - Porcentaje de progreso
  - Nivel actual de inglés
  - Estado del grupo (asignado o sin grupo)

#### 4. **Sistema de Paginación**
- **Registros por página:** 5 estudiantes
- **Controles:**
  - **← Anterior:** Página previa
  - **Siguiente →:** Página siguiente
  - **Indicador:** "Página X de Y"

#### 5. **Tarjetas de Funcionalidades**

##### **📝 Crear Evaluación**
- **Función:** Diseñar nuevas evaluaciones
- **Botón:** "✏️ Crear"
- **Redirige a:** Formulario de creación de evaluaciones

##### **🎯 Panel del Profesor**
- **Función:** Acceso al panel de control completo
- **Botón:** "📤 Abrir Panel"
- **Incluye:** Gestión de planes, temas y progreso

##### **📊 Ver Resultados**
- **Función:** Análisis de resultados de evaluaciones
- **Botón:** "📈 Ver Resultados"
- **Características:** Tablas con paginación y filtros

##### **📝 Ejercicios Múltiples**
- **Función:** Crear hasta 10 ejercicios simultáneamente
- **Botón:** "⚡ Crear Múltiples"
- **Ventaja:** Ahorro de tiempo en creación masiva

##### **📄 Evaluación PDF**
- **Función:** Subir evaluaciones en formato PDF
- **Botón:** "📁 Subir PDF"
- **Formatos soportados:** PDF con integración Cloudinary

### Funcionalidades Avanzadas

#### **Gestión de Estudiantes**
- **Visualización completa** de todos los estudiantes registrados
- **Información detallada** de progreso y rendimiento
- **Agrupación por niveles** y estados

#### **Sistema de Notificaciones**
- **Notificaciones de éxito:** Fondo verde para operaciones exitosas
- **Notificaciones de error:** Fondo rojo para errores
- **Auto-ocultado:** Desaparecen automáticamente después de 3 segundos

---

## 👨‍👩‍👧‍👦 Dashboard del Padre

### Acceso
Login con credenciales de padre para monitorear el progreso de los hijos.

### Componentes Principales

#### 1. **Header Personalizado**
- **Saludo:** "👨👩👧👦 Hola [Nombre del Padre]"
- **Mensaje:** "Acompaña el aprendizaje de tu hijo/a"
- **Diseño:** Gradiente púrpura distintivo

#### 2. **Sección de Hijos**
- **Información por hijo:**
  - Nombre completo
  - Grado académico
  - Porcentaje de progreso
  - Nivel actual de inglés
  - Ejercicios completados
  - Estado del grupo

#### 3. **Tabla de Evaluaciones Recientes**
- **Columnas de información:**
  - **📝 Evaluación:** Título y tipo
  - **👤 Estudiante:** Nombre del hijo
  - **📊 Resultado:** Porcentaje con barra visual
  - **📅 Fecha:** Fecha de realización
  - **🏆 Estado:** Clasificación del rendimiento

#### 4. **Indicadores de Estado**
- **🏆 Excelente:** 90% o más (verde)
- **✅ Aprobado:** 70-89% (azul)
- **📚 Mejorar:** Menos de 70% (rojo)

#### 5. **Sistema de Paginación**
- **Registros por página:** 5 evaluaciones
- **Navegación:** Anterior/Siguiente con indicador de página

#### 6. **Tarjetas de Resumen**

##### **📈 Resumen de Progreso**
- **Barra de progreso general:** Promedio de todos los hijos
- **Información estadística:** Número de hijos monitoreados
- **Cálculo automático:** Promedio ponderado de progreso

##### **🎯 Recomendaciones**
- **Actividades sugeridas:**
  - **📚 Práctica diaria:** Ejercicios de inglés
  - **🎧 Audio en inglés:** 15 minutos diarios
  - **📖 Lectura nocturna:** Antes de dormir
- **Diseño visual:** Iconos y descripciones claras

### Funcionalidades de Monitoreo

#### **Seguimiento Multi-hijo**
- **Gestión centralizada** de múltiples hijos
- **Comparación de rendimiento** entre hermanos
- **Alertas de progreso** y recomendaciones personalizadas

#### **Análisis Visual**
- **Barras de progreso** con colores intuitivos
- **Gráficos de rendimiento** por evaluación
- **Indicadores de estado** fáciles de interpretar

---

## 🎯 Ejercicios Interactivos

### Acceso
Desde el dashboard del estudiante: "🎯 Mis ejercicios / My Exercises"

### Componentes de la Interfaz

#### 1. **Mascota Interactiva**
- **Función:** Motivación y feedback visual
- **Interacción:** Click para sonidos y efectos
- **Mensaje:** "Click me!" para guiar al usuario

#### 2. **Burbujas Decorativas**
- **Cantidad:** 5 burbujas animadas
- **Función:** Ambiente lúdico y atractivo visual
- **Animación:** Movimiento flotante continuo

#### 3. **Indicador de Progreso**
- **Información mostrada:**
  - "Exercise X of Y" (ejercicio actual de total)
  - Barra de progreso visual
  - Porcentaje de completitud

#### 4. **Tarjetas de Ejercicios**

##### **Información del Ejercicio**
- **Título del ejercicio**
- **Puntos disponibles:** "🏆 X points"
- **Contenido/Pregunta:** Fondo verde claro

##### **Tipos de Ejercicios**

###### **Multiple Choice (Opción Múltiple)**
- **Opciones en grid:** Botones organizados automáticamente
- **Selección visual:** Cambio de color al seleccionar
- **Validación:** Una sola opción seleccionable

###### **Fill in the Blank (Llenar Espacios)**
- **Campo de texto:** Input centrado y estilizado
- **Placeholder:** "Your answer..."
- **Validación:** Comparación de texto

###### **Listening (Comprensión Auditiva)**
- **Botón de audio:** "🔊 Play Audio"
- **Campo de respuesta:** "What did you hear?"
- **Simulación:** Mensaje de demo para audio

#### 5. **Sistema de Feedback**

##### **Respuesta Correcta**
- **Mensaje:** "✅ Correct! Well done! 🎉"
- **Color:** Verde con gradiente
- **Efectos:** Sonido de éxito + confetti
- **Puntos:** Se suman al total del estudiante

##### **Respuesta Incorrecta**
- **Mensaje:** "❌ Incorrect. The correct answer is: [respuesta]"
- **Color:** Rojo con gradiente
- **Efectos:** Sonido de error
- **Educativo:** Muestra la respuesta correcta

#### 6. **Controles de Navegación**
- **← Previous:** Regresar al ejercicio anterior
- **Next →:** Avanzar al siguiente ejercicio
- **🏆 Finish:** Completar la sesión de ejercicios

### Funcionalidades Avanzadas

#### **Sistema de Puntuación**
- **Puntos por ejercicio:** Variable según dificultad
- **Acumulación:** Suma total durante la sesión
- **Persistencia:** Guardado en base de datos

#### **Efectos de Audio**
- **Archivos de sonido:**
  - `correct.mp3` - Respuesta correcta
  - `incorrect.mp3` - Respuesta incorrecta
  - `motivation.mp3` - Motivación general
- **Fallback:** Web Audio API para generar tonos

#### **Animaciones y Efectos**
- **Confetti:** Partículas coloridas al acertar
- **Transiciones:** Suaves entre ejercicios
- **Feedback visual:** Cambios de color en tarjetas

#### **Guardado de Resultados**
- **Envío automático:** Al completar todos los ejercicios
- **Datos guardados:**
  - ID del ejercicio
  - Respuesta del usuario
  - Corrección (verdadero/falso)
  - Puntos obtenidos
- **Endpoint:** `/save_results.php`

#### **Celebración Final**
- **Confetti masivo:** 50 partículas animadas
- **Estadísticas finales:**
  - Respuestas correctas/total
  - Puntos ganados
  - Porcentaje de precisión
- **Mensajes motivacionales:**
  - 90%+: "🏆 Excellent work! You're a star!"
  - 70-89%: "😊 Great job! Keep practicing!"
  - <70%: "💪 Good effort! Practice makes perfect!"

---

## 🎯 Panel de Control del Profesor

### Acceso
Desde el dashboard del profesor: "🎯 Panel del Profesor" → "📤 Abrir Panel"

### Estructura del Panel

#### 1. **Header de Control**
- **Título:** "🎯 Panel de Control del Profesor"
- **Descripción:** "Gestiona planes de estudio, temas y asignaciones"
- **Navegación:** Botón de regreso al dashboard

#### 2. **Sistema de Notificaciones**
- **Tipos de notificación:**
  - **Éxito:** Fondo verde para operaciones exitosas
  - **Error:** Fondo rojo para errores o problemas
- **Comportamiento:** Auto-ocultado después de 3 segundos
- **Animación:** Slide-in desde arriba

### Tarjetas de Funcionalidades

#### 3. **👥 Crear Grupo**
- **Campos del formulario:**
  - **Nombre del Grupo:** Ej: "Beginners A1"
  - **Descripción:** Texto libre descriptivo
  - **Nivel:** Dropdown (Beginner/Elementary/Intermediate/Advanced)
- **Botón principal:** "✅ Crear Grupo"
- **Botón secundario:** "📋 Gestionar Grupos" (fondo rojo)

#### 3.1. **👤 Crear Estudiante + Padre**
- **Función:** Registro completo de estudiante con información del padre/tutor
- **Botón:** "👨👩👧👦 Crear Estudiante y Padre"
- **Redirige a:** Vista especializada con formularios duales
- **Características:**
  - Formulario dual para estudiante y padre
  - Validación de emails únicos
  - Creación automática de relación padre-hijo
  - Inicialización de progreso del estudiante

#### 3.2. **👤 Crear Solo Estudiante**
- **Función:** Registro individual de estudiante
- **Campos:** Nombre, email, contraseña, grado, edad, grupo opcional
- **Botón:** "👤 Crear Solo Estudiante"
- **Uso:** Para casos donde no se requiere información del padre

#### 4. **📚 Crear Plan de Estudios**
- **Campos requeridos:**
  - **Título:** Ej: "English Basics"
  - **Descripción:** Detalle del plan
  - **Nivel:** Selector de dificultad
  - **Duración:** 1-52 semanas (default: 8)
- **Botones:**
  - **Crear:** "✅ Crear Plan"
  - **Gestionar:** "📋 Gestionar Planes"

#### 5. **📖 Crear Tema**
- **Información del tema:**
  - **Nombre:** Ej: "Present Simple"
  - **Descripción:** Contenido del tema
  - **Nivel Requerido:** Prerequisito
  - **Duración:** 5-180 minutos (default: 30)
  - **Plan de Estudios:** Opcional, dropdown de planes existentes
- **Funciones:**
  - **Crear:** "✅ Crear Tema"
  - **Gestionar:** "📋 Gestionar Temas"

#### 6. **🎯 Crear Ejercicio**
- **Descripción:** "Diseña ejercicios interactivos para los estudiantes"
- **Botones de acceso:**
  - **Crear:** "📝 Crear Ejercicio" (redirige a formulario completo)
  - **Gestionar:** "📋 Gestionar Ejercicios"

#### 7. **👥 Asignar Estudiantes a Grupo**
- **Selección de grupo:** Dropdown con grupos existentes
- **Lista de estudiantes:**
  - **Formato:** Checkboxes con información completa
  - **Datos mostrados:**
    - Nombre del estudiante
    - Grado académico
    - Nivel actual
    - Estado de grupo (asignado/sin grupo)
- **Área scrolleable:** Máximo 200px de altura
- **Acción:** "👥 Asignar a Grupo"

#### 8. **👤 Crear Estudiante**
- **Información personal:**
  - **Nombre completo**
  - **Email único**
  - **Contraseña** (mínimo 6 caracteres)
  - **Grado académico**
  - **Edad** (5-100 años)
  - **Grupo opcional:** Asignación inmediata
- **Validación:** Campos requeridos marcados
- **Acción:** "👤 Crear Estudiante"

#### 9. **📝 Asignar Evaluación a Grupo**
- **Selección de evaluación:**
  - Dropdown con evaluaciones existentes
  - Información: Título, fecha, puntos totales
- **Selección de grupo:**
  - Dropdown con grupos disponibles
  - Información: Nombre y nivel del grupo
- **Función:** "📝 Asignar Evaluación"

### Tabla de Asignaciones Actuales

#### 10. **📊 Asignaciones Actuales**
- **Columnas de información:**
  - **Estudiante:** Nombre completo
  - **Plan:** Título del plan de estudios
  - **Nivel:** Badge colorido con nivel
  - **Fecha Inicio:** Fecha de asignación
  - **Fecha Fin:** Fecha estimada de finalización
- **Características:**
  - **Responsive:** Scroll horizontal en pantallas pequeñas
  - **Paginación:** 5 registros por página
  - **Estado vacío:** Mensaje cuando no hay asignaciones

#### 11. **Sistema de Paginación**
- **Controles:**
  - **← Anterior:** Página previa (si existe)
  - **Indicador:** "Página X de Y"
  - **Siguiente →:** Página siguiente (si existe)
- **Estilo:** Botones con gradiente azul
- **Funcionalidad:** Preserva filtros y estado

### Funcionalidades Técnicas

#### **Validación de Formularios**
- **Campos requeridos:** Validación HTML5
- **Tipos de input:** Email, number, password con restricciones
- **Feedback visual:** Bordes coloridos y mensajes de error

#### **Gestión de Estado**
- **Sesiones PHP:** Mantenimiento de notificaciones
- **Redirección:** Post-redirect-get pattern
- **Persistencia:** Guardado inmediato en base de datos

#### **Responsive Design**
- **Grid adaptativo:** 3 columnas → 2 → 1 según pantalla
- **Breakpoints:**
  - Desktop: 3 columnas (>1024px)
  - Tablet: 2 columnas (768-1024px)
  - Mobile: 1 columna (<768px)

---

## 📋 Gestión de Contenido

### Funcionalidades CRUD Completas

#### **Gestión de Planes de Estudio**
- **Crear:** Formulario con validación completa
- **Leer:** Lista paginada con filtros
- **Actualizar:** Edición in-line o formulario dedicado
- **Eliminar:** Confirmación antes de borrado

#### **Gestión de Temas**
- **Asociación:** Vinculación con planes de estudio
- **Filtrado:** Por nivel y duración
- **Ordenamiento:** Por fecha, nivel, duración

#### **Gestión de Ejercicios**
- **Tipos soportados:**
  - Multiple choice
  - Fill in the blank
  - Listening comprehension
- **Configuración de puntos:** Variable por dificultad
- **Asignación:** A temas específicos

#### **Gestión de Grupos**
- **Creación:** Con nivel y descripción
- **Asignación masiva:** Múltiples estudiantes
- **Monitoreo:** Progreso grupal

### Sistema de Archivos

#### **Subida de PDFs**
- **Integración Cloudinary:** Almacenamiento en la nube
- **Validación:** Tipo de archivo y tamaño
- **Procesamiento:** Conversión y optimización automática

#### **Gestión de Audio**
- **Formatos soportados:** MP3, WAV
- **Reproducción:** Player integrado
- **Fallback:** Generación sintética de audio

---

## 🔧 Solución de Problemas

### Problemas Comunes

#### **Error de Login**
- **Síntoma:** "❌ Error de autenticación"
- **Solución:**
  1. Verificar credenciales en ACCESOS.txt
  2. Confirmar selección correcta de rol
  3. Limpiar caché del navegador

#### **Base de Datos No Conecta**
- **Síntoma:** Página en blanco o error de conexión
- **Solución:**
  1. Verificar XAMPP/WAMP está ejecutándose
  2. Confirmar configuración en `config/Database.php`
  3. Importar `database.sql` en phpMyAdmin

#### **Archivos CSS/JS No Cargan**
- **Síntoma:** Página sin estilos o funcionalidad
- **Solución:**
  1. Verificar rutas en `/englishdemo/assets/`
  2. Confirmar permisos de lectura
  3. Limpiar caché del navegador

#### **Audio No Reproduce**
- **Síntoma:** Sin sonidos en ejercicios
- **Solución:**
  1. Verificar permisos de audio del navegador
  2. Confirmar archivos en `/assets/audio/`
  3. Probar en navegador diferente

#### **Problemas con Composer/Cloudinary**
- **Síntoma:** "Could not scan for classes inside vendor/cloudinary..."
- **Solución:**
  ```bash
  cd c:\xampp\htdocs\englishdemo
  rmdir /s vendor
  composer clear-cache
  composer install
  ```

#### **Paginación No Funciona**
- **Síntoma:** No cambian las páginas
- **Solución:**
  1. Verificar parámetros GET en URL
  2. Confirmar JavaScript habilitado
  3. Revisar configuración de sesiones PHP

#### **Ejercicios Múltiples No Aparecen para Estudiantes**
- **Síntoma:** Los ejercicios creados con "Ejercicios Múltiples" no se muestran en la interfaz del estudiante
- **Solución:**
  1. Verificar que el nivel del ejercicio sea compatible con el estudiante
  2. Los estudiantes pueden ver ejercicios de su nivel y niveles inferiores
  3. Usar el script de diagnóstico: `http://localhost/englishdemo/test_ejercicios.php`
  4. Verificar que los ejercicios se guardaron correctamente en la base de datos

#### **Respuestas de Opción Múltiple Marcadas Como Incorrectas**
- **Síntoma:** Al seleccionar la respuesta correcta en ejercicios de opción múltiple, se marca como incorrecta
- **Causa:** La respuesta correcta en la base de datos debe ser solo la letra (a, b, c, d), no la palabra completa
- **Solución Rápida (Recomendada):**
  1. Acceder a `http://localhost/englishdemo/fix_multiple_choice.php`
  2. El script corregirá automáticamente todos los ejercicios problemáticos
  3. Verificar que los ejercicios funcionen correctamente
- **Solución Manual:**
  1. Ejecutar el script `fix_multiple_choice.sql` en phpMyAdmin
  2. Verificar con el script de diagnóstico
- **Para Futuros Ejercicios:**
  - Usar solo letras como respuesta correcta: "a", "b", "c", "d"
  - Ejemplo: Si la opción correcta es "a) Blue", guardar solo "a"

### Mantenimiento Preventivo

#### **Limpieza Regular**
- **Caché del navegador:** Ctrl+F5 para refrescar
- **Sesiones PHP:** Limpiar `/tmp` periódicamente
- **Logs de error:** Revisar `/logs/` para errores

#### **Actualizaciones**
- **Composer:** `composer update` mensualmente
- **Base de datos:** Ejecutar scripts de actualización
- **Archivos estáticos:** Verificar integridad

#### **Respaldos**
- **Base de datos:** Export semanal desde phpMyAdmin
- **Archivos:** Copia de seguridad de `/englishdemo/`
- **Configuración:** Respaldar archivos de config

### Contacto de Soporte

#### **Recursos de Ayuda**
- **README.md:** Documentación técnica completa
- **ACCESOS.txt:** Credenciales de demostración
- **Logs del sistema:** Para diagnóstico técnico

#### **Información del Sistema**
- **Versión PHP:** 7.4+ requerida
- **Base de datos:** MySQL 5.7+
- **Servidor web:** Apache (XAMPP/WAMP/LAMP)
- **Navegadores soportados:** Chrome, Firefox, Safari, Edge

#### **Scripts de Diagnóstico y Corrección**
- **Diagnóstico:** `http://localhost/englishdemo/test_ejercicios.php`
  - Verificar ejercicios en base de datos y compatibilidad con estudiantes
  - Identificar problemas con ejercicios de opción múltiple
- **Corrección Automática:** `http://localhost/englishdemo/fix_multiple_choice.php`
  - Corrige automáticamente todos los ejercicios de opción múltiple
  - Muestra estado antes y después de las correcciones
  - **Recomendado:** Usar este script para solucionar problemas rápidamente
- **Corrección Manual:** `fix_multiple_choice.sql`
  - Script SQL para ejecutar manualmente en phpMyAdmin
  - Alternativa si prefieres control manual del proceso

---

## 📊 Resumen de Funcionalidades por Rol

### 🧒 Estudiante
- ✅ Dashboard personalizado con progreso
- ✅ Ejercicios interactivos con feedback
- ✅ Sistema de puntos y logros
- ✅ Visualización de evaluaciones PDF
- ✅ Seguimiento de racha diaria

### 👩‍🏫 Profesor
- ✅ Dashboard con estadísticas completas
- ✅ CRUD completo de contenido educativo
- ✅ Gestión de estudiantes y grupos
- ✅ Creación de evaluaciones y ejercicios
- ✅ Análisis de resultados con paginación
- ✅ Asignación masiva de contenido

### 👨‍👩‍👧‍👦 Padre
- ✅ Monitoreo de progreso de hijos
- ✅ Visualización de evaluaciones recientes
- ✅ Recomendaciones personalizadas
- ✅ Estadísticas familiares
- ✅ Seguimiento multi-hijo

---

*📚 Sistema de Aprendizaje de Inglés - Manual de Usuario v2.0*
*Última actualización: 2024*