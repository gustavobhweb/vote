DROP DATABASE IF EXISTS db_votes;
CREATE DATABASE db_votes;
USE db_votes;

CREATE TABLE tbl_usuarios(
cod_usuario INT UNSIGNED AUTO_INCREMENT NOT NULL,
usuario VARCHAR(100) NOT NULL,
senha VARCHAR(255) NOT NULL,
nome VARCHAR(100) NOT NULL,
dataCad DATETIME NOT NULL,
PRIMARY KEY(cod_usuario)
);

CREATE TABLE tbl_funcionarios(
cod_funcionario INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
dataCad DATETIME NOT NULL,
tbl_usuarios_cod_usuario INT UNSIGNED NOT NULL,
PRIMARY KEY(cod_funcionario),
FOREIGN KEY(tbl_usuarios_cod_usuario) REFERENCES tbl_usuarios(cod_usuario)
);

CREATE TABLE tbl_votos(
cod_voto INT UNSIGNED AUTO_INCREMENT NOT NULL,
tbl_usuarios_cod_usuario INT UNSIGNED NOT NULL,
tbl_funcionarios_cod_funcionario INT UNSIGNED NOT NULL,
voto INT(1) NOT NULL,
dataIdVoto INT(7) NOT NULL,
PRIMARY KEY(cod_voto),
FOREIGN KEY(tbl_usuarios_cod_usuario) REFERENCES tbl_usuarios(cod_usuario),
FOREIGN KEY(tbl_funcionarios_cod_funcionario) REFERENCES tbl_funcionarios(cod_funcionario)
);
