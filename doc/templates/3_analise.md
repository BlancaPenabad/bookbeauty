# ANÁLISE: Requirimentos do sistema

Este documento describe os requerimientos de **Xestor de Citas**, especificando que funcionalidades ofrecerá e de qué xeito.

## Descrición xeral do proxecto

O proxecto está enfocado en desenvolver unha **aplicación web de xestión de citas** orientada a negocios do sector da estética/beleza (salóns de beleza, centros de medicina estética, dentistas, perruquerías) e centrarase na xestión de citas para distintos servizos relacionados. O obxectivo é establecer unha xestión eficiente das citas tanto para os clientes como os administradores dos negocios.

## Enumeración e descrición de cada unha das funcionalidades

| **Funcionalidade**   | **Descrición**                                                                 |
|----------------------|--------------------------------------------------------------------------------|
| **Reservar cita**     | Usuarios e administradores poden crear citas na BD.                             |
| **Cancelar cita**     | Usuarios e administradores poden eliminar citas da BD.                         |
| **Editar cita**       | Usuarios e administradores poden modificar datos das citas na BD.              |
| **Filtrar cita**      | Administradores poderán consultar e filtrar citas na BD.                       |
| **Engadir servizo**   | Administradores poden engadir un novo servizo na BD.                           |
| **Eliminar servizo**  | Administradores poden eliminar un servizo da BD.                               |
| **Editar servizo**    | Administradores poden modificar datos dos servizos na BD.                     |

### Descrición detallada das funcionalidades

- **Reservar cita**: Permitir a tanto usuarios como administradores reservar unha cita especificando a data, o servizo que se van a realizar, o nome, email e teléfono do cliente.
- **Cancelar cita**: Permitir a tanto usuarios como administradores eliminar/cancelar unha cita anteriormente programada.
- **Editar citas**: Permitir a tanto usuarios como administradores modificar algunha das especificacións dunha cita anteriormente programada.
- **Filtrar citas**: Permitir a tanto usuarios como administradores consultar e filtrar citas.
- **Engadir servizo**: Permitir ao administrador dun negocio engadir un novo servizo á súa oferta, especificando un nome, breve descrición, duración aproximada, e prezo.
- **Eliminar servizo**: Permitir ao administrador dun negocio eliminar un dos servizos ofertados.
- **Editar servizo**: Permitir ao administrador dun negocio modificar algunha das especificacións dos servizos ofertados.

## Tipos de usuarios

- **Clientes**: Son aqueles usuarios que van a solicitar citas en negocios para realizarse un servizo concreto. Poderán consultar os servizos ofertados e os negocios, así como programar unha cita, editala ou eliminala se o desexan.
- **Administradores**: Son aqueles encargados ou traballadores dun negocio que poderán facer as mesmas funcións que os clientes e ademais engadir novos servizos á súa oferta, así como editar ou eliminar os existentes.

## Entorno operacional

Estimación de plataformas, hardware e software necesarias para a implementación.

## Interfaces externos

### Interface de usuario

O programa **Xestor de Citas**, interaccionará co exterior exclusivamente por vía dunha **interface de usuario**, a cal será **responsive** de modo que sexa correctamente visualizada por distintos tamaños de pantalla (ordenador convencional, tablet e teléfonos móbiles).

## Melloras futuras

As versións futuras do sistema poderían incorporar melloras:

- **Recordatorios**: Recordatorios vía **email/SMS** aos clientes das citas programadas 24h antes da data establecida.
- **Calendario**: Vista tipo **calendario diario** onde se mostren as citas programadas e os ocos libres dun xeito visual e claro para facilitar a organización aos administradores.
- **Citas simultáneas**: Permitir simultaneidade de citas en función do número de traballadores dun negocio e da súa disponibilidade.