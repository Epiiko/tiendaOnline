
create table ProductosCestas(
	idProducto int(8) not null,
    idCesta int(8) not null,
    constraint fk_ProductosCestas_productos
    FOREIGN KEY(idProducto) REFERENCES productos (idProducto),
    constraint fk_ProductosCestas_cestas
    FOREIGN KEY(idCesta) REFERENCES Cestas (idCesta),
    CONSTRAINT pk_ProductoCesta PRIMARY KEY (idProducto,idCesta)
    );
create table Usuarios(
	usuario varchar(12) not null primary key,
    contrasena varchar(255) not null,
    fechaNacimiento date not null
    );
create table Productos(
	idProducto int(8) auto_increment primary key not null,
    nombreProductos varchar(40) NOT null,
    precio numeric(7,2) NOT NULL,
    descripcion varchar(255) not null,
    cantidad int(5) not null
    );
create table Cestas(
    idCesta int(8) primary key auto_increment,
    usuario varchar(12) not null,
    precioTotal numeric(7,2) default 0
    );