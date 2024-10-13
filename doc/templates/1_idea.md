# Idea

# Proxecto de Desenvolvemento de Aplicación Web de Xestión de Citas

O proxecto que vou realizar consiste no desenvolvemento dunha **aplicación web de xestión de citas** orientada a negocios de servizos estéticos, medicina estética ou benestar (centros de medicina estética, dentistas, perruquerías, salóns de beleza…). A aplicación centrarase na xestión de citas para distintos servizos relacionados (tratamentos estéticos, medicina estética, tratamentos capilares, masaxes, manicuras…). A aplicación estará dispoñible a través de internet, accesible desde calquer dispositivo que conte cun navegador web, polo que non será necesaria a instalación dun software adiccional.

## Obxectivo Principal

O obxectivo principal da aplicación é permitir que tanto os administradores dos negocios coma os clientes poidan acceder e xestionar eficazmente as citas segundo os servizos ofertados e duración dos mesmos, así como consultar as datas dispoñibles. A aplicación non só facilita aos administradores dos negocios a organización e reserva de citas, senón que permite aos usuarios escoller eles mesmos as datas segundo a disponibilidade para podelas adaptar mellor ao seu horario.


O programa establecerá un acceso baseado en roles (administradores do negocio e clientes). Os administradores terán acceso á xestión (CRUD) de servizos ofertados e citas, mentres que os clientes disporán da capacidade de consultar disponibilidade e reservar ou eliminar citas, sen permisos adiccionais para levar a cabo modificacións ou cambios no sistema. Este sistema de acceso garante un funcionamento fluído e eficaz do programa.

# Requisitos Funcionais (RF)

## RF1: Autenticación de administradores
- **RF1.1**: Os administradores deben iniciar sesión mediante correo electrónico e contrasinal.

## RF2: Xestión de servizos ofertados
- **RF2.1**: Os administradores poderán engadir novos servizos ofertados.
- **RF2.2**: Os administradores poderán eliminar servizos ofertados.
- **RF2.3**: Os administradores poderán editar os servizos ofertados.
- **RF2.4**: O programa permitirá aos administradores visualizar unha lista completa dos servizos ofertados.
- **RF2.5**: O programa permitirá aos clientes ver unha lista completa dos servizos ofertados, así como acceder a información detallada dos mesmos (en qué consisten, duración do procedemento, duración de resultados e prezos).

## RF3: Xestión de citas
- **RF3.1**: O programa permitirá aos administradores visualizar unha lista completa das próximas citas reservadas por clientes.
- **RF3.2**: Os clientes poderán consultar os días disponibles, incluíndo a hora.
- **RF3.3**: Os clientes deberán especificar o servizo que se van a realizar na cita.
- **RF3.4**: Os clientes poderán cancelar a súa cita.
- **RF3.5**: Os administradores poderán engadir novas citas.
- **RF3.6**: Os administradores poderán elimina

## RF4: Sistema de notificacións
- **RF4.1**: O programa enviará unha notificación ao cliente vía email unha vez se formalice a reserva da cita coa confirmación da mesma.
- **RF4.2**: O programa enviará unha notificación ao administrador vía email unha vez se formalice unha cita.

# Arquitectura do Software
- **Backend**: PHP
- **Frontend**: HTML, CSS e Bootstrap
- **Base de datos**: MySQL (relacional)