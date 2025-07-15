# Backend para Catálogo de Trámites

En este repo se encuentra el backend para administrar la información del [Catálogo de Trámites](https://tramites.gob.gt/) de Guatemala.

A través de esta interfaz se pueden administrar: trámites, instituciones, categorías, y usuarios. Los trámites están asignados a una institución y a una categoría. Los usuarios están asociados a una institución, y pueden modificar todos los trámites de su institución. Los usuarios administradores pueden administrar categorías, instituciones y usuarios.

Las acciones de todos los usuarios quedan registradas en un Registro de Actividades, visible para administradores.

## Detalles

- Desarrollado en Laravel 11
- Base de datos MySQL

## TODO

Este sistema es solamente un backend, pero sienta las bases para desarrollar todo un frontend que utilice la información de esta base de datos para alimentar el sitio oficial.
