# ANÁLISE: Requirimentos do sistema

Este documento describe os requerimientos do xestor de citas **BookBeauty**, especificando que funcionalidades ofrecerá e de qué xeito.

## Descrición xeral do proxecto

O proxecto está enfocado en desenvolver unha **aplicación web de xestión de citas** chamada BookBeauty, orientada a negocios do sector da estética/beleza (salóns de beleza, centros de medicina estética, dentistas, perruquerías) e centrarase na xestión de citas para distintos servizos relacionados. O obxectivo é establecer unha xestión eficiente das citas tanto para os clientes como os administradores dos negocios.

## Enumeración e descrición de cada unha das funcionalidades

| **Funcionalidade**   | **Descrición**                                                                 |
|----------------------|--------------------------------------------------------------------------------|
| **Reservar cita**     | Usuarios e administradores poden crear citas na BD.                             |
| **Cancelar cita**     | Usuarios e administradores poden eliminar citas da BD.                         |
| **Editar cita**       | Usuarios e administradores poden modificar datos das citas na BD.              |
| **Consultar cita**      | Administradores poderán consultar unha cita existente na BD.                       |
| **Engadir servizo**   | Administradores poden engadir un novo servizo na BD.                           |
| **Eliminar servizo**  | Administradores poden eliminar un servizo da BD.                               |
| **Editar servizo**    | Administradores poden modificar datos dos servizos na BD.                     |

### Descrición detallada das funcionalidades

- **Reservar cita**: Permitir a tanto usuarios como administradores reservar unha cita especificando a data, o servizo que se van a realizar, o nome, email e teléfono do cliente.
- **Cancelar cita**: Permitir a tanto usuarios como administradores eliminar/cancelar unha cita anteriormente programada.
- **Editar citas**: Permitir a tanto usuarios como administradores modificar algunha das especificacións dunha cita anteriormente programada.
- **Consultarar citas**: Permitir a tanto usuarios como administradores consultar citas existentes.
- **Engadir servizo**: Permitir ao administrador dun negocio engadir un novo servizo á súa oferta, especificando un nome, breve descrición, duración aproximada, e prezo.
- **Eliminar servizo**: Permitir ao administrador dun negocio eliminar un dos servizos ofertados.
- **Editar servizo**: Permitir ao administrador dun negocio modificar algunha das especificacións dos servizos ofertados.

## Tipos de usuarios

- **Clientes**: Son aqueles usuarios que van a solicitar citas en negocios para realizarse un servizo concreto. Poderán consultar os servizos ofertados e os negocios, así como programar unha cita, editala ou eliminala se o desexan.
- **Administradores**: Son aqueles encargados ou traballadores dun negocio que poderán facer as mesmas funcións que os clientes e ademais engadir novos servizos á súa oferta, así como editar ou eliminar os existentes.

## Entorno operacional

O programa **BookBeauty** está deseñado para funcionar nun **entorno local** durante a fase de desenvolvemento e probas, utilizando **XAMPP** como plataforma de servidor local. A continuación, descríbense os requisitos técnicos e o entorno operacional necesario para a súa implementación:

### Plataforma de Desenvolvemento

- **XAMPP**: Servidor local que inclúe Apache, MySQL e PHP.
  - **Apache**: Servidor web para executar a aplicación.
  - **MySQL**: Sistema de xestión de bases de datos para almacenar información de citas, servizos e usuarios.
  - **PHP**: Linguaxe de programación para o backend da aplicación.

### Requisitos de Hardware

- **Procesador**: Intel Core i3 ou superior.
- **Memoria RAM**: 4 GB mínimo (recoméndanse 8 GB para un rendemento óptimo).
- **Almacenamento**: 500 MB de espazo libre para a instalación de XAMPP e a aplicación.
- **Conexión a Internet**: Non é necesaria para o funcionamento local, pero é recomendable para probas de notificacións por correo electrónico.

### Requisitos de Software

- **Sistema Operativo**: Compatible con Windows, macOS ou Linux.
- **Navegador Web**: Compatible con Google Chrome, Mozilla Firefox, Microsoft Edge ou Safari (últimas versións recomendadas).
- **PHP**: Versión 7.4 ou superior.
- **MySQL**: Versión 5.6 ou superior.
- **Bootstrap**: Framework CSS para o deseño responsive da interface de usuario.

### Entorno de Produción Futuro

Unha vez finalizado o desenvolvemento e as probas, a aplicación poderá ser desplegada nun **servidor web público** con soporte para PHP e MySQL. As opcións inclúen:

- **Servidores compartidos**: Como Hostinger, Bluehost ou SiteGround.
- **Servidores na nube**: Como AWS, Google Cloud ou Microsoft Azure.
- **Servidores dedicados**: Para negocios que requiren maior control e escalabilidade.

### Notas Adicionais

- **Escalabilidade**: A aplicación está deseñada para ser escalable, permitindo a inclusión de novos negocios e servizos sen modificar a estrutura base.


### Interface de usuario

O programa **Xestor de Citas**, interaccionará co exterior exclusivamente por vía dunha **interface de usuario**, a cal será **responsive** de modo que sexa correctamente visualizada por distintos tamaños de pantalla (ordenador convencional, tablet e teléfonos móbiles).

## Melloras futuras

As versións futuras do sistema poderían incorporar melloras:

- **Recordatorios**: Recordatorios vía **email/SMS** aos clientes das citas programadas 24h antes da data establecida.

- **Citas simultáneas**: Permitir simultaneidade de citas en función do número de traballadores dun negocio e da súa disponibilidade.

- **Despregue nun servidor web público**: Para que sexa accesible a través de internet.

- **Recuperación de contrasinais**: Sistema de recuperación de contrasinais para administradores.
