
CREATE DATABASE IF NOT EXISTS Poll_test CHARACTER SET utf8;
USE Poll_test;
CREATE TABLE Question
(
	Id						INT						NOT NULL	AUTO_INCREMENT,
  Description		VARCHAR(50)		NOT NULL,
  Views					BIGINT				NOT NULL,
  
  CONSTRAINT PK_question PRIMARY KEY (Id)
) ENGINE=MYISAM CHARSET=utf8;

CREATE TABLE QuestionOption
(
	IdQuestion		INT						NOT NULL,
  Id						SMALLINT			NOT NULL,
  Description		VARCHAR(30)		NOT NULL,
  Polling				BIGINT				NOT NULL,
  
  CONSTRAINT PK_QuestionOption PRIMARY KEY (IdQuestion,Id),
  CONSTRAINT FK_QuestionOption_Question FOREIGN KEY (IdQuestion) REFERENCES Question (Id)
) ENGINE=MYISAM CHARSET=utf8;

INSERT INTO Question (Description,Views) VALUES ('Primeira enquete criada',82);
INSERT INTO QuestionOption (IdQuestion,Id,Description,Polling) VALUES (1,1,'Primeira opção',10),(1,2,'Segunda opção',40),(1,3,'Terceira opção',32);
