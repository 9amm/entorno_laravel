create table if not exists usuario (
    id int auto_increment primary key,
    nombre varchar(80) not null,
    email varchar(255) not null unique,
    pass_hasheada varchar(255) not null,
    -- TODO: mejor crear tabla rol
    rol varchar(80) not null,
    modo_oscuro_activado boolean not null default 0
);

create table if not exists asignatura (
    id int auto_increment primary key,
    nombre varchar(80) not null
);

create table if not exists mensaje (
    id int auto_increment primary key,
    contenido varchar(300) not null,
    id_asignatura int not null,
    id_usuario int not null,
    -- TODO: normalizar, crear tabla estados_mensajes
    estado_mensaje varchar(80) not null,
    -- TODO: que la bd genere el timestamp directamente sin tener que hacerlo
    -- nosotros desde php
    timestamp_creacion varchar(255) not null,

    foreign key (id_asignatura) references asignatura(id)
        on delete cascade
        on update cascade,
    foreign key (id_usuario) references usuario(id)
        on delete cascade
        on update cascade
);
