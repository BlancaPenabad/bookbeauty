# Proyecto fin de ciclo

> *TODO*: Este documento será la "*página de aterrizaje*" de tu proyecto. Será lo primero que vean los que se interesen por él. Cúida su redacción con todo tu mimo. Elimina posteriormente todas las lineas "*TODO*" cuando creas finalizada su redacción.
> Puedes acompañar a la redacción de este fichero con imágenes o gifs, pero no abuses de ellos.

## Descrición

O proxecto **BookBeauty** é unha aplicación web de xestión de citas orientada a negocios de servizos estéticos, medicina estética ou benestar, como centros de medicina estética, dentistas, perruquerías ou salóns de beleza. A aplicación permite tanto a administradores como a clientes xestionar eficazmente as citas, consultar dispoñibilidade e reservar servizos segundo as súas necesidades. 

A aplicación está desenvolvida usando **PHP** no backend, **HTML, CSS, JavaScript e Bootstrap** no frontend, e **MySQL** como base de datos. Actualmente, o programa está en fase de desenvolvemento e probas nun entorno local usando **XAMPP**, o que permite probar todas as funcionalidades. No futuro, poderá ser despregado nun servidor web público para o seu uso en liña. O obxectivo principal é facilitar a organización de citas, reducir erros humanos e mellorar a experiencia do usuario, tanto para os administradores dos negocios como para os clientes.

## Instalación / Posta en marcha

Para poñer en marcha **BookBeauty** no teu entorno local, segue estes pasos sinxelos:

## 1️⃣ Clonar o repositorio

Primeiro, clona o repositorio do proxecto no teu equipo. Podes facelo usando o seguinte comando no terminal:

```bash
git clone https://github.com/blancapenabad/bookbeauty
```

---

## 2️⃣ Subir o proxecto a XAMPP

Unha vez clonado o repositorio, copia a carpeta do proxecto (**bookbeauty**) ao directorio `htdocs` de XAMPP. O camiño típico é:

```plaintext
C:\xampp\htdocs\bookbeauty
```

---


## 3️⃣ Acceder ao programa

Unha vez configurado todo, abre o teu navegador e accede ao proxecto a través de:

```plaintext
http://localhost/bookbeauty/TraballoFinCiclo/a22blancapv/proxectoFinCiclo/index.php
```

---

##  4️⃣ Probar o programa

**BookBeauty** pode ser probado de dúas maneiras:

###  Opción 1: Usar datos de proba predefinidos
Ao aterrizar en `index.php`, podes explorar a aplicación cos valores predefinidos na base de datos. Estes inclúen:

- Negocios creados
- Servizos dispoñibles

###  Opción 2: Rexistrarse como Administrador

1. Accede a `register.php` para rexistrarte como **Administrador**.
2. Unha vez rexistrado, inicia sesión e crea un **novo negocio** a través de PHPMyAdmin.
3. Engade **servizos** ao teu negocio e xestiona as **citas** desde o panel de administración.

---

## 5️⃣ Explorar funcionalidades

### **Clientes:**
- Consultar servizos dispoñibles.
- Consultar negocios.
- Reservar citas.
- Recibir notificacións por correo electrónico.
- Xestionar as súas citas a través do código único envíado no correo de confirmación.

###  **Administradores:**
- Xestionar servizos.
- Xestionar citas.
- Recibir notificacións cando se reserva unha nova cita.

---

**Disfruta explorando todas as funcionalidades de BookBeauty!**



## Uso

A aplicación **BookBeauty** está deseñada para ser intuitiva e fácil de usar. A continuación, descríbense os aspectos máis relevantes do seu funcionamento:

- **Para Administradores**:
  - **Inicio de sesión**: Os administradores poden acceder ao sistema mediante un nome de usuario e contrasinal.
  - **Xestión de servizos**: Poden engadir, editar ou eliminar servizos ofertados, así como consultar unha lista completa dos mesmos.
  - **Xestión de citas**: Poden ver todas as citas reservadas, engadir novas citas ou eliminar ou editar citas existentes.
  - **Notificacións**: Reciben notificacións por correo electrónico cando se reserva unha nova cita.

- **Para Clientes**:
  - **Consulta de servizos**: Poden ver unha lista completa dos servizos ofertados, con información detallada sobre cada un (descrición, duración e prezo).
  - **Reserva de citas**: Poden consultar os días e horas dispoñibles e reservar citas para os servizos que desexen.
  - **Cancelación de citas**: Poden cancelar as súas citas reservadas.
  - **Notificacións**: Reciben unha confirmación por correo electrónico cando realizan unha reserva.

A interface gráfica é responsive, adaptándose a calquera dispositivo, e está deseñada para ser visualmente atractiva e fácil de navegar.


## Sobre o autor

Chámome **Blanca Penabad Villar** e estou a piques de graduarme como técnico superior en desenvolvemento de aplicacións web. Durante o meu período de formación, adquirín coñecementos sólidos en linguaxes de programación como **PHP, JavaScript, HTML e CSS**, así como en xestión de bases de datos **MySQL**. Tamén teño experiencia no uso de frameworks como **Bootstrap** para o deseño de interfaces responsive.

Decidín desenvolver **BookBeauty** como proxecto de fin de ciclo coa idea de crear unha solución tecnolóxica que resolva problemas reais e mellore a eficiencia dos negocios. Este proxecto permitiume combinar as miñas habilidades técnicas coa miña vontade de innovar no ámbito da xestión de citas e servizos.

Poden contactar comigo a través do meu correo electrónico: 
**a22blancapv@iessanclemente.com** ou **blancapenabad@outlook.com**.

## Licencia

O contido desta páxina web, incluíndo texto, imaxes, gráficos e outros elementos, está protexido baixo a seguinte licenza:

**Todos os dereitos reservados © 2025 Book Beauty.**

O uso non autorizado ou a reprodución deste contido, total ou parcialmente, sen o consentimento previo e por escrito de Book Beauty está estritamente prohibido. Para solicitar permisos adicionais ou máis información sobre a licenza, pódense poñer en contacto comigo a través do meu correo electrónico **a22blancapv@iessanclemente.com** ou **blancapenabad@outlook.com**.


## Índice

1. Anteproyecto
    * 1.1. [Idea](doc/templates/1_idea.md)
    * 1.2. [Necesidades](doc/templates/2_necesidades.md)
2. [Análisis](doc/templates/3_analise.md)
3. [Planificación](doc/templates/4_planificacion.md)
4. [Diseño](doc/templates/5_deseño.md)
5. [Implantación](doc/templates/6_implantacion.md)

