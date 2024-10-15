drop database if exists bibilioteca;
create database biblioteca;
use biblioteca;

create table socios(
    id int auto_increment primary key,
    nombre varchar(100) not null,
    fechaSancion date default null,
    email varchar(255) not null
)engine InnoDB; 

create table libros(
    id int auto_increment primary key,
    titulo varchar(100) not null,
    ejemplares int not null,
    autor varchar(100) not null
)engine InnoDB; 

create table prestamos(
    id int auto_increment primary key,
    socio int not null,
    libro int not null,
    fechaP date not null, -- Fecha prestamo
    fechaD int not null, -- fechA devolución
    fechaRD date not null, -- fecha real devolución
    constraint fk_socio foreign key (socio) references socios(id) on update cascade on delete restrict,
    constraint fk_libro foreign key (libro) references libros(id) on update cascade on delete restrict
)engine InnoDB; 

-- Funcion que comprueba si se puede prestar el libro al socio, devuelve 1 si se puede hacer el prestamo
-- -1 si no hay ejemplares del libro
-- -2 si el socio esta sancionado o el socio no existe 
-- -3 si el socio tiene libros caducados
-- -4 si el socio tiene más de 2 libros prestados
-- 0 en cualquier otro caso (error)
delimiter //
create function comprobarSiPrestar(pSocio int,pLibro int) return int deterministic
 begin
 
    declare resultado int default 0;
    declare vId int;
    
    -- Comprobar ejemplares
    select id from libros
    into vId 
    where id = pLibro and ejemplares >0;
    
        if(vId is null) then
            return -1;
            end if;
            
            -- comprobamos socios
             select id from socio
            into vId 
            where id = pSocio and fechaSancion is null;
            
        if(vId is null) then
            return -2;
            end if;
            
            -- chequear si el socio tiene préstamos caducados
            select count(*) from prestamos
            into vId
            where socio = pSocio and fechaD < curdate() and fechaRD is null;

                if(vId >0) then
            return -3;
            end if;
            
            -- si el socio tiene más de 2 libros prestados
            
    return resultado;
 end;
delimiter ;

