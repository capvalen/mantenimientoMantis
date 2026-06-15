DELIMITER ;;

CREATE FUNCTION `fechaAnterior`(`placa` INT) RETURNS date
    NO SQL
BEGIN
    DECLARE valor DATE DEFAULT NULL;
    
    SELECT fActualizacion INTO valor 
    FROM aceite
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN valor;
END ;;

CREATE FUNCTION `fechaRecienteCaja`(`placa` INT) RETURNS date
    NO SQL
BEGIN
    DECLARE valor DATE DEFAULT NULL;
    
    SELECT fActualizacion INTO valor 
    FROM caja
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN valor;
END ;;

CREATE FUNCTION `horometroAnterior`(`placa` INT) RETURNS int
    NO SQL
BEGIN
    DECLARE valor INT DEFAULT 0;
    
    SELECT horometro INTO valor 
    FROM aceite
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN valor;
END ;;

CREATE FUNCTION `horometroRecienteCaja`(`placa` INT) RETURNS int
    NO SQL
BEGIN
    DECLARE valor INT DEFAULT 0;
    
    SELECT horometro INTO valor 
    FROM caja
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN valor;
END ;;

CREATE FUNCTION `masReciente`(`placa` INT) RETURNS int
    NO SQL
BEGIN
    DECLARE idAceite INT DEFAULT 0;
    
    SELECT id INTO idAceite 
    FROM aceite
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN idAceite;
END ;;

CREATE FUNCTION `masRecienteCaja`(`placa` INT) RETURNS int
    NO SQL
BEGIN
    DECLARE idCaja INT DEFAULT 0;
    
    SELECT id INTO idCaja 
    FROM caja
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN idCaja;
END ;;

CREATE FUNCTION `observacionRecienteCaja`(`placa` INT) RETURNS varchar(1000) CHARSET utf8mb4
    NO SQL
BEGIN
    DECLARE valor VARCHAR(1000) DEFAULT '';
    
    SELECT observacion INTO valor 
    FROM caja
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN valor;
END ;;

CREATE FUNCTION `queKilo`(`placa` INT) RETURNS int
    NO SQL
BEGIN
    DECLARE idAceite INT DEFAULT 0;
    
    SELECT tipo INTO idAceite 
    FROM aceite
    WHERE idPlaca = placa 
    ORDER BY registro DESC 
    LIMIT 1;
    
    RETURN idAceite;
END ;;

DELIMITER ;