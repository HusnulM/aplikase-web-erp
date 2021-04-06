-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2021 at 02:20 AM
-- Server version: 5.5.16
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta-erp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBatchByFIFO` (IN `pMaterial` VARCHAR(70), IN `pWhs` VARCHAR(20), IN `pQuantity` DECIMAL(15,2), IN `pMatdoc` VARCHAR(20), IN `pYear` VARCHAR(5), IN `pMvt` INT, IN `pMatdesc` VARCHAR(70), IN `pUnit` VARCHAR(10), IN `pWhs1` VARCHAR(10), IN `pWhs2` VARCHAR(10), IN `pShkzg` VARCHAR(1), IN `pResnum` VARCHAR(15), IN `pResitem` INT, IN `pCreatedby` VARCHAR(50))  BEGIN
    
    DECLARE inputQty decimal(15,2);
    DECLARE sBatch varchar(20);
    DECLARE bQty decimal(15,2);
    DECLARE _gritem INT;
	set inputQty = pQuantity;   
     
    
     WHILE inputQty >= 1 DO        
        SELECT batch, quantity into sBatch, bQty FROM t_batch_stock
        	WHERE material = pMaterial and warehouse = pWhs and quantity > 0 ORDER BY batch ASC LIMIT 1;
        
       
        SET _gritem = ( SELECT COUNT(*) FROM t_inv_i
        	WHERE grnum = pMatdoc and year = pYear);
        
        if(bQty > inputQty) THEN
        	
            INSERT INTO t_inv_i(grnum,year,gritem,movement,batchnumber,material,matdesc,quantity,unit,resnum,resitem,warehouse,warehouseto,shkzg,createdon,createdby) VALUES(pMatdoc, pYear, _gritem+1, pMvt, sBatch, pMaterial, pMatdesc,inputQty,pUnit,pResnum,pResitem,pWhs1,pWhs2,pShkzg,now(),pCreatedby);
            set inputQty = 0;
        ELSE
        		set inputQty = inputQty - bQty;
           
            INSERT INTO t_inv_i(grnum,year,gritem,movement,batchnumber,material,matdesc,quantity,unit,resnum,resitem,warehouse,warehouseto,shkzg,createdon,createdby) VALUES(pMatdoc, pYear, _gritem+1, pMvt, sBatch, pMaterial, pMatdesc,bQty,pUnit,pResnum,pResitem,pWhs1,pWhs2,pShkzg,now(),pCreatedby);
        END IF;
    END WHILE;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getWarehouseByObAuth` (IN `pUsername` VARCHAR(255))  BEGIN
	DECLARE checkAuthVal varchar(50);
    
    SELECT ob_value INTO checkAuthVal FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE' LIMIT 1;

    
    if checkAuthVal is null THEN
    	SELECT * FROM t_gudang LIMIT 0;
    elseif checkAuthVal = '*' THEN
    	SELECT * FROM t_gudang;
    else 
    	SELECT * FROM t_gudang where gudang in(SELECT ob_value FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE');
    end if;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAuthWhs` (IN `pUsername` VARCHAR(50))  BEGIN
	
    DECLARE checkAuthVal varchar(50);
    
    SELECT ob_value INTO checkAuthVal FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE' LIMIT 1;

    
    if checkAuthVal is null THEN
    	SELECT gudang FROM t_gudang LIMIT 0;
    elseif checkAuthVal = '*' THEN
    	SELECT gudang FROM t_gudang;
    else 
    	SELECT gudang FROM t_gudang where gudang in(SELECT ob_value FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE');
    end if;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetInvMovementCatByAuth` (IN `pUsername ` VARCHAR(50))  BEGIN
	DECLARE checkAuthVal varchar(50);
    
    SELECT ob_value INTO checkAuthVal FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE' LIMIT 1;

    
    if checkAuthVal is null THEN
    	SELECT * FROM t_gudang LIMIT 0;
    elseif checkAuthVal = '*' THEN
    	SELECT * FROM t_gudang;
    else 
    	SELECT * FROM t_gudang where gudang in(SELECT ob_value FROM t_user_object_auth where username = pUsername and ob_auth = 'OB_WAREHOUSE');
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetInvMovementCatByObjAuth` (IN `pUser` VARCHAR(50))  BEGIN
	DECLARE checkAuthVal varchar(50);
    
    SELECT ob_value INTO checkAuthVal FROM t_user_object_auth where username = pUser and ob_auth = 'OB_MOVEMENT' LIMIT 1;

    
    if checkAuthVal is null THEN
    	SELECT * FROM t_invmvt LIMIT 0;
    elseif checkAuthVal = '*' THEN
    	SELECT * FROM t_invmvt order by sorted;
    else 
    	SELECT * FROM t_invmvt where movement in(SELECT ob_value FROM t_user_object_auth where username = pUser and ob_auth = 'OB_MOVEMENT') order by sorted;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetMat2` (IN `pKodebrg` VARCHAR(15), IN `pUnit` VARCHAR(5))  BEGIN
	DECLARE _ConvUom decimal(15,2);
    
    SELECT convbase into _ConvUom from t_material2 where material = pKodebrg and altuom = pUnit;
    
    SELECT _ConvUom;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getStock` (IN `pUsername` VARCHAR(50), IN `pMaterial` VARCHAR(40), IN `pWhs` VARCHAR(15))  BEGIN

SELECT * FROM v_inventory01 where material like CONCAT('%', '', '%') and warehouse in(SELECT ob_value FROM t_user_object_auth where username = 'logistic2' and ob_auth = 'OB_WAREHOUSE') and warehouse like CONCAT('%', '', '%');
	
    
    
    
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertItemAuto` (IN `pGrnum` VARCHAR(15), IN `pYear` VARCHAR(5), IN `pGritem` INT, IN `pMovement` VARCHAR(5), IN `pMaterial` VARCHAR(40), IN `pMatdesc` VARCHAR(40), IN `pQuantity` DECIMAL(15,2), IN `pUnit` VARCHAR(5), IN `pPonum` VARCHAR(15), IN `pPoitem` INT, IN `pResnum` VARCHAR(15), IN `pResitem` INT, IN `pRemark` TEXT, IN `pWhs1` VARCHAR(15), IN `pWhs2` VARCHAR(15), IN `pShkzg` VARCHAR(1))  BEGIN

DECLARE _grItem int;

set _grItem = pGritem+1;

	INSERT INTO t_inv_i (grnum,year,gritem,movement,material,matdesc,quantity,unit,ponum,poitem,resnum,resitem,remark,warehouse,warehouseto,shkzg)
    VALUES(pGrnum,pYear,_grItem,pMovement,pMaterial,mMatdesc,pQuantity,pUnit,pPonum,pPoitem,pResnum,pResitem,pRemark,pWhs1,pWhs2,pShkzg);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_NextNriv` (IN `pObject` TEXT)  BEGIN

	DECLARE nextnumb bigint DEFAULT 0;
    
    Select currentnum INTO nextnumb from t_nriv WHERE object = pObject;
    
    if nextnumb = ''
    then 
    	Select fromnum INTO nextnumb from t_nriv WHERE object = pObject;
    end if;
    select nextnumb;
    
    UPDATE t_nriv set currentnum = nextnumb + 1 WHERE object = pObject;
    
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Pivot` ()  BEGIN
	SET @sql = NULL;
    SELECT
     GROUP_CONCAT(DISTINCT
       CONCAT(
         'max(IF(deskripsi= ''',
         deskripsi,
         ''', quantity, NULL)) AS ',
         REPLACE(REPLACE(REPLACE(deskripsi, ' ', '_'), '-','_'),'/','_')
       )
     ) INTO @sql
    FROM v_stockwip;

    SET @sql = CONCAT('SELECT v_stockwip .customer,
                        v_stockwip.partnumber, ', @sql, '
                        FROM v_stockwip
                      GROUP BY v_stockwip.customer');

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Pivot2` ()  BEGIN
	SET @sql = NULL;
    SELECT
     GROUP_CONCAT(DISTINCT
       CONCAT(
         'max(IF(deskripsi= ''',
         deskripsi,
         ''', quantity, NULL)) AS ',
         REPLACE(REPLACE(REPLACE(deskripsi, ' ', '_'), '-','_'),'/','_')
       )
     ) INTO @sql
    FROM v_stockwip;

    SET @sql = CONCAT('SELECT v_stockwip .customer,
                        v_stockwip.partnumber,v_stockwip.period, ', @sql, '
                        FROM v_stockwip
                      GROUP BY v_stockwip.customer,v_stockwip.partnumber,v_stockwip.period');

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pivot3` ()  BEGIN

SET @sql = NULL;

SELECT
  GROUP_CONCAT(DISTINCT
     CONCAT(
       'MAX(IF(period = ''',
   period,
   ''', deskripsi, NULL)) AS ',
   CONCAT("'",period,"'")
 )
   ) INTO @sql
FROM v_stockwip;

SET @sql = CONCAT('SELECT partnumber, ', @sql, ' FROM v_stockwip GROUP BY partnumber');

PREPARE stmt FROM @sql;
EXECUTE stmt;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ReportWIP` (IN `pStrdate` DATE, IN `pEnddate` DATE)  BEGIN
	SET @sql = NULL;
    
    SELECT
     GROUP_CONCAT(DISTINCT
       CONCAT(
         REPLACE(REPLACE(REPLACE(deskripsi, '-', '_') ,' ','_'),'/','_')
       )
     ) INTO @sql
    FROM v_stockwip;
    
    SET @sql = CONCAT('SELECT v_stockwip.partnumber,
                    v_stockwip.period, ', @sql, '
                    FROM v_stockwip
                  GROUP BY v_stockwip.partnumber');
                  
	PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ReportWIP1` ()  BEGIN
	SET @sql = NULL;
    SELECT
     GROUP_CONCAT(DISTINCT
       CONCAT(
         'max(IF(deskripsi= ''',
         deskripsi,
         ''', quantity, NULL)) AS ',
         REPLACE(REPLACE(REPLACE(deskripsi, ' ', '_'), '-','_'),'/','_')
       )
     ) INTO @sql
    FROM v_stockwip;

    SET @sql = CONCAT('CREATE TEMPORARY TABLE t1 (SELECT v_stockwip .customer,
                        v_stockwip.partnumber, ', @sql, '
                        FROM v_stockwip
                      GROUP BY v_stockwip.customer)');

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    
    SELECT * FROM t1;
	Drop temporary table t1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ReportWIP2` (IN `pDate1` DATE, IN `pDate2` DATE)  BEGIN
	SET @sql = NULL;
    SELECT
     GROUP_CONCAT(DISTINCT
       CONCAT(
         'max(IF(deskripsi= ''',
         deskripsi,
         ''', quantity, NULL)) AS ',
         REPLACE(REPLACE(REPLACE(deskripsi, ' ', '_'), '-','_'),'/','_')
       )
     ) INTO @sql
    FROM v_stockwip;

    SET @sql = CONCAT('CREATE TEMPORARY TABLE t1 (SELECT v_stockwip .customer,
                        v_stockwip.partnumber, v_stockwip.period, ', @sql, '
                        FROM v_stockwip WHERE v_stockwip.quantity > 0
                      GROUP BY v_stockwip.customer,v_stockwip.partnumber, v_stockwip.period)');

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    
    SELECT * FROM t1 WHERE period BETWEEN pDate1 and pDate2;
	Drop temporary table t1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ResetData` ()  BEGIN
	DELETE FROM t_pr01;
    DELETE FROM t_pr02;
    DELETE FROM t_po01;
    DELETE FROM t_po02;
    DELETE FROM t_reserv01;
    DELETE FROM t_reserv02;
    DELETE FROM t_invoice01;
    DELETE FROM t_invoice02;
    DELETE FROM t_inv_h;
    DELETE FROM t_inv_i;
    DELETE FROM t_ikpf;
    DELETE FROM t_iseg;
    DELETE FROM t_stock;
    DELETE FROM t_batch_stock;
    DELETE FROM t_service01;
    DELETE FROM t_service02;
    UPDATE t_nriv set currentnum = '' WHERE object in('GRPO','PR','PO','RSRV','BATCH','SERVICE','JURNAL','GROTHER');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ReverseStock` (IN `pKodebrg` VARCHAR(70), IN `pQuantity` DECIMAL(15,2), IN `pMvt` VARCHAR(5), IN `pWhs` VARCHAR(15), IN `pUnit` VARCHAR(15), IN `pWhsto` VARCHAR(15), IN `pShkzg` VARCHAR(1), IN `pResnum` VARCHAR(15), IN `pResitem` INT)  BEGIN
	DECLARE _ConvUom decimal(15,2);
    DECLARE currentqty bigint DEFAULT 0;
    DECLARE currentqty2 decimal(15,2) DEFAULT 0;
    DECLARE	_Inpqty decimal(15,2);
   
    
        SELECT convbase into _ConvUom from t_material2 where material = pKodebrg and altuom = pUnit;
        Select quantity INTO currentqty from t_stock WHERE material = pKodebrg and warehouse = pWhs limit 1;
        Select quantity INTO currentqty2 from t_stock WHERE material = pKodebrg and warehouse = pWhsto limit 1;

        set _Inpqty = pQuantity * _ConvUom; 

        if pMvt = '101' THEN    
            if currentqty != '' THEN
                UPDATE t_stock set quantity = currentqty - _Inpqty WHERE material = pKodebrg and warehouse = pWhs;
            end if; 

        elseif pMvt = '201' or pMvt = '211' THEN
        	if  pShkzg = '+' then
            	UPDATE t_stock set quantity = currentqty + _Inpqty WHERE material = pKodebrg and warehouse = pWhs;
            	UPDATE t_stock set quantity = currentqty2 - _Inpqty WHERE material = pKodebrg and warehouse = pWhsto;
                if pShkzg = '+' THEN
                	UPDATE t_reserv02 set movementstat = null WHERE resnum = pResnum and resitem = pResitem;
            	end if;    
        	end if; 
        elseif pMvt = '261' THEN
            UPDATE t_stock set quantity = currentqty + _Inpqty WHERE material = pKodebrg and warehouse = pWhs;
        end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TriggerMovement` (IN `pKodebrg` VARCHAR(15), IN `pWarehouse` VARCHAR(15), IN `pQuantity` DECIMAL(15,2), IN `pMvt` VARCHAR(15), IN `pUnit` VARCHAR(15), IN `pWarehouse2` VARCHAR(15), IN `pPonum` VARCHAR(25), IN `pPoitem` INT, IN `pRsnum` VARCHAR(15), IN `pRsitem` INT, IN `pGrnum` VARCHAR(15), IN `pYear` VARCHAR(5), IN `pGritem` INT, IN `pMatdesc` VARCHAR(40), IN `pShkzg` VARCHAR(1), IN `pRemark` TEXT, IN `pBatch` VARCHAR(20))  BEGIN
	
    call sp_UpdateStock(pKodebrg,pWarehouse,pQuantity,pMvt,pUnit,pWarehouse2,pShkzg,pBatch);
    
    if pMvt = '101' THEN
		call sp_updateGrPOStatus(pPonum,pPoitem,pQuantity);    
    ELSEIF pMvt = '201' THEN
    	UPDATE t_reserv02 set movementstat = 'X' WHERE resnum = pRsnum and resitem = pRsitem;
    end if;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateGrPOStatus` (IN `pPonum` VARCHAR(25), IN `pPoitem` INT, IN `pGrqty` DECIMAL(15,2))  BEGIN
	DECLARE totalgr decimal(15,2);
    DECLARE qtypo decimal(15,2);
    
    SELECT quantity INTO qtypo  FROM t_po02 WHERE ponum = pPonum and poitem = pPoitem;
    SELECT grqty INTO totalgr FROM t_po02 WHERE ponum = pPonum and poitem = pPoitem;
    
    set totalgr = totalgr + pGrqty;

    if totalgr = qtypo THEN
    	UPDATE t_po02 SET grqty = totalgr, grstatus = 'X' WHERE ponum = pPonum and poitem = pPoitem;
    else 
    	UPDATE t_po02 SET grqty = totalgr WHERE ponum = pPonum and poitem = pPoitem;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdatePRStatus` (IN `pPrnum` VARCHAR(15), IN `pPritem` INT)  BEGIN
	DECLARE prQty decimal(15,2);
    DECLARE poQty decimal(15,2);
    SELECT quantity into prQty from t_pr02 where prnum = pPrnum and pritem = pPritem;
    SELECT sum(quantity) into poQty from t_po02 where prnum = pPrnum and pritem = pPritem;
   
   IF poQty >= prQty then  
		UPDATE t_pr02 set pocreated = 'X' WHERE prnum = pPrnum AND pritem = pPritem;
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateStock` (IN `pKodebrg` VARCHAR(70), IN `pWarehouse` VARCHAR(15), IN `pQuantity` DECIMAL(15,2), IN `pMvt` VARCHAR(5), IN `pUnit` VARCHAR(5), IN `pWarehouseto` VARCHAR(15), IN `pShkzg` VARCHAR(1), IN `pBatch` VARCHAR(20))  BEGIN
	DECLARE currentqty decimal(15,2) DEFAULT 0;
    DECLARE _currentqty decimal(15,2) DEFAULT 0;
    DECLARE _bathqty decimal(15,2) DEFAULT 0;
    DECLARE _dstbathqty decimal(15,2) DEFAULT 0;
    DECLARE _altuom varchar(10);
    DECLARE _baseuom varchar(10);
    DECLARE	_uomconv decimal(15,2);
    DECLARE _inpqty decimal(15,2);
    
    SELECT altuom INTO _altuom from t_material2 where material = pKodebrg and altuom = pUnit;
    SELECT baseuom INTO _baseuom from t_material2 where material = pKodebrg and altuom = pUnit;
    
    SELECT convbase INTO _uomconv from t_material2 where material = pKodebrg and altuom = pUnit;
    
	Select quantity INTO currentqty from t_stock WHERE material = pKodebrg and warehouse = pWarehouse;
    Select quantity INTO _bathqty from t_batch_stock WHERE material = pKodebrg and warehouse = pWarehouse and batch = pBatch;
    
    set _inpqty = pQuantity * _uomconv;
        
    
    if pMvt = '101' or pMvt = '561' THEN    
    	INSERT INTO t_stock VALUES(pKodebrg, pWarehouse, _inpqty, 0) ON DUPLICATE KEY UPDATE quantity = currentqty + _inpqty, blockqty = 0;
    	INSERT INTO t_batch_stock VALUES(pKodebrg,pWarehouse,pBatch,_inpqty) ON DUPLICATE KEY UPDATE quantity = _bathqty + _inpqty;
    
    elseif pMvt = '201' and pShkzg = '+' THEN
    
    	UPDATE t_stock set quantity = currentqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse;
        UPDATE t_batch_stock set quantity = _bathqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse and batch = pBatch;
    	
    	Select quantity INTO _currentqty from t_stock WHERE material = pKodebrg and warehouse = pWarehouseto;
    	INSERT INTO t_stock VALUES(pKodebrg, pWarehouseto, _currentqty + _inpqty, 0) ON DUPLICATE KEY UPDATE quantity = _currentqty + _inpqty, blockqty = 0;
        
        Select quantity INTO _dstbathqty from t_batch_stock WHERE material = pKodebrg and warehouse = pWarehouseto and batch = pBatch;
        INSERT INTO t_batch_stock VALUES(pKodebrg,pWarehouseto,pBatch,_inpqty) ON DUPLICATE KEY UPDATE quantity = _dstbathqty + _inpqty;
        
     elseif pMvt = '211' and pShkzg = '+' THEN
    
    	UPDATE t_stock set quantity = currentqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse;
        UPDATE t_batch_stock set quantity = _bathqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse and batch = pBatch;
    	
        Select quantity INTO _currentqty from t_stock WHERE material = pKodebrg and warehouse = pWarehouseto;
    	INSERT INTO t_stock VALUES(pKodebrg, pWarehouseto, _currentqty + _inpqty, 0) ON DUPLICATE KEY UPDATE quantity = _currentqty + _inpqty, blockqty = 0;
     
     	Select quantity INTO _dstbathqty from t_batch_stock WHERE material = pKodebrg and warehouse = pWarehouseto and batch = pBatch;
        INSERT INTO t_batch_stock VALUES(pKodebrg,pWarehouseto,pBatch,_inpqty) ON DUPLICATE KEY UPDATE quantity = _dstbathqty + _inpqty;
     elseif pMvt = '261' THEN
    
    	UPDATE t_stock set quantity = currentqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse;
    	UPDATE t_batch_stock set quantity = _bathqty - _inpqty WHERE material = pKodebrg and warehouse = pWarehouse and batch = pBatch;
    	
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateStockWIP` (IN `pWIPType` VARCHAR(5), IN `pBomid` VARCHAR(30), IN `pQuantity` INT, IN `pFromarea` INT, IN `pToarea` INT, IN `pDate` DATE)  BEGIN
	DECLARE currentqty bigint DEFAULT 0;
    DECLARE _currentqty bigint DEFAULT 0;
    DECLARE inpqty decimal(15,2);
    DECLARE areaDesc varchar(200);
    
    if pWIPType = 'IN' THEN    
    	SELECT deskripsi INTO areaDesc FROM t_meja where nomeja = pFromarea;
        IF areaDesc != 'DELIVERY TO CUSTOMER' THEN
            Select quantity INTO currentqty from t_wip_stock WHERE bomid = pBomid and area = pFromarea;   
            INSERT INTO t_wip_stock VALUES(pFromarea, pBomid, pDate, pQuantity) 
            ON DUPLICATE KEY UPDATE period = pDate, quantity = currentqty + pQuantity;
        end if;
    elseif pWIPType = 'OUT' THEN
    	Select quantity INTO currentqty from t_wip_stock WHERE bomid = pBomid and area = pFromarea;   
    	UPDATE t_wip_stock set quantity = currentqty - pQuantity, period = pDate WHERE area = pFromarea and bomid = pBomid;
        
        /*Select quantity INTO _currentqty from t_wip_stock WHERE bomid = pBomid and area = pToarea;  
        INSERT INTO t_wip_stock VALUES(pToarea, pBomid, pDate, pQuantity) 
        ON DUPLICATE KEY UPDATE period = pDate, quantity = _currentqty + pQuantity; */
    end if;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fCheckPOIsGR` (`pPonum` VARCHAR(25)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT grnum from t_inv_i where ponum = pPonum limit 1);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fCheckPRIsPoCreated` (`pPrnum` VARCHAR(15)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT pocreated from t_pr02 where prnum = pPrnum and pocreated = 'X' limit 1);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fCurrencyConvertion` (`pFromCurr` VARCHAR(10), `pToCurr` VARCHAR(10)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT kurs2 from t_kurs where currency1 = pFromCurr and currency2 = pToCurr);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGeneratePONUM` (`pPonum` VARCHAR(15)) RETURNS VARCHAR(30) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(30);
    DECLARE currentMonth int;
    DECLARE smonth varchar(10);
    DECLARE extPonum varchar(25);
    DECLARE sYear bigint;
    
    set sYear = (SELECT date_format(now(),'%Y'));
    set currentMonth = month(now());

    if currentMonth = 1 THEN
        set smonth = 'I';
    ELSEIF currentMonth = 2 THEN
        set smonth = 'II';
    ELSEIF currentMonth = 3 THEN
        set smonth = 'III';
    ELSEIF currentMonth = 4 THEN
        set smonth = 'IV'; 
    ELSEIF currentMonth = 5 THEN
        set smonth = 'V';
    ELSEIF currentMonth = 6 THEN
        set smonth = 'IV';
    ELSEIF currentMonth = 7 THEN
        set smonth = 'VII';
    ELSEIF currentMonth = 8 THEN
        set smonth = 'VIII';
    ELSEIF currentMonth = 9 THEN
        set smonth = 'IX';
    ELSEIF currentMonth = 10 THEN
        set smonth = 'X';
    ELSEIF currentMonth = 11 THEN
        set smonth = 'XI';
    ELSEIF currentMonth = 12 THEN
        set smonth = ('XII');    
    END	if;
    
    set extPonum = CONCAT('AWSI/M-',pPonum,'/',smonth,'/',sYear);
	
    SET hasil = extPonum;
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetApproveDatePO` (`pPonum` VARCHAR(20)) RETURNS VARCHAR(20) CHARSET latin1 BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT approvedate from t_po02 where ponum = pPonum and final_approve = 'X' and approvestat not in('5','1') LIMIT 1);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetApproveDatePR` (`pPrnum` VARCHAR(20)) RETURNS VARCHAR(20) CHARSET latin1 BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT approvedate from t_pr02 where prnum = pPrnum and final_approve = 'X' and approvestat not in('5','1') LIMIT 1);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetAreaDesc` (`pArea` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT deskripsi from t_meja where nomeja = pArea);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetDepartment` (`pId` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT department from t_department where id = pId);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetJabatan` (`pId` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT jabatan from t_jabatan where id = pId);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetMaterialTotalStock` (`pMaterial` VARCHAR(70)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT sum(quantity) from t_stock where material = pMaterial);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetNamaUser` (`pUser` VARCHAR(50)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT nama from t_user where username = pUser);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetOpenPRQty` (`pPrnum` VARCHAR(20), `pPritem` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT sum(quantity) from t_po02 where prnum = pPrnum and pritem = pPritem);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetSaldo` (`_pBankno` VARCHAR(70)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(255);  
    SET hasil = (SELECT saldo FROM t_arus_kas where frombankacc = _pBankno order by transnum desc limit 1);  
    RETURN (hasil);  
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetTotalQtyDel` (`pBomid` VARCHAR(30), `pDate` DATE) RETURNS BIGINT(20) BEGIN
    DECLARE hasil bigint;
	
    if day(pDate) = 1 and month(pDate) = 1 THEN
    SET hasil = (SELECT sum(delqty) from t_delivery where bomid = pBomid and month(deliverydate) = 12 and year(deliverydate) = year(pDate)-1 and deliverydate < pDate );
    else
    	if day(pDate) = 1 THEN
        SET hasil = (SELECT sum(delqty) from t_delivery where bomid = pBomid and month(deliverydate) = month(pDate)-1 and year(deliverydate) = year(pDate) and deliverydate < pDate );
        else 
        SET hasil = (SELECT sum(delqty) from t_delivery where bomid = pBomid and month(deliverydate) = month(pDate) and year(deliverydate) = year(pDate) and deliverydate < pDate );
        end if;
    end if;
    	-- return the customer level
    if hasil is null THEN
   		set hasil = 0;
    end if;
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetTotalQtyReq` (`pBomid` VARCHAR(30), `pDate` DATE) RETURNS BIGINT(20) BEGIN
    DECLARE hasil bigint;
	
    if day(pDate) = 1 and month(pDate) = 1 THEN
    SET hasil = (SELECT sum(reqqty) from t_delivery where bomid = pBomid and month(deliverydate) = 12 and year(deliverydate) = year(pDate)-1 and deliverydate < pDate );
    else
    	if day(pDate) = 1 THEN
        SET hasil = (SELECT sum(reqqty) from t_delivery where bomid = pBomid and month(deliverydate) = month(pDate)-1 and year(deliverydate) = year(pDate) and deliverydate < pDate );
        else 
        SET hasil = (SELECT sum(reqqty) from t_delivery where bomid = pBomid and month(deliverydate) = month(pDate) and year(deliverydate) = year(pDate) and deliverydate < pDate );
        end if;
    end if;
    
    
    	-- return the customer level
    if hasil is null THEN
   		set hasil = 0;
    end if;
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetTotalValuePO` (`pPonum` VARCHAR(20)) RETURNS VARCHAR(20) CHARSET latin1 BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT sum(subtotal) from v_po004 where ponum = pPonum and paymentstat is null and approvestat <> 5);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetUserDepartment` (`pUsername` VARCHAR(50)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT deptname from v_user where username = pUsername);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetUserJabatan` (`pUsername` VARCHAR(50)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT jbtn from v_user where username = pUsername);
    	-- return the customer level
	RETURN (hasil);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fGetWarehouseName` (`pWhs` VARCHAR(15)) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
    DECLARE hasil VARCHAR(20);
	
    SET hasil = (SELECT deskripsi from t_gudang where gudang = pWhs);
    	-- return the customer level
	RETURN (hasil);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproject`
--

CREATE TABLE `tblproject` (
  `idproject` int(11) NOT NULL,
  `namaproject` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master Project';

--
-- Dumping data for table `tblproject`
--

INSERT INTO `tblproject` (`idproject`, `namaproject`, `status`, `createdby`, `createdon`) VALUES
(1, 'Project Test', 'Open', 'sys-admin', '2020-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `tblsetting`
--

CREATE TABLE `tblsetting` (
  `id` int(11) NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsetting`
--

INSERT INTO `tblsetting` (`id`, `company`, `address`, `createdby`) VALUES
(1, 'PT ABCDE', 'Jakarta', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_activity`
--

CREATE TABLE `t_activity` (
  `id` int(11) NOT NULL,
  `activity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycletime` decimal(8,2) NOT NULL,
  `cycvleunit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master Process Activity';

--
-- Dumping data for table `t_activity`
--

INSERT INTO `t_activity` (`id`, `activity`, `cycletime`, `cycvleunit`, `createdby`, `createdon`) VALUES
(1, 'Auto Cutting,Crimping,solder', '3.40', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(2, 'Auto Cutting, Crimping', '2.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(3, 'Auto Cutting,Crimping, Assy Wire Seal', '2.50', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(4, 'Auto Cutting\n ( Casting )', '2.68', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(5, 'Manual Cutting', '241.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(6, 'Manual Crimping', '4.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(7, 'Crimping Joint', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(8, 'Crimping Wire Seal', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(9, 'Crimping Balik \nWire Seal', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(10, 'Crimping Balik ', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(11, 'Double Crimping', '8.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(12, 'Triple Crimping', '9.40', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(13, 'Crimping PCS\'an', '8.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(14, 'Pasang Cover Terminal', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(15, 'Middle Stripping', '13.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(16, 'Pasang joint Caps', '4.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(17, 'Taping Joint', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(18, 'Pasang Sleeve', '3.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(19, 'Pasang Insulator', '2.20', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(20, 'Pasang Rubber \nSocket', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(21, 'Pasang Socket Body', '7.40', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(22, 'Proses Tarik Terminal', '2.80', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(23, 'Proses Heat Sealing', '12.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(24, 'Pasang Spring', '2.10', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(25, 'Spot Welidng', '13.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(26, 'Resistance Welding', '15.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(27, 'Pasang Gromet', '19.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(28, 'Pasang O Ring', '7.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(29, 'Dip Solder', '3.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(30, 'Solder Pen', '24.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(31, 'Slit Tube', '26.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(32, 'Cutting Tube \n(0-200) ', '4.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(33, 'Cutting Tube \n(200-600)', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(34, 'Cutting Tube\n (600-1000)', '7.30', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(35, 'Cutting Tube\n (1000-2000)', '8.30', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(36, 'Cutting Tube\n (2000-4000)', '43.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(37, 'Cutting Sumitube', '4.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(38, 'Assy Sumitube', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(39, 'Proses Heater', '23.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(40, 'Assy Coupler 1\n (Non WPC)', '1.50', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(41, 'Assy Coupler 2 \n( WPC)', '1.90', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(42, 'Assy Coupler 3 (Electronic)', '2.10', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(43, 'Assy Coupler 4\n (Insert Balik)', '2.30', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(44, 'Pasang Dummy Plug', '2.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(45, 'Assy Tube (0-600) ', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(46, 'Assy Tube (1000-2000) ', '15.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(47, 'Assy Tube (0-600) ', '7.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(48, 'Assy Tube (1000-2000) ', '23.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(49, 'Assy Tube (2000-4000) ', '129.80', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(50, 'Taping Spot', '7.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(51, 'Taping Spiral / Meter', '23.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(52, 'Roug Taping / Meter', '16.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(53, 'Assy Cover Coupler', '30.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(54, 'Assy Insulock', '20.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(55, 'Assy Clip Band', '12.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(56, 'Pasang Name Plate', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(57, 'Pasang Stiker', '7.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(58, 'Pasang Fuse', '3.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(59, 'Pasang Relay', '5.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(60, 'Checker', '7.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(61, 'Pemeriksaan Dimensi', '3.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(62, 'Pemeriksaan Visual', '2.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(63, 'Pemeriksaan DTD', '2.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(64, 'Marking LOT', '6.00', 'S', 'sys-admin', '2021-01-09 00:00:00'),
(65, 'Packing', '16.00', 'S', 'sys-admin', '2021-01-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_approval`
--

CREATE TABLE `t_approval` (
  `object` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `creator` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Mapping Approval PR PO';

--
-- Dumping data for table `t_approval`
--

INSERT INTO `t_approval` (`object`, `level`, `creator`, `approval`) VALUES
('PO', 1, 'adm-office', 'direktur'),
('PO', 1, 'sys-admin', 'direktur'),
('PR', 1, 'adm-ws', 'ka-adm-ws'),
('PR', 1, 'adm-ws1', 'ka-adm-ws'),
('PR', 1, 'adm-ws2', 'ka-adm-ws'),
('PR', 1, 'mekanik', 'ka-adm-ws'),
('PR', 1, 'sys-admin', 'ka-adm-ws'),
('PR', 2, 'adm-ws', 'direktur'),
('PR', 2, 'adm-ws1', 'direktur'),
('PR', 2, 'adm-ws2', 'direktur'),
('PR', 2, 'mekanik', 'direktur'),
('PR', 2, 'sys-admin', 'direktur');

-- --------------------------------------------------------

--
-- Table structure for table `t_arus_kas`
--

CREATE TABLE `t_arus_kas` (
  `transnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transdate` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `frombankacc` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tobankacc` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debet` decimal(13,2) NOT NULL,
  `kredit` decimal(13,2) NOT NULL,
  `saldo` decimal(13,2) NOT NULL,
  `efile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refdoc` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_arus_kas`
--

INSERT INTO `t_arus_kas` (`transnum`, `transdate`, `note`, `frombankacc`, `tobankacc`, `debet`, `kredit`, `saldo`, `efile`, `createdon`, `createdby`, `refdoc`) VALUES
('6000000000', '2021-03-06', 'Saldo Awal', '5204181811', '', '0.00', '100000000.00', '100000000.00', '', '2021-03-06', 'sys-admin', NULL),
('6000000001', '2021-03-06', 'Saldo Awal', '123456789', '', '0.00', '500000000.00', '500000000.00', '', '2021-03-06', 'sys-admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_auth_object`
--

CREATE TABLE `t_auth_object` (
  `ob_auth` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Authorization Object';

--
-- Dumping data for table `t_auth_object`
--

INSERT INTO `t_auth_object` (`ob_auth`, `description`, `createdon`, `createdby`) VALUES
('OB_MOVEMENT', 'Authorization Inventory Movement', '2020-12-25 00:00:00', 'sys-admin'),
('OB_WAREHOUSE', 'Authorization Warehouse', '2020-12-13 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_bank`
--

CREATE TABLE `t_bank` (
  `id` int(11) NOT NULL,
  `bankid` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankno` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankacc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_bank`
--

INSERT INTO `t_bank` (`id`, `bankid`, `bankno`, `bankacc`, `npwp`, `status`, `balance`, `user`, `createdon`) VALUES
(3, '002', '5204181811', 'HusnulM', '123456789099', '', NULL, NULL, '2021-03-27 03:54:09'),
(4, '008', '999999999', 'HusnulM', '45678902222', '', NULL, NULL, '2021-03-27 03:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `t_bank_list`
--

CREATE TABLE `t_bank_list` (
  `bankey` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_bank_list`
--

INSERT INTO `t_bank_list` (`bankey`, `deskripsi`) VALUES
('002', 'BANK BRI '),
('008', 'BANK MANDIRI '),
('009', 'BANK BNI '),
('011', 'BANK DANAMON '),
('014', 'BANK BCA '),
('022', 'BANK CIMB NIAGA '),
('110', 'BANK JABAR '),
('111', 'BANK DKI JAKARTA '),
('113', 'BANK JATENG (JAWA TENGAH) '),
('114', 'BANK JATIM (JAWA BARAT) '),
('153', 'BANK SINARMAS ');

-- --------------------------------------------------------

--
-- Table structure for table `t_batch_stock`
--

CREATE TABLE `t_batch_stock` (
  `material` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Batch Stock';

--
-- Dumping data for table `t_batch_stock`
--

INSERT INTO `t_batch_stock` (`material`, `warehouse`, `batch`, `quantity`) VALUES
('MAT0001', 'WH00', '7900000001', '145.00'),
('MAT0001', 'WH00', '7900000002', '100.00'),
('MAT0002', 'WH00', '7900000001', '60.00'),
('MAT0003', 'WH00', '7900000002', '100.00'),
('MAT0004', 'WH00', '7900000002', '50.00'),
('MAT0005', 'WH00', '7900000000', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `t_bom01`
--

CREATE TABLE `t_bom01` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partname` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtycct` decimal(15,2) DEFAULT NULL,
  `reference` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='BOM Header';

--
-- Dumping data for table `t_bom01`
--

INSERT INTO `t_bom01` (`bomid`, `partnumber`, `partname`, `customer`, `qtycct`, `reference`, `createdon`, `createdby`) VALUES
('1609630458', 'NL - 7421 B', 'LIGHTING WIRE', 'MINDA', '50.00', '', '2021-01-21 09:01:53', 'sys-admin'),
('1609656011', 'HARNESS GPS', 'Bering', 'MINDA', '20.00', 'XX-XX-XXX', '2021-01-03 07:01:11', 'sys-admin'),
('1609676821', 'TES', 'tes', 'tes', '30.00', 'XX-XX-XXX', '2021-01-03 01:01:01', 'sys-admin');

--
-- Triggers `t_bom01`
--
DELIMITER $$
CREATE TRIGGER `deletebomitem` AFTER DELETE ON `t_bom01` FOR EACH ROW DELETE FROM t_bom02 where bomid = OLD.bomid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_bom02`
--

CREATE TABLE `t_bom02` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `component` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `unit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table BOM';

--
-- Dumping data for table `t_bom02`
--

INSERT INTO `t_bom02` (`bomid`, `partnumber`, `component`, `quantity`, `unit`, `createdon`, `createdby`) VALUES
('1609630458', 'NL - 7421 B', 'BRI-05-BS-001', '1.00', 'Pcs', '2021-01-21 09:01:53', 'sys-admin'),
('1609630458', 'NL - 7421 B', 'COT-B', '2.00', 'Meter', '2021-01-21 09:01:53', 'sys-admin'),
('1609630458', 'NL - 7421 B', 'COT-B-DIA10.0', '3.00', 'Meter', '2021-01-21 09:01:53', 'sys-admin'),
('1609630458', 'NL - 7421 B', 'CY-C-3FK-110-NAT', '1.00', 'Pcs', '2021-01-21 09:01:53', 'sys-admin'),
('1609630458', 'NL - 7421 B', 'WIRE-AVSSF2.0W/B', '1.50', 'meter', '2021-01-21 09:01:53', 'sys-admin'),
('1609656011', 'HARNESS GPS', 'BRI-05-BS-001', '2.00', 'Pcs', '2021-01-03 07:01:11', 'sys-admin'),
('1609656011', 'HARNESS GPS', 'COT-B', '6.50', 'Meter', '2021-01-03 07:01:11', 'sys-admin'),
('1609676821', 'TES', 'BRI-05-BS-001', '2.00', 'Pcs', '2021-01-03 01:01:01', 'sys-admin'),
('1609676821', 'TES', 'COT-B-DIA10.0', '0.95', 'Meter', '2021-01-03 01:01:01', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_config01`
--

CREATE TABLE `t_config01` (
  `object` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_config01`
--

INSERT INTO `t_config01` (`object`, `value`, `createdby`, `createdon`) VALUES
('OB_UPAH_KERJA', '3900000', 'sys-admin', '2021-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `t_cost01`
--

CREATE TABLE `t_cost01` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_cost01`
--

INSERT INTO `t_cost01` (`bomid`, `partnumber`, `createdby`, `createdon`) VALUES
('1609630458', 'NL - 7421 B', 'sys-admin', '2021-01-10'),
('1609656011', 'HARNESS GPS', 'sys-admin', '2021-01-10');

--
-- Triggers `t_cost01`
--
DELIMITER $$
CREATE TRIGGER `deletecostitem` AFTER DELETE ON `t_cost01` FOR EACH ROW DELETE FROM t_cost02 where bomid = OLD.bomid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_cost02`
--

CREATE TABLE `t_cost02` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` int(11) NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_cost02`
--

INSERT INTO `t_cost02` (`bomid`, `activity`, `partnumber`, `quantity`) VALUES
('1609630458', 1, 'NL - 7421 B', '2.00'),
('1609630458', 6, 'NL - 7421 B', '1.00'),
('1609630458', 9, 'NL - 7421 B', '3.00'),
('1609630458', 10, 'NL - 7421 B', '4.00'),
('1609630458', 58, 'NL - 7421 B', '5.00'),
('1609656011', 1, 'HARNESS GPS', '2.00'),
('1609656011', 4, 'HARNESS GPS', '5.00'),
('1609656011', 8, 'HARNESS GPS', '4.00'),
('1609656011', 12, 'HARNESS GPS', '6.00');

-- --------------------------------------------------------

--
-- Table structure for table `t_currency`
--

CREATE TABLE `t_currency` (
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_currency`
--

INSERT INTO `t_currency` (`currency`, `description`) VALUES
('IDR', 'Indonesia Rupiah'),
('USD', 'United States Dollar');

-- --------------------------------------------------------

--
-- Table structure for table `t_defect_jenis`
--

CREATE TABLE `t_defect_jenis` (
  `idjenis` int(11) NOT NULL,
  `idsection` int(11) NOT NULL,
  `alfabet` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisdefect` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defect_jenis`
--

INSERT INTO `t_defect_jenis` (`idjenis`, `idsection`, `alfabet`, `jenisdefect`) VALUES
(1, 1, 'A', 'SALAH WIRE'),
(2, 1, 'B', 'SALAH TERMINAL'),
(3, 1, 'C', 'WIRE KEPANJANGAN'),
(4, 1, 'D', 'WIRE KEPENDEKAN'),
(5, 1, 'E', 'SALAH STANDARD CRIMPING'),
(6, 1, 'F', 'CORE TERPOTONG SEBAGIAN'),
(7, 1, 'G', 'CORE TERPOTONG SEMUA'),
(8, 1, 'H', 'TIDAK TERSTRIPING'),
(9, 1, 'I', 'CRIMPING TIDAK TERSTRIPING'),
(10, 1, 'J', 'STRIPING KEPANJANGAN'),
(11, 1, 'K', 'STRIPING KEPENDEKAN'),
(12, 1, 'L', 'BEND UP'),
(13, 1, 'M', 'BEND DOWN'),
(14, 1, 'N', 'FLASH KETINGGIAN/ BURRY'),
(15, 1, 'O', 'BELLMOUTH TIDAK STANDARD'),
(16, 1, 'P', 'CRIMPING TERLALU MAJU'),
(17, 1, 'Q', 'CRIMPING TERLALU MUNDUR'),
(18, 1, 'R', 'BRIDGE KASAR'),
(19, 1, 'S', 'TERMINAL MELINTIR'),
(20, 1, 'T', 'LUNCH TIDAK STANDAR'),
(21, 1, 'U', 'FRYING CORE'),
(22, 1, 'V', 'STRIPING TIDAK RATA'),
(23, 1, 'W', 'SOLDER BURAM'),
(24, 1, 'X', 'SOLDER MENGGUMPAL'),
(25, 1, 'Y', 'TIDAK TERSOLDER SEBAGIAN'),
(26, 1, 'Z', 'TIDAK TERSOLDER SEMUA'),
(27, 1, 'AA', 'INSULATION WIRE TERKELUPAS'),
(28, 1, 'AB', 'SALAH ARAH JOINT'),
(29, 1, 'AC', 'SALAH CIRCUIT JOINT'),
(30, 1, 'AD', 'KURANG CIRCUIT JOINT'),
(31, 1, 'AE', 'KELEBIHAN CIRCUIT JOINT'),
(32, 1, 'AF', 'SALAH ACCESSORIES'),
(43, 2, 'A', 'MISS INSERTION'),
(44, 2, 'B', 'TERMINAL PUSH OUT'),
(45, 2, 'C', 'TERMINAL DEFORMATION'),
(46, 2, 'E', 'CONNECTOR BROKEN'),
(47, 2, 'F', 'WIRE DEFECT'),
(48, 2, 'G', 'SEAL DEFECT'),
(49, 2, 'H', 'MISS INSERTION'),
(50, 2, 'I', 'TERMINAL PUSH OUT'),
(51, 2, 'J', 'TERMINAL DEFORMATION'),
(52, 2, 'K', 'CONNECTOR BROKEN'),
(53, 2, 'L', 'WIRE DEFECT'),
(54, 2, 'M', 'PART NG (COVER, SEAL DLL)'),
(55, 2, 'N', 'NAME PLATE'),
(56, 2, 'O', 'INSULOCK NG'),
(57, 2, 'P', 'TAPING NG'),
(58, 2, 'Q', 'TUBE NG'),
(59, 2, 'R', 'DIMENSI NG'),
(60, 2, 'S', 'NO TUBE'),
(61, 2, 'T', 'NO MARKING'),
(65, 3, 'A', 'MISS INSERTION'),
(66, 3, 'B', 'TERMINAL PUSH OUT'),
(67, 3, 'C', 'TERMINAL DEFORMATION'),
(68, 3, 'D', 'CONNECTOR BROKEN'),
(69, 3, 'E', 'WIRE DEFECT'),
(70, 3, 'F', 'SEAL DEFECT'),
(71, 4, 'A', 'MISS INSERTION'),
(72, 4, 'B', 'TERMINAL PUSH OUT'),
(73, 4, 'C', 'TERMINAL DEFORMATION'),
(74, 4, 'D', 'CONNECTOR BROKEN'),
(75, 4, 'E', 'WIRE DEFECT'),
(76, 4, 'F', 'PART NG (COVER, SEAL DLL)'),
(77, 4, 'G', 'NAME PLATE'),
(78, 4, 'H', 'INSULOCK NG'),
(79, 4, 'I', 'TAPING NG'),
(80, 4, 'J', 'TUBE NG'),
(81, 4, 'K', 'DIMENSI NG'),
(82, 4, 'L', 'NO TUBE');

-- --------------------------------------------------------

--
-- Table structure for table `t_defect_process`
--

CREATE TABLE `t_defect_process` (
  `idprocess` int(11) NOT NULL,
  `idsection` int(11) NOT NULL,
  `proses` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defect_process`
--

INSERT INTO `t_defect_process` (`idprocess`, `idsection`, `proses`) VALUES
(1, 1, 'Auto Cutting,Crimping,\nsolder'),
(2, 1, 'Auto Cutting, Crimping'),
(3, 1, 'Auto Cutting,Crimping, Assy Wire Seal'),
(4, 1, 'Auto Cutting\n ( Casting )'),
(5, 1, 'Manual Cutting'),
(6, 1, 'Manual Crimping'),
(7, 1, 'Crimping Joint'),
(8, 1, 'Crimping Wire Seal'),
(9, 1, 'Crimping Balik \nWire Seal'),
(10, 1, 'Crimping Balik '),
(11, 1, 'Double Crimping'),
(12, 1, 'Triple Crimping'),
(13, 1, 'Crimping PCS\'an'),
(14, 1, 'Pasang wire seal'),
(15, 1, 'Pasang Cover Terminal'),
(16, 1, 'Middle Stripping'),
(17, 1, 'Pasang joint Caps'),
(18, 1, 'Taping Joint'),
(19, 1, 'Pasang Sleeve'),
(20, 1, 'Pasang Insulator'),
(21, 1, 'Pasang Rubber \nSocket'),
(22, 1, 'Pasang Socket Body'),
(23, 1, 'Proses Tarik Terminal'),
(24, 1, 'Proses Heat Sealing'),
(25, 1, 'Pasang Spring'),
(26, 1, 'Spot Welidng'),
(27, 1, 'Resistance Welding'),
(28, 1, 'Pasang Gromet'),
(29, 1, 'Pasang O Ring'),
(30, 1, 'Proses tekuk cord'),
(31, 1, 'Dip Solder'),
(32, 1, 'Solder Pen'),
(33, 1, 'Cutting Tube \n(0-200) '),
(34, 1, 'Cutting Tube \n(200-600)'),
(35, 1, 'Cutting Tube\n (600-1000)'),
(36, 1, 'Cutting Tube\n (1000-2000)'),
(37, 1, 'Cutting Tube\n (2000-4000)'),
(38, 1, 'Cutting Sumitube'),
(39, 1, 'Assy Sumitube'),
(40, 1, 'Proses Heater'),
(41, 1, 'Slit Tube'),
(42, 1, 'Proses Bonding'),
(43, 2, 'Pasang PU Foam'),
(44, 2, 'Assy Coupler 1\n (Non WPC)'),
(45, 2, 'Assy Coupler 2 \n( WPC)'),
(46, 2, 'Assy Coupler 3 (Electronic)'),
(47, 2, 'Assy Coupler 4\n (Insert Balik)'),
(48, 2, 'Pasang Dummy Plug'),
(49, 2, 'Assy Tube (0-600) '),
(50, 2, 'Assy Tube (1000-2000) '),
(51, 2, 'Assy Tube (0-600) '),
(52, 2, 'Assy Tube (1000-2000) '),
(53, 2, 'Assy Tube (2000-4000) '),
(54, 2, 'Taping Spot'),
(55, 2, 'Taping Spiral / Meter'),
(56, 2, 'Roug Taping / Meter'),
(57, 2, 'Assy Cover Coupler'),
(58, 2, 'Assy Insulock'),
(59, 2, 'Assy Clip Band'),
(60, 2, 'Pasang Name Plate'),
(61, 2, 'Pasang Stiker'),
(62, 2, 'Pasang Fuse'),
(63, 2, 'Pasang Relay'),
(64, 2, 'Marking LOT'),
(65, 3, 'Checker'),
(66, 4, 'Pemeriksaan Dimensi'),
(67, 4, 'Pemeriksaan Visual'),
(68, 4, 'Pemeriksaan DTD'),
(69, 4, 'Proses tekuk wire'),
(70, 4, 'Packing');

-- --------------------------------------------------------

--
-- Table structure for table `t_defect_section`
--

CREATE TABLE `t_defect_section` (
  `id` int(11) NOT NULL,
  `section` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defect_section`
--

INSERT INTO `t_defect_section` (`id`, `section`, `createdon`, `createdby`) VALUES
(1, 'CUTTING, CRIMPING ACCESORIES, CUTTING TUBE', '2021-01-26', 'sys-admin'),
(2, 'HOUSING , ASSEMBLY', '2021-01-26', 'sys-admin'),
(3, 'CHECKER', '2021-01-26', 'sys-admin'),
(4, 'VISUAL', '2021-01-26', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_delivery`
--

CREATE TABLE `t_delivery` (
  `deliveryid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deltype` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdpack` int(11) DEFAULT NULL,
  `reqqty` int(11) DEFAULT NULL,
  `delqty` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `deliverydate` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_delivery`
--

INSERT INTO `t_delivery` (`deliveryid`, `bomid`, `partnumber`, `deltype`, `stdpack`, `reqqty`, `delqty`, `quantity`, `deliverydate`, `createdby`) VALUES
('1613176830', '1609630458', 'NL - 7421 B', 'REQ', 1000, 1500, 0, 1500, '2021-02-13', 'sys-admin'),
('1613176856', '1609630458', 'NL - 7421 B', 'REQ', 1000, 1500, 0, 1500, '2021-02-14', 'sys-admin'),
('1613176885', '1609630458', 'NL - 7421 B', 'DEL', 1000, 0, 3500, 3500, '2021-02-15', 'sys-admin'),
('1613176950', '1609630458', 'NL - 7421 B', 'REQ', 1000, 1500, 0, 1500, '2021-02-19', 'sys-admin'),
('1613179137', '1609676821', 'TES', 'REQ', 0, 1000, 0, 1000, '2021-02-13', 'sys-admin'),
('1613225848', '1609630458', 'NL - 7421 B', 'REQ', 750, 1000, 0, 1000, '2021-01-30', 'sys-admin'),
('1613226657', '1609630458', 'NL - 7421 B', 'REQ', 750, 1000, 0, 1000, '2021-02-01', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_department`
--

CREATE TABLE `t_department` (
  `id` int(11) NOT NULL,
  `department` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_department`
--

INSERT INTO `t_department` (`id`, `department`, `createdon`, `createdby`) VALUES
(1, 'Purchasing', '2020-12-13 03:12:31', 'sys-admin'),
(2, 'Finance', '2020-12-13 03:12:20', 'sys-admin'),
(3, 'Engineering', '2020-12-13 03:12:27', 'sys-admin'),
(4, 'Produksi', '2020-12-13 03:12:44', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_dept_section`
--

CREATE TABLE `t_dept_section` (
  `deptid` int(11) NOT NULL,
  `sectionid` int(11) NOT NULL,
  `deskripsi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_dept_section`
--

INSERT INTO `t_dept_section` (`deptid`, `sectionid`, `deskripsi`) VALUES
(1, 1, 'Engineering'),
(1, 2, 'Maintenance'),
(1, 3, 'Quality Ansurance'),
(2, 1, 'Production PP'),
(2, 2, 'Production Assy'),
(4, 1, 'Purchasing'),
(4, 2, 'Accounting'),
(4, 3, 'Warehouse'),
(5, 2, 'GA'),
(5, 3, 'Information & Technology'),
(5, 4, 'Driver'),
(5, 5, 'Umum');

-- --------------------------------------------------------

--
-- Table structure for table `t_files`
--

CREATE TABLE `t_files` (
  `object` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refdoc` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` int(11) NOT NULL,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filetype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filepath` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_files`
--

INSERT INTO `t_files` (`object`, `refdoc`, `item`, `filename`, `filetype`, `filepath`, `createdby`, `createdon`) VALUES
('PR', '[objectObject]', 1, 'Link Char SO.txt', 'txt', './images/prfiles/Link Char SO.txt', 'sys-admin', '2020-12-14'),
('PR', '1000000004', 1, 't_files.sql', 'sql', './images/prfiles/t_files.sql', 'sys-admin', '2020-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `t_gudang`
--

CREATE TABLE `t_gudang` (
  `plant` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master Gudang';

--
-- Dumping data for table `t_gudang`
--

INSERT INTO `t_gudang` (`plant`, `gudang`, `deskripsi`, `active`, `createdon`, `createdby`) VALUES
('1000', 'WH00', 'Warehouse Utama', 1, '2020-12-13 00:00:00', 'sys-admin'),
('1000', 'WH01', 'Warehouse 1', 1, '2020-12-13 00:00:00', 'sys-admin'),
('1000', 'WH02', 'Warehouse 2', 1, '2021-03-12 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_ikpf`
--

CREATE TABLE `t_ikpf` (
  `docnum` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Header History Update Stock';

-- --------------------------------------------------------

--
-- Table structure for table `t_inspection`
--

CREATE TABLE `t_inspection` (
  `id` int(11) NOT NULL,
  `lotng` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isnpecdate` date DEFAULT NULL,
  `inspector` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assyno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cctno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idsection` int(11) DEFAULT NULL,
  `process` int(11) DEFAULT NULL,
  `jumlahcheck` decimal(8,2) DEFAULT NULL,
  `nomeja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenisdefect` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlahng` int(11) DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_inspection`
--

INSERT INTO `t_inspection` (`id`, `lotng`, `isnpecdate`, `inspector`, `customer`, `operator`, `assyno`, `cctno`, `idsection`, `process`, `jumlahcheck`, `nomeja`, `jenisdefect`, `jumlahng`, `createdby`, `createdon`) VALUES
(14, 'LOT1234567', '2021-01-27', 'demo', 'ABC', 'Udi', '1234567', '1', 4, 67, '20.00', 'Crimping', '77', 80, 'sys-admin', '2021-01-27 02:01:48'),
(15, 'LOT1234569', '2021-01-27', 'demo', 'MINDA', 'Udin', '1234567', '1', 2, 61, '20.00', 'Team Maintenance', '50', 200, 'sys-admin', '2021-01-27 02:01:34'),
(16, 'LOT1234569', '2021-01-28', 'approval1', 'ABC', 'Udi', '11111', '1', 2, 53, '20.00', 'Assembly', '44', 150, 'sys-admin', '2021-01-27 02:01:17'),
(17, 'LOT1234569', '2021-01-28', 'approval1', 'ABC', 'Udi', '1234567', '1', 1, 12, '20.00', 'Auto Cutting', '12', 25, 'sys-admin', '2021-01-27 02:01:46'),
(18, 'LOT1234569', '2021-01-28', 'approval1', 'ABC', 'Admin', '1234567', '20', 3, 65, '20.00', '', '65', 10, 'sys-admin', '2021-01-28 08:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `t_invmvt`
--

CREATE TABLE `t_invmvt` (
  `movement` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorted` int(11) DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Inventory Movement Category';

--
-- Dumping data for table `t_invmvt`
--

INSERT INTO `t_invmvt` (`movement`, `description`, `sorted`, `createdon`, `createdby`) VALUES
('GR01', 'Goods Receipt PO', 1, '2020-12-25', 'sys-admin'),
('TF01', 'Transfer to Reservation', 5, '2020-12-25', 'sys-admin'),
('TF02', 'Transfer other', 5, '2020-12-25', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice01`
--

CREATE TABLE `t_invoice01` (
  `ivnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ivyear` int(11) NOT NULL,
  `vendor` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_invoice` decimal(15,2) DEFAULT NULL,
  `note` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankacc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ivdate` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `approvestat` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvedate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_invoice01`
--

INSERT INTO `t_invoice01` (`ivnum`, `ivyear`, `vendor`, `total_invoice`, `note`, `bankacc`, `ivdate`, `createdby`, `createdon`, `approvestat`, `approvedate`) VALUES
('5000000019', 2021, '3000000000', '1028500.00', 'Pembayaran PO', '5204181811', '2021-04-02', 'sys-admin', '2021-04-02', 'X', '2021-04-02'),
('5000000020', 2021, '3000000000', '174900.00', '', '999999999', '2021-04-02', 'sys-admin', '2021-04-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice02`
--

CREATE TABLE `t_invoice02` (
  `ivnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ivyear` int(11) NOT NULL,
  `ivitem` int(11) NOT NULL,
  `ponum` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poitem` int(11) DEFAULT NULL,
  `ivdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_invoice02`
--

INSERT INTO `t_invoice02` (`ivnum`, `ivyear`, `ivitem`, `ponum`, `poitem`, `ivdate`) VALUES
('5000000019', 2021, 1, '2000000000', 1, '2021-04-02'),
('5000000019', 2021, 2, '2000000000', 2, '2021-04-02'),
('5000000020', 2021, 1, '2000000001', 1, '2021-04-02'),
('5000000020', 2021, 2, '2000000001', 2, '2021-04-02');

--
-- Triggers `t_invoice02`
--
DELIMITER $$
CREATE TRIGGER `UpdatePoPaymentStat` AFTER INSERT ON `t_invoice02` FOR EACH ROW UPDATE t_po02 set paymentstat = 'O' WHERE ponum = NEW.ponum and poitem = NEW.poitem
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_inv_h`
--

CREATE TABLE `t_inv_h` (
  `grnum` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `movement` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movementdate` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `refnum` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table Header Penerimaan PO';

--
-- Dumping data for table `t_inv_h`
--

INSERT INTO `t_inv_h` (`grnum`, `year`, `movement`, `movementdate`, `note`, `refnum`, `createdon`, `createdby`) VALUES
('4000000000', '2021', '261', '2021-03-28', 'Service Kendaraan', 'SRV-8900000000', '2021-03-28', 'sys-admin'),
('4000000001', '2021', '101', '2021-04-02', 'Terima PO', NULL, '2021-04-02', 'sys-admin'),
('4000000002', '2021', '101', '2021-04-04', 'Terima Barang', NULL, '2021-04-02', 'sys-admin'),
('5100000000', '2021', '561', '2021-03-28', 'Test Update Stock', NULL, '2021-03-28', 'sys-admin'),
('6100000000', '2021', '261', '2021-04-02', 'Service Kendaraan Baru', 'SRV-8900000001', '2021-04-02', 'sys-admin');

--
-- Triggers `t_inv_h`
--
DELIMITER $$
CREATE TRIGGER `deletemovementitem` AFTER DELETE ON `t_inv_h` FOR EACH ROW DELETE FROM t_inv_i WHERE grnum = OLD.grnum and year = OLD.year
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_inv_i`
--

CREATE TABLE `t_inv_i` (
  `grnum` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gritem` int(11) NOT NULL,
  `movement` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batchnumber` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `ponum` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poitem` int(11) DEFAULT NULL,
  `resnum` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resitem` int(11) DEFAULT NULL,
  `cancel` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `warehouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouseto` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shkzg` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table Detail Inventory Movements';

--
-- Dumping data for table `t_inv_i`
--

INSERT INTO `t_inv_i` (`grnum`, `year`, `gritem`, `movement`, `batchnumber`, `material`, `matdesc`, `quantity`, `unit`, `price`, `ponum`, `poitem`, `resnum`, `resitem`, `cancel`, `remark`, `warehouse`, `warehouseto`, `shkzg`, `createdon`, `createdby`) VALUES
('4000000000', '2021', 1, '261', '7900000000', 'MAT0005', 'AKI Bekas', '2.00', 'PC', '50000.00', NULL, NULL, 'SRV-8900000000', 1, NULL, NULL, 'WH00', '', '+', '2021-03-28', 'sys-admin'),
('4000000001', '2021', 1, '101', '7900000001', 'MAT0001', 'Material 001', '150.00', 'PC', '4583.33', '2000000000', 1, NULL, NULL, NULL, '', 'WH00', NULL, '+', '2021-04-02', 'sys-admin'),
('4000000001', '2021', 2, '101', '7900000001', 'MAT0002', 'Material 002', '70.00', 'PC', '4871.43', '2000000000', 2, NULL, NULL, NULL, '', 'WH00', NULL, '+', '2021-04-02', 'sys-admin'),
('4000000002', '2021', 1, '101', '7900000002', 'MAT0001', 'Material 001', '100.00', 'PC', '750.00', '2000000001', 1, NULL, NULL, NULL, '', 'WH00', NULL, '+', '2021-04-02', 'sys-admin'),
('4000000002', '2021', 2, '101', '7900000002', 'MAT0003', 'Material 003', '100.00', 'PC', '999.00', '2000000001', 2, NULL, NULL, NULL, '', 'WH00', NULL, '+', '2021-04-02', 'sys-admin'),
('4000000002', '2021', 3, '101', '7900000002', 'MAT0004', 'Material 004', '50.00', 'PC', '1500.00', '2000000001', 3, NULL, NULL, NULL, '', 'WH00', NULL, '+', '2021-04-02', 'sys-admin'),
('5100000000', '2021', 1, '561', '7900000000', 'MAT0005', 'AKI Bekas', '5.00', 'PC', '50000.00', NULL, NULL, NULL, NULL, NULL, 'Aki Bekas', 'WH00', NULL, '+', '2021-03-28', 'sys-admin'),
('6100000000', '2021', 1, '261', '7900000001', 'MAT0001', 'Material 001', '5.00', 'PC', '4583.33', NULL, NULL, 'SRV-8900000001', 1, NULL, NULL, 'WH00', '', '+', '2021-04-02', 'sys-admin'),
('6100000000', '2021', 2, '261', '7900000001', 'MAT0002', 'Material 002', '10.00', 'PC', '4871.43', NULL, NULL, 'SRV-8900000001', 2, NULL, NULL, 'WH00', '', '+', '2021-04-02', 'sys-admin'),
('6100000000', '2021', 3, '261', '7900000000', 'MAT0005', 'AKI Bekas', '1.00', 'PC', '50000.00', NULL, NULL, 'SRV-8900000001', 3, NULL, NULL, 'WH00', '', '+', '2021-04-02', 'sys-admin');

--
-- Triggers `t_inv_i`
--
DELIMITER $$
CREATE TRIGGER `reversestock` AFTER DELETE ON `t_inv_i` FOR EACH ROW call sp_ReverseStock(OLD.material, OLD.quantity,OLD.movement,OLD.warehouse,OLD.unit,OLD.warehouseto,old.shkzg,OLD.resnum,OLD.resitem)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `setPriceIM` BEFORE INSERT ON `t_inv_i` FOR EACH ROW if NEW.movement = '101' THEN
SET NEW.price = (SELECT unitprice FROM v_po004 WHERE ponum = NEW.ponum and poitem = NEW.poitem);
ELSEIF NEW.movement = '261' THEN
SET NEW.price = (SELECT price FROM t_inv_i WHERE material = NEW.material and batchnumber = NEW.batchnumber and movement in('101','561'));
end if
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatestock` AFTER INSERT ON `t_inv_i` FOR EACH ROW call sp_TriggerMovement(new.material, new.warehouse, new.quantity, new.movement, new.unit,new.warehouseto,new.ponum,new.poitem,new.resnum,new.resitem,new.grnum,new.year,new.gritem,new.matdesc,new.shkzg,new.remark,new.batchnumber)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_iseg`
--

CREATE TABLE `t_iseg` (
  `docnum` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `docitem` int(11) NOT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `old_qty` decimal(15,2) DEFAULT NULL,
  `unit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `warehouse` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table Item History Update Stock';

--
-- Triggers `t_iseg`
--
DELIMITER $$
CREATE TRIGGER `UpdateStockAfterInsert` AFTER INSERT ON `t_iseg` FOR EACH ROW INSERT INTO t_stock(material,warehouse,quantity)
		VALUES(NEW.material,NEW.warehouse,NEW.quantity)
		ON DUPLICATE KEY UPDATE quantity=NEW.quantity
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `setOldQty` BEFORE INSERT ON `t_iseg` FOR EACH ROW SET NEW.old_qty = (SELECT quantity FROM t_stock WHERE material = NEW.material and warehouse = NEW.warehouse)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_jabatan`
--

CREATE TABLE `t_jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_jabatan`
--

INSERT INTO `t_jabatan` (`id`, `jabatan`, `createdon`, `createdby`) VALUES
(1, 'Admin', '2020-12-23 00:00:00', 'sys-admin'),
(2, 'Staff', '2020-12-23 00:00:00', 'sys-admin'),
(3, 'Supervisor', '0000-00-00 00:00:00', ''),
(4, 'Asisten Manager', '0000-00-00 00:00:00', ''),
(5, 'Manager', '0000-00-00 00:00:00', ''),
(6, 'Direktur', '0000-00-00 00:00:00', ''),
(7, 'Presiden Direktur', '0000-00-00 00:00:00', ''),
(8, 'Komisioner', '2020-12-29 00:00:00', 'sys-admin'),
(9, 'Mekanik', '2020-12-23 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_jenis_defect`
--

CREATE TABLE `t_jenis_defect` (
  `id` int(11) NOT NULL,
  `defect` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_jenis_defect`
--

INSERT INTO `t_jenis_defect` (`id`, `defect`, `createdon`, `createdby`) VALUES
(1, 'SALAH WIRE', '2021-01-18', 'sys-admin'),
(2, 'SALAH TERMINAL', '2021-01-18', 'sys-admin'),
(3, 'WIRE KEPANJANGAN', '2021-01-18', 'sys-admin'),
(4, 'WIRE KEPENDEKAN', '2021-01-18', 'sys-admin'),
(5, 'SALAH STANDARD CRIMPING', '2021-01-18', 'sys-admin'),
(6, 'CORE TERPOTONG SEBAGIAN', '2021-01-18', 'sys-admin'),
(7, 'CORE TERPOTONG SEMUA', '2021-01-18', 'sys-admin'),
(8, 'TIDAK TERSTRIPING', '2021-01-18', 'sys-admin'),
(9, 'CRIMPING TIDAK TERSTRIPING', '2021-01-18', 'sys-admin'),
(10, 'STRIPING KEPANJANGAN', '2021-01-18', 'sys-admin'),
(11, 'STRIPING KEPENDEKAN', '2021-01-18', 'sys-admin'),
(12, 'BEND UP', '2021-01-18', 'sys-admin'),
(13, 'BEND DOWN', '2021-01-18', 'sys-admin'),
(14, 'FLASH KETINGGIAN/ BURRY', '2021-01-18', 'sys-admin'),
(15, 'BELLMOUTH TIDAK STANDARD', '2021-01-18', 'sys-admin'),
(16, 'CRIMPING TERLALU MAJU', '2021-01-18', 'sys-admin'),
(17, 'CRIMPING TERLALU MUNDUR', '2021-01-18', 'sys-admin'),
(18, 'BRIDGE KASAR', '2021-01-18', 'sys-admin'),
(19, 'TERMINAL MELINTIR', '2021-01-18', 'sys-admin'),
(20, 'LUNCH TIDAK STANDAR', '2021-01-18', 'sys-admin'),
(21, 'FRYING CORE', '2021-01-18', 'sys-admin'),
(22, 'STRIPING TIDAK RATA', '2021-01-18', 'sys-admin'),
(23, 'SOLDER BURAM', '2021-01-18', 'sys-admin'),
(24, 'SOLDER MENGGUMPAL', '2021-01-18', 'sys-admin'),
(25, 'TIDAK TERSOLDER SEBAGIAN', '2021-01-18', 'sys-admin'),
(26, 'TIDAK TERSOLDER SEMUA', '2021-01-18', 'sys-admin'),
(27, 'INSULATION WIRE TERKELUPAS', '2021-01-18', 'sys-admin'),
(28, 'SALAH ARAH JOINT', '2021-01-18', 'sys-admin'),
(29, 'SALAH CIRCUIT JOINT', '2021-01-18', 'sys-admin'),
(30, 'KURANG CIRCUIT JOINT', '2021-01-18', 'sys-admin'),
(31, 'KELEBIHAN CIRCUIT JOINT', '2021-01-18', 'sys-admin'),
(32, 'SALAH ACCESSORIES', '2021-01-18', 'sys-admin'),
(33, 'MISS INSERTION', '2021-01-18', 'sys-admin'),
(34, 'TERMINAL PUSH OUT', '2021-01-18', 'sys-admin'),
(35, 'TERMINAL DEFORMATION', '2021-01-18', 'sys-admin'),
(36, 'CONNECTOR BROKEN', '2021-01-18', 'sys-admin'),
(37, 'WIRE DEFECT', '2021-01-18', 'sys-admin'),
(38, 'SEAL DEFECT', '2021-01-18', 'sys-admin'),
(39, 'MISS INSERTION', '2021-01-18', 'sys-admin'),
(40, 'TERMINAL PUSH OUT', '2021-01-18', 'sys-admin'),
(41, 'TERMINAL DEFORMATION', '2021-01-18', 'sys-admin'),
(42, 'CONNECTOR BROKEN', '2021-01-18', 'sys-admin'),
(43, 'WIRE DEFECT', '2021-01-18', 'sys-admin'),
(44, 'PART NG (COVER, SEAL DLL)', '2021-01-18', 'sys-admin'),
(45, 'NAME PLATE', '2021-01-18', 'sys-admin'),
(46, 'INSULOCK NG', '2021-01-18', 'sys-admin'),
(47, 'TAPING NG', '2021-01-18', 'sys-admin'),
(48, 'TUBE NG', '2021-01-18', 'sys-admin'),
(49, 'DIMENSI NG', '2021-01-18', 'sys-admin'),
(50, 'NO TUBE', '2021-01-18', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_kurs`
--

CREATE TABLE `t_kurs` (
  `currency1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurs1` decimal(15,2) NOT NULL,
  `currency2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurs2` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_kurs`
--

INSERT INTO `t_kurs` (`currency1`, `kurs1`, `currency2`, `kurs2`) VALUES
('IDR', '14500.00', 'USD', '1.00'),
('USD', '1.00', 'IDR', '15000.00');

-- --------------------------------------------------------

--
-- Table structure for table `t_lockdata`
--

CREATE TABLE `t_lockdata` (
  `object` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `docnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lockby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appmenu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_mapp_user_reffid`
--

CREATE TABLE `t_mapp_user_reffid` (
  `reffid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_mapp_user_reffid`
--

INSERT INTO `t_mapp_user_reffid` (`reffid`, `username`, `createdon`, `createdby`) VALUES
('6160761', 'sys-admin', '2021-02-28', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_material`
--

CREATE TABLE `t_material` (
  `material` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mattype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matgroup` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnumber` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matunit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minstock` decimal(15,2) DEFAULT NULL,
  `orderunit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdprice` decimal(15,2) DEFAULT NULL,
  `stdpriceusd` decimal(15,4) DEFAULT '0.0000',
  `active` tinyint(1) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Master';

--
-- Dumping data for table `t_material`
--

INSERT INTO `t_material` (`material`, `matdesc`, `mattype`, `matgroup`, `partname`, `partnumber`, `color`, `size`, `matunit`, `minstock`, `orderunit`, `stdprice`, `stdpriceusd`, `active`, `createdon`, `createdby`) VALUES
('MAT0001', 'Material 001', 'PART', NULL, 'Bering', '0334-028', 'Black', '10\'', 'PC', '50.00', 'BOX', '0.00', '0.0000', 1, '2021-03-04 02:03:44', 'sys-admin'),
('MAT0002', 'Material 002', 'PART', NULL, 'Baut', 'B-132', 'Green', '6\'', 'PC', '50.00', 'PC', '0.00', '0.0000', 1, '2021-03-04 03:03:38', 'sys-admin'),
('MAT0003', 'Material 003', 'PART', NULL, 'Test Part', '12345', 'Black', '6\'', 'PC', '20.00', 'PC', '0.00', '0.0000', 1, '2021-03-04 03:03:32', 'sys-admin'),
('MAT0004', 'Material 004', 'PART', NULL, 'Baut14', 'BT-014', NULL, NULL, 'PC', '0.00', 'PC', '0.00', '0.0000', 1, '2021-03-07 02:03:39', 'sys-admin'),
('MAT0005', 'AKI Bekas', 'PART', NULL, '-', '-', NULL, NULL, 'PC', '0.00', 'PC', '0.00', '0.0000', 1, '2021-03-27 10:03:18', 'sys-admin');

--
-- Triggers `t_material`
--
DELIMITER $$
CREATE TRIGGER `DELETE_MATERIAL` AFTER DELETE ON `t_material` FOR EACH ROW DELETE FROM t_material2 where material = OLD.material
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `INSERT_TO_ALT_UOM` AFTER INSERT ON `t_material` FOR EACH ROW INSERT INTO t_material2 VALUES(NEW.material,NEW.matunit,1,NEW.matunit,1,NEW.createdon,NEW.createdby)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_material2`
--

CREATE TABLE `t_material2` (
  `material` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `altuom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `convalt` decimal(15,2) NOT NULL,
  `baseuom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `convbase` decimal(15,2) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Alternative UOM';

--
-- Dumping data for table `t_material2`
--

INSERT INTO `t_material2` (`material`, `altuom`, `convalt`, `baseuom`, `convbase`, `createdon`, `createdby`) VALUES
('MAT0001', 'PC', '1.00', 'PC', '1.00', '2021-03-04 02:03:44', 'sys-admin'),
('MAT0002', 'PC', '1.00', 'PC', '1.00', '2021-03-04 03:03:38', 'sys-admin'),
('MAT0003', 'PC', '1.00', 'PC', '1.00', '2021-03-04 03:03:32', 'sys-admin'),
('MAT0004', 'PC', '1.00', 'PC', '1.00', '2021-03-07 02:03:39', 'sys-admin'),
('MAT0005', 'PC', '1.00', 'PC', '1.00', '2021-03-27 10:03:18', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_materialtype`
--

CREATE TABLE `t_materialtype` (
  `mattype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mattypedesc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Type';

--
-- Dumping data for table `t_materialtype`
--

INSERT INTO `t_materialtype` (`mattype`, `mattypedesc`, `createdon`, `createdby`) VALUES
('FGD', 'Finish Goods', '2020-12-05 00:00:00', 'Admin'),
('PART', 'Sparepart', '2020-12-05 00:00:00', 'Admin'),
('RAW', 'Raw Material', '2020-12-05 00:00:00', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_meja`
--

CREATE TABLE `t_meja` (
  `nomeja` int(11) NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_meja`
--

INSERT INTO `t_meja` (`nomeja`, `deskripsi`, `createdon`, `createdby`) VALUES
(1, 'Auto Cutting', '2021-01-19', 'sys-admin'),
(2, 'Crimping', '2021-01-19', 'sys-admin'),
(3, 'Assembly', '2021-01-19', 'sys-admin'),
(4, 'CHECKER-VISUAL', '2021-01-24', 'sys-admin'),
(5, 'GUDANG F/G', '2021-01-24', 'sys-admin'),
(6, 'DELIVERY TO CUSTOMER', '2021-01-26', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_menus`
--

CREATE TABLE `t_menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grouping` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Application Menus';

--
-- Dumping data for table `t_menus`
--

INSERT INTO `t_menus` (`id`, `menu`, `route`, `type`, `icon`, `grouping`, `createdon`, `createdby`) VALUES
(1, 'Master Material', 'material', 'parent', '', 'master', '2020-11-26 00:00:00', 'Admin'),
(2, 'Master Type Material', 'materialtype', 'parent', '', 'master', '2020-11-26 00:00:00', ''),
(3, 'Vendor Master', 'vendor', 'parent', '', 'master', '2020-12-07 00:00:00', 'sys-admin'),
(4, 'Warehouse Master', 'warehouse', 'parent', '', 'master', '2020-12-07 00:00:00', 'sys-admin'),
(5, 'Department Master', 'department', 'parent', '', 'master', '2020-12-12 00:00:00', 'sys-admin'),
(6, 'Project Master', 'project', 'parent', '', 'master', '2020-12-12 00:00:00', 'sys-admin'),
(7, 'Create Purchase Requisition', 'pr', 'parent', '', 'transaction', '2020-12-10 00:00:00', 'sys-admin'),
(8, 'Create Purchase Order', 'po', 'parent', '', 'transaction', '2020-12-10 00:00:00', 'sys-admin'),
(9, 'Create Payment Request', 'payment', 'parent', '', 'transaction', '2020-12-10 00:00:00', 'sys-admin'),
(10, 'Create Reservation', 'reservation', 'parent', '', 'transaction', '2020-12-12 00:00:00', 'sys-admin'),
(11, 'Report Purchase Requisition', 'reports/reportpr', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(12, 'Report Purchase Order', 'reports/reportpo', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(13, 'Report Service', 'reports/rservice', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(14, 'Report Reservasi', 'reports/reservasi', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(15, 'Report Inventory Movement', 'reports/movement', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(16, 'Report Summary Stock', 'reports/stock', 'parent', '', 'report', '2020-12-12 00:00:00', 'sys-admin'),
(17, 'User Data', 'user', 'parent', '', 'setting', '2020-12-07 00:00:00', 'sys-admin'),
(18, 'Role', 'role', 'parent', '', 'setting', '2020-12-12 00:00:00', 'sys-admin'),
(19, 'Application Menu', 'menu', 'parent', '', 'setting', '2020-12-07 00:00:00', 'Admin'),
(20, 'Assign Menu to Role', 'menurole', 'parent', '', 'setting', '2020-12-07 00:00:00', 'sys-admin'),
(21, 'Assignment User to Role', 'userrole', 'parent', '', 'setting', '2020-12-07 00:00:00', 'sys-admin'),
(22, 'Object Authorization', 'objauth', 'parent', '', 'setting', '2020-12-12 00:00:00', 'sys-admin'),
(23, 'Approve PR', 'approvepr', 'parent', '', 'transaction', '2020-12-22 00:00:00', 'sys-admin'),
(24, 'Approve PO', 'approvepo', 'parent', '', 'transaction', '2020-12-22 00:00:00', 'sys-admin'),
(25, 'Create Service Order', 'service', 'parent', '', 'transaction', '2021-03-08 00:00:00', 'sys-admin'),
(26, 'Inventory Movement', 'movement', 'parent', '', 'transaction', '2020-12-26 00:00:00', 'sys-admin'),
(27, 'Mapping Approval', 'approval', 'parent', '', 'setting', '2020-12-29 00:00:00', 'sys-admin'),
(28, 'Reset Data', 'reset', 'parent', '', 'setting', '2021-01-01 00:00:00', 'sys-admin'),
(29, 'Cancel Approve PR', 'unrelease/unreleasepr', 'parent', '', 'transaction', '2021-01-02 00:00:00', 'sys-admin'),
(30, 'Cancel Approve PO', 'unrelease/unreleasepo', 'parent', '', 'transaction', '2021-01-02 00:00:00', 'sys-admin'),
(31, 'Approve Payment', 'approvepayment', 'parent', '', 'transaction', '2021-01-02 00:00:00', 'sys-admin'),
(33, 'Report Batch Stock', 'reports/batchstock', 'parent', '', 'report', '2021-01-08 00:00:00', 'sys-admin'),
(48, 'Report Cost Analysis', 'reports/rcost', 'parent', '', 'report', '2021-03-05 00:00:00', 'sys-admin'),
(49, 'General Setting', 'generalsetting', 'parent', '', 'setting', '2021-03-06 00:00:00', 'sys-admin'),
(50, 'Master Bank', 'bank', 'parent', '', 'master', '2021-03-06 00:00:00', 'sys-admin'),
(52, 'Service Order Confirmation', 'service/confirm', 'parent', '', 'transaction', '2021-03-09 00:00:00', 'sys-admin'),
(53, 'Approve Reservation', 'approveservation', 'parent', '', 'transaction', '2021-03-10 00:00:00', 'sys-admin'),
(54, 'Report Payment', 'reports/payment', 'parent', '', 'report', '2021-03-19 00:00:00', 'sys-admin'),
(55, 'Update Stock', 'updatestock', 'parent', '', 'transaction', '2021-03-26 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_nriv`
--

CREATE TABLE `t_nriv` (
  `object` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fromnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tonumber` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currentnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_nriv`
--

INSERT INTO `t_nriv` (`object`, `fromnum`, `tonumber`, `currentnum`) VALUES
('BARANG', '1000000000', '1999999999', ''),
('BATCH', '7900000000', '7999999999', '7900000003'),
('GI', '6100000000', '6999999999', '6100000001'),
('GROTHER', '5100000000', '5999999999', '5100000001'),
('GRPO', '4000000000', '4999999999', '4000000003'),
('IV', '5000000000', '5999999999', '5000000021'),
('JURNAL', '6000000000', '6999999999', ''),
('PO', '2000000000', '2999999999', '2000000002'),
('PR', '1000000000', '3999999999', '1000000002'),
('PR2', '2000000000', '3999999999', '2000000001'),
('PR3', '3000000000', '3999999999', '3000000001'),
('RSRV', '4000000000', '4999999999', ''),
('SERVICE', '8900000000', '8999999999', '8900000002'),
('VENDOR', '3000000000', '3999999999', '3000000001');

-- --------------------------------------------------------

--
-- Table structure for table `t_part_image`
--

CREATE TABLE `t_part_image` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagelink` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_part_image`
--

INSERT INTO `t_part_image` (`bomid`, `partnumber`, `imagelink`, `createdby`, `createdon`) VALUES
('1609630458', 'NL - 7421 B', 'https://awsi.co.id/WOS/var/albums/DRAWING-VISUAL/drawing%20visual%200871.PNG?m=1614306860', '2021-02-26', '0000-00-00'),
('1609656011', 'HARNESS GPS', 'https://awsi.co.id/WOS/var/albums/DRAWING-VISUAL/drawing%20visual%200871.PNG?m=1614306860', '2021-02-26', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `t_plant`
--

CREATE TABLE `t_plant` (
  `plant` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master Plant';

-- --------------------------------------------------------

--
-- Table structure for table `t_po01`
--

CREATE TABLE `t_po01` (
  `ponum` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_ponum` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `potype` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `podat` date DEFAULT NULL,
  `vendor` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvestat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Purchase Order Header';

--
-- Dumping data for table `t_po01`
--

INSERT INTO `t_po01` (`ponum`, `ext_ponum`, `potype`, `podat`, `vendor`, `note`, `currency`, `approvestat`, `appby`, `completed`, `warehouse`, `createdon`, `createdby`) VALUES
('2000000000', '2000000000', 'PO01', '2021-03-30', '3000000000', 'PO Pertama', 'IDR', '1', NULL, NULL, 'WH00', '2021-03-30 09:03:51', 'sys-admin'),
('2000000001', '2000000001', 'PO01', '2021-04-02', '3000000000', 'Test PO', 'IDR', '1', NULL, NULL, 'WH00', '2021-04-02 01:04:18', 'sys-admin');

--
-- Triggers `t_po01`
--
DELIMITER $$
CREATE TRIGGER `deleteitem` AFTER DELETE ON `t_po01` FOR EACH ROW DELETE FROM t_po02 WHERE ponum = OLD.ponum
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_po02`
--

CREATE TABLE `t_po02` (
  `ponum` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poitem` int(11) NOT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT NULL,
  `grqty` decimal(15,2) DEFAULT NULL,
  `prnum` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pritem` int(11) DEFAULT NULL,
  `grstatus` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pocomplete` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentstat` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvestat` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvedby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_approve` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvedate` date DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='PO Item';

--
-- Dumping data for table `t_po02`
--

INSERT INTO `t_po02` (`ponum`, `poitem`, `material`, `matdesc`, `quantity`, `unit`, `price`, `ppn`, `discount`, `grqty`, `prnum`, `pritem`, `grstatus`, `pocomplete`, `paymentstat`, `approvestat`, `approvedby`, `final_approve`, `approvedate`, `createdon`, `createdby`) VALUES
('2000000000', 1, 'MAT0001', 'Material 001', '150.00', 'PC', '4500.00', 10, '50000.00', '150.00', NULL, NULL, 'X', NULL, 'X', '2', 'direktur', 'X', '2021-04-02', '2021-03-30', 'sys-admin'),
('2000000000', 2, 'MAT0002', 'Material 002', '70.00', 'PC', '5500.00', 10, '75000.00', '70.00', NULL, NULL, 'X', NULL, 'X', '2', 'direktur', 'X', '2021-04-02', '2021-03-30', 'sys-admin'),
('2000000001', 1, 'MAT0001', 'Material 001', '100.00', 'PC', '750.00', 0, '0.00', '100.00', '1000000000', 1, 'X', NULL, 'O', '2', 'direktur', 'X', '2021-04-02', '2021-04-02', 'sys-admin'),
('2000000001', 2, 'MAT0003', 'Material 003', '100.00', 'PC', '999.00', 0, '0.00', '100.00', '1000000001', 1, 'X', NULL, 'O', '2', 'direktur', 'X', '2021-04-02', '2021-04-02', 'sys-admin'),
('2000000001', 3, 'MAT0004', 'Material 004', '50.00', 'PC', '1500.00', 0, '0.00', '50.00', '1000000001', 2, 'X', NULL, NULL, '5', 'direktur', 'X', '2021-04-02', '2021-04-02', 'sys-admin');

--
-- Triggers `t_po02`
--
DELIMITER $$
CREATE TRIGGER `UpdatePRStatus` AFTER INSERT ON `t_po02` FOR EACH ROW CALL sp_UpdatePRStatus(NEW.prnum,NEW.pritem)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteitempo` AFTER DELETE ON `t_po02` FOR EACH ROW UPDATE t_pr02 set pocreated = NULL WHERE prnum = OLD.prnum AND pritem = OLD.pritem
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_pr01`
--

CREATE TABLE `t_pr01` (
  `prnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typepr` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `prdate` date DEFAULT NULL,
  `relgroup` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvestat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idproject` int(11) DEFAULT NULL,
  `appby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Purchase Requisition Header';

--
-- Dumping data for table `t_pr01`
--

INSERT INTO `t_pr01` (`prnum`, `typepr`, `note`, `prdate`, `relgroup`, `approvestat`, `requestby`, `warehouse`, `idproject`, `appby`, `createdon`, `createdby`) VALUES
('1000000000', 'PR01', 'Tes', '2021-03-30', NULL, '1', 'Admin', 'WH00', NULL, NULL, '2021-03-30 00:00:00', 'sys-admin'),
('1000000001', 'PR01', 'Test PR', '2021-04-02', NULL, '1', 'Admin', 'WH00', NULL, NULL, '2021-04-02 00:00:00', 'sys-admin');

--
-- Triggers `t_pr01`
--
DELIMITER $$
CREATE TRIGGER `deletepritem` AFTER DELETE ON `t_pr01` FOR EACH ROW DELETE FROM t_pr02 WHERE prnum = OLD.prnum
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_pr02`
--

CREATE TABLE `t_pr02` (
  `prnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pritem` int(11) NOT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(18,2) DEFAULT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `pocreated` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvestat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approveby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_approve` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvedate` date DEFAULT NULL,
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Purchase Order Item';

--
-- Dumping data for table `t_pr02`
--

INSERT INTO `t_pr02` (`prnum`, `pritem`, `material`, `matdesc`, `quantity`, `unit`, `warehouse`, `pocreated`, `approvestat`, `approveby`, `final_approve`, `approvedate`, `remark`, `createdon`, `createdby`) VALUES
('1000000000', 1, 'MAT0001', 'Material 001', '100.00', 'PC', NULL, 'X', '3', 'direktur', 'X', '2021-04-02', '', '2021-03-30 00:00:00', 'sys-admin'),
('1000000000', 2, 'MAT0002', 'Material 002', '50.00', 'PC', NULL, NULL, '5', 'ka-adm-ws', 'X', '2021-04-02', '', '2021-03-30 00:00:00', 'sys-admin'),
('1000000000', 3, 'MAT0003', 'Material 003', '40.00', 'PC', NULL, NULL, '5', 'ka-adm-ws', 'X', '2021-04-02', '', '2021-03-30 00:00:00', 'sys-admin'),
('1000000001', 1, 'MAT0003', 'Material 003', '100.00', 'PC', NULL, 'X', '3', 'direktur', 'X', '2021-04-02', 'tes', '2021-04-02 00:00:00', 'sys-admin'),
('1000000001', 2, 'MAT0004', 'Material 004', '50.00', 'PC', NULL, 'X', '3', 'direktur', 'X', '2021-04-02', 'tes', '2021-04-02 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_quotation01`
--

CREATE TABLE `t_quotation01` (
  `quotation` int(11) NOT NULL,
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qotationdate` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_reserv01`
--

CREATE TABLE `t_reserv01` (
  `resnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resdate` date DEFAULT NULL,
  `note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fromwhs` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `towhs` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Reservation Header';

-- --------------------------------------------------------

--
-- Table structure for table `t_reserv02`
--

CREATE TABLE `t_reserv02` (
  `resnum` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resitem` int(11) NOT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(10,0) DEFAULT NULL,
  `unit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fromwhs` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `towhs` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movementstat` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Reservation Items';

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE `t_role` (
  `roleid` int(11) NOT NULL,
  `rolename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role Master';

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`roleid`, `rolename`, `createdon`, `createdby`) VALUES
(1, 'SYS-ADMIN', '2020-11-26 00:00:00', 'Admin'),
(29, 'ROLE_ADMIN_WORKSHOP', '2021-03-04 00:00:00', 'sys-admin'),
(30, 'ROLE_KEPALA_ADMIN_WORKSHOP', '2021-03-04 00:00:00', 'sys-admin'),
(31, 'ROLE_DIREKTUR', '2021-03-04 00:00:00', 'sys-admin'),
(32, 'ROLE_ADMIN_OFFICE', '2021-03-04 00:00:00', 'sys-admin'),
(33, 'ROLE_MEKANIK', '2021-03-04 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_rolemenu`
--

CREATE TABLE `t_rolemenu` (
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role Menu';

--
-- Dumping data for table `t_rolemenu`
--

INSERT INTO `t_rolemenu` (`roleid`, `menuid`, `createdon`, `createdby`) VALUES
(1, 1, '2020-12-12 00:00:00', 'sys-admin'),
(1, 3, '2020-12-12 00:00:00', 'sys-admin'),
(1, 4, '2020-12-12 00:00:00', 'sys-admin'),
(1, 5, '2020-12-12 00:00:00', 'sys-admin'),
(1, 7, '2020-12-13 00:00:00', 'sys-admin'),
(1, 8, '2020-12-20 00:00:00', 'sys-admin'),
(1, 9, '2021-03-05 00:00:00', 'sys-admin'),
(1, 10, '2020-12-13 00:00:00', 'sys-admin'),
(1, 11, '2020-12-13 00:00:00', 'sys-admin'),
(1, 12, '2020-12-27 00:00:00', 'sys-admin'),
(1, 13, '2021-03-19 00:00:00', 'sys-admin'),
(1, 14, '2020-12-13 00:00:00', 'sys-admin'),
(1, 15, '2021-03-07 00:00:00', 'sys-admin'),
(1, 16, '2021-03-07 00:00:00', 'sys-admin'),
(1, 17, '2020-11-26 00:00:00', 'sys-admin'),
(1, 18, '2021-03-04 00:00:00', 'sys-admin'),
(1, 19, '2020-09-14 00:00:00', 'sys-admin'),
(1, 20, '2020-09-14 00:00:00', 'sys-admin'),
(1, 21, '2020-11-26 00:00:00', 'sys-admin'),
(1, 22, '2020-12-12 00:00:00', 'sys-admin'),
(1, 25, '2021-03-08 00:00:00', 'sys-admin'),
(1, 26, '2021-03-08 00:00:00', 'sys-admin'),
(1, 27, '2020-12-29 00:00:00', 'sys-admin'),
(1, 28, '2021-01-01 00:00:00', 'sys-admin'),
(1, 33, '2021-01-08 00:00:00', 'sys-admin'),
(1, 48, '2021-03-05 00:00:00', 'sys-admin'),
(1, 49, '2021-03-06 00:00:00', 'sys-admin'),
(1, 50, '2021-03-06 00:00:00', 'sys-admin'),
(1, 52, '2021-03-09 00:00:00', 'sys-admin'),
(1, 54, '2021-03-19 00:00:00', 'sys-admin'),
(1, 55, '2021-03-26 00:00:00', 'sys-admin'),
(29, 7, '2021-03-04 00:00:00', 'sys-admin'),
(29, 11, '2021-03-04 00:00:00', 'sys-admin'),
(29, 14, '2021-03-04 00:00:00', 'sys-admin'),
(29, 15, '2021-03-07 00:00:00', 'sys-admin'),
(29, 16, '2021-03-07 00:00:00', 'sys-admin'),
(29, 25, '2021-03-09 00:00:00', 'sys-admin'),
(29, 26, '2021-03-09 00:00:00', 'sys-admin'),
(29, 33, '2021-03-09 00:00:00', 'sys-admin'),
(29, 55, '2021-04-02 00:00:00', 'sys-admin'),
(30, 11, '2021-03-04 00:00:00', 'sys-admin'),
(30, 15, '2021-03-07 00:00:00', 'sys-admin'),
(30, 16, '2021-03-07 00:00:00', 'sys-admin'),
(30, 23, '2021-03-04 00:00:00', 'sys-admin'),
(30, 33, '2021-03-09 00:00:00', 'sys-admin'),
(30, 48, '2021-03-27 00:00:00', 'sys-admin'),
(30, 52, '2021-03-09 00:00:00', 'sys-admin'),
(30, 53, '2021-03-10 00:00:00', 'sys-admin'),
(30, 54, '2021-03-27 00:00:00', 'sys-admin'),
(31, 11, '2021-03-04 00:00:00', 'sys-admin'),
(31, 12, '2021-03-04 00:00:00', 'sys-admin'),
(31, 15, '2021-03-07 00:00:00', 'sys-admin'),
(31, 16, '2021-03-07 00:00:00', 'sys-admin'),
(31, 23, '2021-03-04 00:00:00', 'sys-admin'),
(31, 24, '2021-03-04 00:00:00', 'sys-admin'),
(31, 31, '2021-03-05 00:00:00', 'sys-admin'),
(31, 48, '2021-03-27 00:00:00', 'sys-admin'),
(31, 54, '2021-03-27 00:00:00', 'sys-admin'),
(32, 8, '2021-03-04 00:00:00', 'sys-admin'),
(32, 9, '2021-03-05 00:00:00', 'sys-admin'),
(32, 11, '2021-03-04 00:00:00', 'sys-admin'),
(32, 12, '2021-03-04 00:00:00', 'sys-admin'),
(32, 15, '2021-03-07 00:00:00', 'sys-admin'),
(32, 16, '2021-03-07 00:00:00', 'sys-admin'),
(32, 25, '2021-03-08 00:00:00', 'sys-admin'),
(32, 26, '2021-03-08 00:00:00', 'sys-admin'),
(32, 48, '2021-03-27 00:00:00', 'sys-admin'),
(32, 54, '2021-03-27 00:00:00', 'sys-admin'),
(33, 7, '2021-03-12 00:00:00', 'sys-admin'),
(33, 10, '2021-03-04 00:00:00', 'sys-admin'),
(33, 11, '2021-03-12 00:00:00', 'sys-admin'),
(33, 14, '2021-03-04 00:00:00', 'sys-admin'),
(33, 52, '2021-03-14 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_role_avtivity`
--

CREATE TABLE `t_role_avtivity` (
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `activity` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Activity Auth';

--
-- Dumping data for table `t_role_avtivity`
--

INSERT INTO `t_role_avtivity` (`roleid`, `menuid`, `activity`, `status`, `createdon`) VALUES
(1, 1, 'Create', 1, '2021-03-04'),
(1, 1, 'Delete', 1, '2021-03-04'),
(1, 1, 'Read', 1, '2021-03-04'),
(1, 1, 'Update', 1, '2021-03-04'),
(1, 3, 'Create', 1, '2021-03-04'),
(1, 3, 'Delete', 1, '2021-03-04'),
(1, 3, 'Read', 1, '2021-03-04'),
(1, 3, 'Update', 1, '2021-03-04'),
(1, 4, 'Create', 1, '2021-03-04'),
(1, 4, 'Delete', 1, '2021-03-04'),
(1, 4, 'Read', 1, '2021-03-04'),
(1, 4, 'Update', 1, '2021-03-04'),
(1, 5, 'Create', 1, '2021-03-04'),
(1, 5, 'Delete', 1, '2021-03-04'),
(1, 5, 'Read', 1, '2021-03-04'),
(1, 5, 'Update', 1, '2021-03-04'),
(1, 7, 'Create', 1, '2021-03-04'),
(1, 7, 'Delete', 1, '2021-03-04'),
(1, 7, 'Read', 1, '2021-03-04'),
(1, 7, 'Update', 1, '2021-03-04'),
(1, 8, 'Create', 1, '2021-03-04'),
(1, 8, 'Delete', 1, '2021-03-04'),
(1, 8, 'Read', 1, '2021-03-04'),
(1, 8, 'Update', 1, '2021-03-04'),
(1, 9, 'Create', 1, '2021-03-05'),
(1, 9, 'Delete', 1, '2021-03-05'),
(1, 9, 'Read', 1, '2021-03-05'),
(1, 9, 'Update', 1, '2021-03-05'),
(1, 10, 'Create', 1, '2021-03-04'),
(1, 10, 'Delete', 1, '2021-03-04'),
(1, 10, 'Read', 1, '2021-03-04'),
(1, 10, 'Update', 1, '2021-03-04'),
(1, 11, 'Create', 0, '2021-03-04'),
(1, 11, 'Delete', 0, '2021-03-04'),
(1, 11, 'Read', 1, '2021-03-04'),
(1, 11, 'Update', 0, '2021-03-04'),
(1, 12, 'Create', 0, '2021-03-04'),
(1, 12, 'Delete', 0, '2021-03-04'),
(1, 12, 'Read', 1, '2021-03-04'),
(1, 12, 'Update', 0, '2021-03-04'),
(1, 13, 'Create', 0, '2021-03-19'),
(1, 13, 'Delete', 0, '2021-03-19'),
(1, 13, 'Read', 1, '2021-03-19'),
(1, 13, 'Update', 0, '2021-03-19'),
(1, 14, 'Create', 0, '2021-03-04'),
(1, 14, 'Delete', 0, '2021-03-04'),
(1, 14, 'Read', 1, '2021-03-04'),
(1, 14, 'Update', 0, '2021-03-04'),
(1, 15, 'Create', 0, '2021-03-07'),
(1, 15, 'Delete', 0, '2021-03-07'),
(1, 15, 'Read', 1, '2021-03-07'),
(1, 15, 'Update', 0, '2021-03-07'),
(1, 16, 'Create', 0, '2021-03-07'),
(1, 16, 'Delete', 0, '2021-03-07'),
(1, 16, 'Read', 1, '2021-03-07'),
(1, 16, 'Update', 0, '2021-03-07'),
(1, 17, 'Create', 1, '2021-03-04'),
(1, 17, 'Delete', 1, '2021-03-04'),
(1, 17, 'Read', 1, '2021-03-04'),
(1, 17, 'Update', 1, '2021-03-04'),
(1, 18, 'Create', 1, '2021-03-04'),
(1, 18, 'Delete', 1, '2021-03-04'),
(1, 18, 'Read', 1, '2021-03-04'),
(1, 18, 'Update', 1, '2021-03-04'),
(1, 19, 'Create', 1, '2021-03-04'),
(1, 19, 'Delete', 1, '2021-03-04'),
(1, 19, 'Read', 1, '2021-03-04'),
(1, 19, 'Update', 1, '2021-03-04'),
(1, 20, 'Create', 1, '2021-03-04'),
(1, 20, 'Delete', 1, '2021-03-04'),
(1, 20, 'Read', 1, '2021-03-04'),
(1, 20, 'Update', 1, '2021-03-04'),
(1, 21, 'Create', 1, '2021-03-04'),
(1, 21, 'Delete', 1, '2021-03-04'),
(1, 21, 'Read', 1, '2021-03-04'),
(1, 21, 'Update', 1, '2021-03-04'),
(1, 22, 'Create', 1, '2021-03-04'),
(1, 22, 'Delete', 1, '2021-03-04'),
(1, 22, 'Read', 1, '2021-03-04'),
(1, 22, 'Update', 1, '2021-03-04'),
(1, 25, 'Create', 1, '2021-03-08'),
(1, 25, 'Delete', 1, '2021-03-08'),
(1, 25, 'Read', 1, '2021-03-08'),
(1, 25, 'Update', 1, '2021-03-08'),
(1, 26, 'Create', 1, '2021-03-08'),
(1, 26, 'Delete', 1, '2021-03-08'),
(1, 26, 'Read', 1, '2021-03-08'),
(1, 26, 'Update', 1, '2021-03-08'),
(1, 27, 'Create', 1, '2021-03-04'),
(1, 27, 'Delete', 1, '2021-03-04'),
(1, 27, 'Read', 1, '2021-03-04'),
(1, 27, 'Update', 1, '2021-03-04'),
(1, 28, 'Create', 1, '2021-03-04'),
(1, 28, 'Delete', 1, '2021-03-04'),
(1, 28, 'Read', 1, '2021-03-04'),
(1, 28, 'Update', 1, '2021-03-04'),
(1, 33, 'Create', 0, '2021-03-04'),
(1, 33, 'Delete', 0, '2021-03-04'),
(1, 33, 'Read', 1, '2021-03-04'),
(1, 33, 'Update', 0, '2021-03-04'),
(1, 48, 'Create', 0, '2021-03-05'),
(1, 48, 'Delete', 0, '2021-03-05'),
(1, 48, 'Read', 1, '2021-03-05'),
(1, 48, 'Update', 0, '2021-03-05'),
(1, 49, 'Create', 1, '2021-03-06'),
(1, 49, 'Delete', 1, '2021-03-06'),
(1, 49, 'Read', 1, '2021-03-06'),
(1, 49, 'Update', 1, '2021-03-06'),
(1, 50, 'Create', 1, '2021-03-06'),
(1, 50, 'Delete', 1, '2021-03-06'),
(1, 50, 'Read', 1, '2021-03-06'),
(1, 50, 'Update', 1, '2021-03-06'),
(1, 52, 'Create', 1, '2021-03-09'),
(1, 52, 'Delete', 1, '2021-03-09'),
(1, 52, 'Read', 1, '2021-03-09'),
(1, 52, 'Update', 1, '2021-03-09'),
(1, 54, 'Create', 0, '2021-03-19'),
(1, 54, 'Delete', 0, '2021-03-19'),
(1, 54, 'Read', 1, '2021-03-19'),
(1, 54, 'Update', 0, '2021-03-19'),
(1, 55, 'Create', 1, '2021-03-26'),
(1, 55, 'Delete', 1, '2021-03-26'),
(1, 55, 'Read', 1, '2021-03-26'),
(1, 55, 'Update', 1, '2021-03-26'),
(29, 7, 'Create', 1, '2021-03-04'),
(29, 7, 'Delete', 1, '2021-03-04'),
(29, 7, 'Read', 1, '2021-03-04'),
(29, 7, 'Update', 1, '2021-03-04'),
(29, 11, 'Create', 0, '2021-03-04'),
(29, 11, 'Delete', 0, '2021-03-04'),
(29, 11, 'Read', 1, '2021-03-04'),
(29, 11, 'Update', 0, '2021-03-04'),
(29, 14, 'Create', 0, '2021-03-04'),
(29, 14, 'Delete', 0, '2021-03-04'),
(29, 14, 'Read', 1, '2021-03-04'),
(29, 14, 'Update', 0, '2021-03-04'),
(29, 15, 'Create', 0, '2021-03-07'),
(29, 15, 'Delete', 0, '2021-03-07'),
(29, 15, 'Read', 1, '2021-03-07'),
(29, 15, 'Update', 0, '2021-03-07'),
(29, 16, 'Create', 0, '2021-03-07'),
(29, 16, 'Delete', 0, '2021-03-07'),
(29, 16, 'Read', 1, '2021-03-07'),
(29, 16, 'Update', 0, '2021-03-07'),
(29, 25, 'Create', 1, '2021-03-09'),
(29, 25, 'Delete', 1, '2021-03-09'),
(29, 25, 'Read', 1, '2021-03-09'),
(29, 25, 'Update', 1, '2021-03-09'),
(29, 26, 'Create', 1, '2021-03-09'),
(29, 26, 'Delete', 1, '2021-03-09'),
(29, 26, 'Read', 1, '2021-03-09'),
(29, 26, 'Update', 1, '2021-03-09'),
(29, 33, 'Create', 0, '2021-03-09'),
(29, 33, 'Delete', 0, '2021-03-09'),
(29, 33, 'Read', 1, '2021-03-09'),
(29, 33, 'Update', 0, '2021-03-09'),
(29, 55, 'Create', 1, '2021-04-02'),
(29, 55, 'Delete', 1, '2021-04-02'),
(29, 55, 'Read', 1, '2021-04-02'),
(29, 55, 'Update', 1, '2021-04-02'),
(30, 11, 'Create', 0, '2021-03-04'),
(30, 11, 'Delete', 0, '2021-03-04'),
(30, 11, 'Read', 1, '2021-03-04'),
(30, 11, 'Update', 0, '2021-03-04'),
(30, 15, 'Create', 0, '2021-03-07'),
(30, 15, 'Delete', 0, '2021-03-07'),
(30, 15, 'Read', 1, '2021-03-07'),
(30, 15, 'Update', 0, '2021-03-07'),
(30, 16, 'Create', 0, '2021-03-07'),
(30, 16, 'Delete', 0, '2021-03-07'),
(30, 16, 'Read', 1, '2021-03-07'),
(30, 16, 'Update', 0, '2021-03-07'),
(30, 23, 'Create', 0, '2021-03-04'),
(30, 23, 'Delete', 0, '2021-03-04'),
(30, 23, 'Read', 1, '2021-03-04'),
(30, 23, 'Update', 1, '2021-03-04'),
(30, 33, 'Create', 0, '2021-03-09'),
(30, 33, 'Delete', 0, '2021-03-09'),
(30, 33, 'Read', 1, '2021-03-09'),
(30, 33, 'Update', 0, '2021-03-09'),
(30, 48, 'Create', 0, '2021-03-27'),
(30, 48, 'Delete', 0, '2021-03-27'),
(30, 48, 'Read', 1, '2021-03-27'),
(30, 48, 'Update', 0, '2021-03-27'),
(30, 52, 'Create', 1, '2021-03-09'),
(30, 52, 'Delete', 0, '2021-03-09'),
(30, 52, 'Read', 1, '2021-03-09'),
(30, 52, 'Update', 1, '2021-03-09'),
(30, 53, 'Create', 0, '2021-03-10'),
(30, 53, 'Delete', 0, '2021-03-10'),
(30, 53, 'Read', 1, '2021-03-10'),
(30, 53, 'Update', 1, '2021-03-10'),
(30, 54, 'Create', 0, '2021-03-27'),
(30, 54, 'Delete', 0, '2021-03-27'),
(30, 54, 'Read', 1, '2021-03-27'),
(30, 54, 'Update', 0, '2021-03-27'),
(31, 11, 'Create', 0, '2021-03-04'),
(31, 11, 'Delete', 0, '2021-03-04'),
(31, 11, 'Read', 1, '2021-03-04'),
(31, 11, 'Update', 0, '2021-03-04'),
(31, 12, 'Create', 0, '2021-03-04'),
(31, 12, 'Delete', 0, '2021-03-04'),
(31, 12, 'Read', 1, '2021-03-04'),
(31, 12, 'Update', 0, '2021-03-04'),
(31, 15, 'Create', 0, '2021-03-07'),
(31, 15, 'Delete', 0, '2021-03-07'),
(31, 15, 'Read', 1, '2021-03-07'),
(31, 15, 'Update', 0, '2021-03-07'),
(31, 16, 'Create', 0, '2021-03-07'),
(31, 16, 'Delete', 0, '2021-03-07'),
(31, 16, 'Read', 1, '2021-03-07'),
(31, 16, 'Update', 0, '2021-03-07'),
(31, 23, 'Create', 0, '2021-03-04'),
(31, 23, 'Delete', 0, '2021-03-04'),
(31, 23, 'Read', 1, '2021-03-04'),
(31, 23, 'Update', 1, '2021-03-04'),
(31, 24, 'Create', 0, '2021-03-04'),
(31, 24, 'Delete', 0, '2021-03-04'),
(31, 24, 'Read', 1, '2021-03-04'),
(31, 24, 'Update', 1, '2021-03-04'),
(31, 31, 'Create', 0, '2021-03-05'),
(31, 31, 'Delete', 0, '2021-03-05'),
(31, 31, 'Read', 1, '2021-03-05'),
(31, 31, 'Update', 1, '2021-03-05'),
(31, 48, 'Create', 0, '2021-03-27'),
(31, 48, 'Delete', 0, '2021-03-27'),
(31, 48, 'Read', 1, '2021-03-27'),
(31, 48, 'Update', 0, '2021-03-27'),
(31, 54, 'Create', 0, '2021-03-27'),
(31, 54, 'Delete', 0, '2021-03-27'),
(31, 54, 'Read', 1, '2021-03-27'),
(31, 54, 'Update', 0, '2021-03-27'),
(32, 8, 'Create', 1, '2021-03-04'),
(32, 8, 'Delete', 1, '2021-03-04'),
(32, 8, 'Read', 1, '2021-03-04'),
(32, 8, 'Update', 1, '2021-03-04'),
(32, 9, 'Create', 1, '2021-03-05'),
(32, 9, 'Delete', 1, '2021-03-05'),
(32, 9, 'Read', 1, '2021-03-05'),
(32, 9, 'Update', 1, '2021-03-05'),
(32, 11, 'Create', 0, '2021-03-04'),
(32, 11, 'Delete', 0, '2021-03-04'),
(32, 11, 'Read', 1, '2021-03-04'),
(32, 11, 'Update', 0, '2021-03-04'),
(32, 12, 'Create', 0, '2021-03-04'),
(32, 12, 'Delete', 0, '2021-03-04'),
(32, 12, 'Read', 1, '2021-03-04'),
(32, 12, 'Update', 0, '2021-03-04'),
(32, 15, 'Create', 0, '2021-03-07'),
(32, 15, 'Delete', 0, '2021-03-07'),
(32, 15, 'Read', 1, '2021-03-07'),
(32, 15, 'Update', 0, '2021-03-07'),
(32, 16, 'Create', 0, '2021-03-07'),
(32, 16, 'Delete', 0, '2021-03-07'),
(32, 16, 'Read', 1, '2021-03-07'),
(32, 16, 'Update', 0, '2021-03-07'),
(32, 25, 'Create', 1, '2021-03-08'),
(32, 25, 'Delete', 1, '2021-03-08'),
(32, 25, 'Read', 1, '2021-03-08'),
(32, 25, 'Update', 1, '2021-03-08'),
(32, 26, 'Create', 1, '2021-03-08'),
(32, 26, 'Delete', 1, '2021-03-08'),
(32, 26, 'Read', 1, '2021-03-08'),
(32, 26, 'Update', 1, '2021-03-08'),
(32, 48, 'Create', 0, '2021-03-27'),
(32, 48, 'Delete', 0, '2021-03-27'),
(32, 48, 'Read', 1, '2021-03-27'),
(32, 48, 'Update', 0, '2021-03-27'),
(32, 54, 'Create', 0, '2021-03-27'),
(32, 54, 'Delete', 0, '2021-03-27'),
(32, 54, 'Read', 1, '2021-03-27'),
(32, 54, 'Update', 0, '2021-03-27'),
(33, 7, 'Create', 1, '2021-03-12'),
(33, 7, 'Delete', 1, '2021-03-12'),
(33, 7, 'Read', 1, '2021-03-12'),
(33, 7, 'Update', 1, '2021-03-12'),
(33, 10, 'Create', 1, '2021-03-04'),
(33, 10, 'Delete', 1, '2021-03-04'),
(33, 10, 'Read', 1, '2021-03-04'),
(33, 10, 'Update', 1, '2021-03-04'),
(33, 11, 'Create', 0, '2021-03-12'),
(33, 11, 'Delete', 0, '2021-03-12'),
(33, 11, 'Read', 1, '2021-03-12'),
(33, 11, 'Update', 0, '2021-03-12'),
(33, 14, 'Create', 0, '2021-03-04'),
(33, 14, 'Delete', 0, '2021-03-04'),
(33, 14, 'Read', 1, '2021-03-04'),
(33, 14, 'Update', 0, '2021-03-04'),
(33, 52, 'Create', 1, '2021-03-14'),
(33, 52, 'Delete', 1, '2021-03-14'),
(33, 52, 'Read', 1, '2021-03-14'),
(33, 52, 'Update', 1, '2021-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `t_service01`
--

CREATE TABLE `t_service01` (
  `servicenum` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `servicedate` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `mekanik` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nopol` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refnum` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicestatus` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmdate` date DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_service01`
--

INSERT INTO `t_service01` (`servicenum`, `servicedate`, `note`, `mekanik`, `nopol`, `refnum`, `servicestatus`, `warehouse`, `confirmdate`, `createdon`, `createdby`) VALUES
('SRV-8900000000', '2021-03-28', 'Service Kendaraan', 'Udin', 'D 1677 AIH', NULL, 'X', 'WH00', '2021-04-06', '2021-03-28 09:45:59', 'sys-admin'),
('SRV-8900000001', '2021-04-02', 'Service Kendaraan Baru', 'Cecep', 'DR 3557 L', NULL, 'X', 'WH00', NULL, '2021-04-02 14:19:51', 'sys-admin');

--
-- Triggers `t_service01`
--
DELIMITER $$
CREATE TRIGGER `setcreatedonservice01` BEFORE INSERT ON `t_service01` FOR EACH ROW SET NEW.createdon = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_service02`
--

CREATE TABLE `t_service02` (
  `servicenum` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serviceitem` int(11) NOT NULL,
  `material` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_service02`
--

INSERT INTO `t_service02` (`servicenum`, `serviceitem`, `material`, `warehouse`, `quantity`, `unit`, `createdon`, `createdby`) VALUES
('SRV-8900000000', 1, 'MAT0005', 'WH00', '2.00', 'PC', '2021-03-28 09:45:59', 'sys-admin'),
('SRV-8900000001', 1, 'MAT0001', 'WH00', '5.00', 'PC', '2021-04-02 14:19:51', 'sys-admin'),
('SRV-8900000001', 2, 'MAT0002', 'WH00', '10.00', 'PC', '2021-04-02 14:19:51', 'sys-admin'),
('SRV-8900000001', 3, 'MAT0005', 'WH00', '1.00', 'PC', '2021-04-02 14:19:52', 'sys-admin');

--
-- Triggers `t_service02`
--
DELIMITER $$
CREATE TRIGGER `setcreatedonservice` BEFORE INSERT ON `t_service02` FOR EACH ROW SET NEW.createdon = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stock`
--

CREATE TABLE `t_stock` (
  `material` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `blockqty` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Inventory Stock';

--
-- Dumping data for table `t_stock`
--

INSERT INTO `t_stock` (`material`, `warehouse`, `quantity`, `blockqty`) VALUES
('MAT0001', 'WH00', '245.00', '0.00'),
('MAT0002', 'WH00', '60.00', '0.00'),
('MAT0003', 'WH00', '100.00', '0.00'),
('MAT0004', 'WH00', '50.00', '0.00'),
('MAT0005', 'WH00', '2.00', '0.00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `t_totalcycletime`
-- (See below for the actual view)
--
CREATE TABLE `t_totalcycletime` (
`bomid` varchar(30)
,`activity` int(11)
,`partnumber` varchar(70)
,`quantity` decimal(8,2)
,`cycletime` decimal(8,2)
,`totaltime` decimal(16,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `t_uom`
--

CREATE TABLE `t_uom` (
  `uom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `decimalval` int(11) NOT NULL DEFAULT '0',
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master UOM';

--
-- Dumping data for table `t_uom`
--

INSERT INTO `t_uom` (`uom`, `description`, `decimalval`, `createdon`, `createdby`) VALUES
('CAR', 'Carton', 0, '2020-12-12', 'sys-admin'),
('COIL', 'Coil', 0, '2020-12-12', 'sys-admin'),
('DUS', 'Dus', 0, '2020-12-12', 'sys-admin'),
('M', 'Meter', 2, '2020-12-12', 'sys-admin'),
('PACK', 'Pack', 0, '2020-12-12', 'sys-admin'),
('PC', 'Piece', 0, '2020-12-12', 'sys-admin'),
('PCS', 'Piece', 0, '2020-12-12', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userlevel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `jabatan` int(11) DEFAULT NULL,
  `section` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reffid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`username`, `password`, `nama`, `userlevel`, `department`, `jabatan`, `section`, `approval`, `reffid`, `createdby`, `createdon`) VALUES
('adm-office', '$2y$12$A8GzW.rxTqyrHd.d8iDUuO9sVXJgnxDQWmKzzoYZuXQCqo6hKz3Pi', 'Admin Office', 'Admin', 0, 1, NULL, NULL, '', 'sys-admin', '2021-03-04'),
('adm-ws', '$2y$12$njTvaBlHBkNnK8HzGDjPQOSxtAkbWMMd.b6CQvoclfxsMKj.wVQP2', 'Admin Workshop', 'Admin', 0, 0, NULL, NULL, '', 'sys-admin', '2021-03-04'),
('adm-ws1', '$2y$12$500t2i3aPG4rDR.EXdPuo.TqW.BJIZHsJSaRMFbCVP0ljsKagyDOW', 'Admin WS 1', 'Admin', 1, 1, NULL, NULL, '', 'sys-admin', '2021-03-14'),
('adm-ws2', '$2y$12$glQUayn4k9EmTZWuqlX4ZOlfgcfunURRRBtXAb7OlLL0k15u/SMsW', 'Admin WS 2', 'Admin', 1, 1, NULL, NULL, '', 'sys-admin', '2021-03-14'),
('direktur', '$2y$12$VPYrjYDKKTpWZFCS0Hgh1Ogo6dWy/1v7kdHvvebD2X4P0lF9Iyr1C', 'Direktur', 'Admin', 0, 6, NULL, NULL, '', 'sys-admin', '2021-03-04'),
('ka-adm-ws', '$2y$12$9hjwSjAO/DmZ9gV77Q6LhenDWFSMIWhNtgTcLTMVU4d/h86uIoPOa', 'Kepala Admin Workshop', 'Admin', 0, 0, NULL, NULL, '', 'sys-admin', '2021-03-04'),
('mekanik', '$2y$12$xlyrvwd1RY1TjmgSUwaK.OqbaFp0jF4RzuBi25tD8w1wbXp1zO7Aa', 'Mekanik', 'Staff', 0, 9, NULL, NULL, '', 'sys-admin', '2021-03-04'),
('sys-admin', '$2y$12$YCj4abvz4tMxEoYys4/9sul.FX.9lyhoQzRdl8rI8LWxg1rQb7l/W', 'Administrator', 'SysAdmin', 0, 1, NULL, NULL, '6160761', 'Admin', '2020-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_object_auth`
--

CREATE TABLE `t_user_object_auth` (
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_auth` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_value` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Object Authorization';

--
-- Dumping data for table `t_user_object_auth`
--

INSERT INTO `t_user_object_auth` (`username`, `ob_auth`, `ob_value`, `createdon`, `createdby`) VALUES
('adm-office', 'OB_WAREHOUSE', '*', '2021-03-14 02:03:38', 'sys-admin'),
('adm-ws', 'OB_MOVEMENT', 'GR01', '2021-03-09 11:03:01', 'sys-admin'),
('adm-ws', 'OB_MOVEMENT', 'TF01', '2021-03-09 11:03:13', 'sys-admin'),
('adm-ws', 'OB_MOVEMENT', 'TF02', '2021-03-09 11:03:23', 'sys-admin'),
('adm-ws', 'OB_WAREHOUSE', '*', '2021-03-09 11:03:23', 'sys-admin'),
('adm-ws1', 'OB_MOVEMENT', 'GR01', '2021-03-14 02:03:05', 'sys-admin'),
('adm-ws1', 'OB_WAREHOUSE', 'WH01', '2021-03-14 01:03:33', 'sys-admin'),
('adm-ws2', 'OB_MOVEMENT', 'GR01', '2021-03-14 02:03:13', 'sys-admin'),
('adm-ws2', 'OB_WAREHOUSE', 'WH02', '2021-03-14 01:03:44', 'sys-admin'),
('direktur', 'OB_WAREHOUSE', '*', '2021-03-06 08:03:09', 'sys-admin'),
('ka-adm-ws', 'OB_WAREHOUSE', '*', '2021-03-09 11:03:10', 'sys-admin'),
('mekanik', 'OB_WAREHOUSE', 'WH01', '2021-03-13 08:03:33', 'sys-admin'),
('mekanik', 'OB_WAREHOUSE', 'WH02', '2021-03-13 08:03:44', 'sys-admin'),
('sys-admin', 'OB_MOVEMENT', '*', '2021-03-07 01:03:11', 'sys-admin'),
('sys-admin', 'OB_WAREHOUSE', '*', '2020-12-31 02:12:38', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_role`
--

CREATE TABLE `t_user_role` (
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleid` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Role';

--
-- Dumping data for table `t_user_role`
--

INSERT INTO `t_user_role` (`username`, `roleid`, `createdon`, `createdby`) VALUES
('adm-office', 32, '2021-03-04 00:00:00', 'sys-admin'),
('adm-ws', 29, '2021-03-04 00:00:00', 'sys-admin'),
('adm-ws1', 29, '2021-03-14 00:00:00', 'sys-admin'),
('adm-ws2', 29, '2021-03-14 00:00:00', 'sys-admin'),
('direktur', 31, '2021-03-04 00:00:00', 'sys-admin'),
('ka-adm-ws', 30, '2021-03-04 00:00:00', 'sys-admin'),
('mekanik', 33, '2021-03-04 00:00:00', 'sys-admin'),
('sys-admin', 1, '2020-11-26 00:00:00', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_vendor`
--

CREATE TABLE `t_vendor` (
  `vendor` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namavendor` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kota` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodepos` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notelp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master Vendor';

--
-- Dumping data for table `t_vendor`
--

INSERT INTO `t_vendor` (`vendor`, `namavendor`, `alamat`, `kota`, `provinsi`, `kodepos`, `notelp`, `email`, `fax`, `npwp`, `active`, `createdon`, `createdby`) VALUES
('3000000000', 'PT Maju Merdeka', 'Jalan Merdeka No 50 Kota Jakarta Pusat, Indonesia Raya', NULL, NULL, NULL, '02144444', 'husnulmub@gmail.com', NULL, '94.981.043.6-409.000', NULL, '2020-12-30 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_wip`
--

CREATE TABLE `t_wip` (
  `wipid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wiptype` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `from_area` int(11) DEFAULT NULL,
  `dest_area` int(11) DEFAULT NULL,
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_wip`
--

INSERT INTO `t_wip` (`wipid`, `wiptype`, `from_area`, `dest_area`, `bomid`, `partnumber`, `customer`, `quantity`, `periode`, `createdby`, `createdon`) VALUES
('1611674010', 'IN', 1, 0, '1609676821', 'TES', 'tes', 1000, '2021-01-26', 'sys-admin', '2021-01-26'),
('1611674059', 'IN', 2, 0, '1609676821', 'TES', 'tes', 500, '2021-01-26', 'sys-admin', '2021-01-26'),
('1611674059', 'OUT', 1, 2, '1609676821', 'TES', 'tes', 500, '2021-01-26', 'sys-admin', '2021-01-26');

--
-- Triggers `t_wip`
--
DELIMITER $$
CREATE TRIGGER `update_WIP_Stock` AFTER INSERT ON `t_wip` FOR EACH ROW call sp_UpdateStockWIP(new.wiptype, new.bomid, new.quantity, new.from_area, new.dest_area, new.periode)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_wip_stock`
--

CREATE TABLE `t_wip_stock` (
  `area` int(11) NOT NULL,
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` date DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_wip_stock`
--

INSERT INTO `t_wip_stock` (`area`, `bomid`, `period`, `quantity`) VALUES
(1, '1609630458', '2021-01-26', 4000),
(1, '1609676821', '2021-01-26', 500),
(2, '1609630458', '2021-01-26', 500),
(2, '1609676821', '2021-01-26', 500);

-- --------------------------------------------------------

--
-- Table structure for table `t_wos01`
--

CREATE TABLE `t_wos01` (
  `id` int(11) NOT NULL,
  `reffid` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `wpnumber` int(11) NOT NULL,
  `circuitno` int(11) NOT NULL,
  `stardate` date NOT NULL,
  `enddate` date NOT NULL,
  `wos_status` int(11) DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Transaksi WOS';

--
-- Dumping data for table `t_wos01`
--

INSERT INTO `t_wos01` (`id`, `reffid`, `partnumber`, `quantity`, `wpnumber`, `circuitno`, `stardate`, `enddate`, `wos_status`, `createdby`, `createdon`) VALUES
(1, '6160761', 'NL - 7421 B', NULL, 1, 2, '2021-02-24', '2021-02-28', 2, 'sys-admin', '2021-02-24'),
(3, '6160761', 'NL - 7421 B', NULL, 2, 3, '2021-02-24', '2021-02-24', 2, 'sys-admin', '2021-02-24'),
(4, '6160762', 'NL - 7421 B', NULL, 1, 1, '2021-02-24', '2021-02-24', 2, 'sys-admin', '2021-02-24'),
(5, '6160762', 'NL - 7421 B', NULL, 1, 2, '2021-02-24', '2021-02-24', 2, 'sys-admin', '2021-02-24'),
(6, '6160762', 'NL - 7421 B', NULL, 1, 1, '2021-02-24', '2021-02-28', 1, 'sys-admin', '2021-02-24'),
(7, '2000001', 'NL - 7421 B', NULL, 1, 1, '2021-02-26', '2021-02-28', 1, 'sys-admin', '2021-02-26'),
(8, '200002', 'NL - 7421 B', 1000, 1, 2, '2021-02-26', '2021-02-28', 1, 'sys-admin', '2021-02-26'),
(9, '6160763', 'NL - 7421 B', 200, 1, 1, '2021-03-04', '2021-03-07', 2, 'sys-admin', '2021-03-04'),
(10, '6160764', 'NL - 7421 B', 200, 1, 1, '2021-03-04', '2021-03-07', 2, 'sys-admin', '2021-03-04'),
(11, '6160765', 'NL - 7421 B', 200, 1, 1, '2021-03-04', '2021-03-07', 2, 'sys-admin', '2021-03-04'),
(12, '6160766', 'NL - 7421 B', 200, 1, 1, '2021-03-04', '2021-03-07', 1, 'sys-admin', '2021-03-04'),
(13, '6160767', 'NL - 7421 B', 200, 1, 1, '2021-03-04', '2021-03-07', 1, 'sys-admin', '2021-03-04'),
(14, '6160771', 'NL - 7421 B', 200, 1, 1, '2021-03-15', '2021-03-20', 1, 'sys-admin', '2021-03-04'),
(15, '6160772', 'NL - 7421 B', 200, 1, 1, '2021-03-15', '2021-03-20', 1, 'sys-admin', '2021-03-04'),
(16, '6160773', 'NL - 7421 B', 200, 1, 1, '2021-03-15', '2021-03-20', 1, 'sys-admin', '2021-03-04'),
(17, '6160774', 'NL - 7421 B', 200, 1, 1, '2021-03-15', '2021-03-20', 1, 'sys-admin', '2021-03-04'),
(18, '6160775', 'NL - 7421 B', 200, 1, 1, '2021-03-15', '2021-03-20', 1, 'sys-admin', '2021-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `t_wos_image`
--

CREATE TABLE `t_wos_image` (
  `bomid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `circuitno` int(11) NOT NULL,
  `imagelink` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_wos_image`
--

INSERT INTO `t_wos_image` (`bomid`, `partnumber`, `circuitno`, `imagelink`, `createdby`, `createdon`) VALUES
('1609630458', 'NL - 7421 B', 1, 'https://awsi.co.id/WOS/var/albums/MINDA-ASEAN-AUTOMOTIVE---NL-7421-SERIES/B%20%201%20of%202.PNG?m=1613803704', 'sys-admin', '2021-02-24'),
('1609630458', 'NL - 7421 B', 2, 'https://awsi.co.id/WOS/var/albums/MINDA-ASEAN-AUTOMOTIVE---NL-7421-SERIES/O%20%201%20of%202.PNG?m=1613803689', 'sys-admin', '2021-02-24'),
('1609656011', 'HARNESS GPS', 1, 'https://awsi.co.id/WOS/var/albums/MINDA-ASEAN-AUTOMOTIVE---NL-7421-SERIES/B%20%201%20of%202.PNG?m=1613803704', 'sys-admin', '2021-02-24');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_bank_master`
-- (See below for the actual view)
--
CREATE TABLE `v_bank_master` (
`id` int(11)
,`bankid` varchar(4)
,`bankno` varchar(30)
,`bankacc` varchar(100)
,`status` varchar(1)
,`deskripsi` varchar(50)
,`balance` decimal(15,2)
,`user` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_cost01`
-- (See below for the actual view)
--
CREATE TABLE `v_cost01` (
`bomid` varchar(30)
,`partnumber` varchar(70)
,`partname` varchar(70)
,`customer` varchar(100)
,`qtycct` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detailcost`
-- (See below for the actual view)
--
CREATE TABLE `v_detailcost` (
`bomid` varchar(30)
,`id` int(11)
,`activity` varchar(100)
,`cycletime` decimal(8,2)
,`quantity` decimal(8,2)
,`totaltime` varchar(57)
,`cycvleunit` varchar(10)
,`partnumber` varchar(70)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_inventory01`
-- (See below for the actual view)
--
CREATE TABLE `v_inventory01` (
`material` varchar(70)
,`matdesc` varchar(100)
,`partname` varchar(50)
,`partnumber` varchar(50)
,`warehouse` varchar(15)
,`deskripsi` varchar(40)
,`quantity` decimal(15,2)
,`matunit` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_inventory02`
-- (See below for the actual view)
--
CREATE TABLE `v_inventory02` (
`grnum` varchar(12)
,`year` varchar(5)
,`gritem` int(11)
,`movement` varchar(5)
,`movementdate` date
,`note` text
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`ponum` varchar(25)
,`poitem` int(11)
,`remark` text
,`warehouse` varchar(10)
,`price` decimal(15,2)
,`vendor` varchar(10)
,`namavendor` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_inventory03`
-- (See below for the actual view)
--
CREATE TABLE `v_inventory03` (
`grnum` varchar(12)
,`year` varchar(5)
,`gritem` int(11)
,`movement` varchar(5)
,`movementdate` date
,`movemventtext` varchar(20)
,`note` text
,`batchnumber` varchar(30)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`ponum` varchar(25)
,`poitem` int(11)
,`resnum` varchar(15)
,`resitem` int(11)
,`remark` text
,`warehouse` varchar(10)
,`whsname` varchar(20)
,`warehouseto` varchar(10)
,`whsdest` varchar(20)
,`shkzg` varchar(1)
,`createdby` varchar(50)
,`department` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_payment01`
-- (See below for the actual view)
--
CREATE TABLE `v_payment01` (
`ponum` varchar(25)
,`podat` date
,`note` text
,`vendor` varchar(10)
,`namavendor` varchar(60)
,`povalue` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_payment02`
-- (See below for the actual view)
--
CREATE TABLE `v_payment02` (
`ivnum` varchar(15)
,`ivyear` int(11)
,`ivitem` int(11)
,`ponum` varchar(15)
,`poitem` int(11)
,`ivdate` date
,`material` varchar(70)
,`matdesc` varchar(100)
,`mattypedesc` varchar(50)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`price` decimal(15,2)
,`ppn` int(11)
,`discount` decimal(15,2)
,`subtotal` decimal(15,2)
,`prnum` varchar(15)
,`pritem` int(11)
,`final_approve` varchar(1)
,`paymentstat` varchar(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_po001`
-- (See below for the actual view)
--
CREATE TABLE `v_po001` (
`ponum` varchar(25)
,`ext_ponum` varchar(25)
,`potype` varchar(15)
,`podat` date
,`vendor` varchar(10)
,`note` text
,`currency` varchar(10)
,`approvestat` varchar(1)
,`appby` varchar(50)
,`completed` varchar(1)
,`createdon` datetime
,`createdby` varchar(50)
,`namavendor` varchar(60)
,`alamat` text
,`notelp` varchar(15)
,`email` varchar(50)
,`department` varchar(20)
,`postat` varchar(8)
,`warehouse` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_po002`
-- (See below for the actual view)
--
CREATE TABLE `v_po002` (
`ponum` varchar(25)
,`vendor` varchar(10)
,`namavendor` varchar(60)
,`podat` date
,`note` text
,`warehouse` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_po003`
-- (See below for the actual view)
--
CREATE TABLE `v_po003` (
`ponum` varchar(25)
,`potype` varchar(15)
,`podat` date
,`vendor` varchar(10)
,`namavendor` varchar(60)
,`note` text
,`currency` varchar(10)
,`approvestat` varchar(10)
,`appby` varchar(50)
,`completed` varchar(1)
,`createdon` datetime
,`createdby` varchar(50)
,`isgr` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_po004`
-- (See below for the actual view)
--
CREATE TABLE `v_po004` (
`ponum` varchar(25)
,`poitem` int(11)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`price` decimal(15,2)
,`ppn` int(11)
,`discount` decimal(15,2)
,`grqty` decimal(15,2)
,`prnum` varchar(15)
,`pritem` int(11)
,`grstatus` varchar(1)
,`pocomplete` varchar(1)
,`approvestat` varchar(1)
,`approvedby` varchar(50)
,`final_approve` varchar(1)
,`approvedate` date
,`paymentstat` varchar(1)
,`createdon` date
,`createdby` varchar(50)
,`mattypedesc` varchar(50)
,`subtotal` decimal(15,2)
,`unitprice` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pr001`
-- (See below for the actual view)
--
CREATE TABLE `v_pr001` (
`prnum` varchar(15)
,`typepr` varchar(10)
,`note` text
,`prdate` date
,`relgroup` varchar(10)
,`approvestat` varchar(10)
,`requestby` varchar(50)
,`warehouse` varchar(10)
,`createdon` datetime
,`createdby` varchar(50)
,`pritem` int(11)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(18,2)
,`unit` varchar(10)
,`pocreated` varchar(1)
,`whsname` varchar(40)
,`department` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pr002`
-- (See below for the actual view)
--
CREATE TABLE `v_pr002` (
`prnum` varchar(15)
,`typepr` varchar(10)
,`note` text
,`prdate` date
,`relgroup` varchar(10)
,`approvestat` varchar(10)
,`requestby` varchar(50)
,`warehouse` varchar(10)
,`idproject` int(11)
,`appby` varchar(50)
,`createdon` datetime
,`createdby` varchar(50)
,`deskripsi` varchar(40)
,`status` varchar(8)
,`department` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pr003`
-- (See below for the actual view)
--
CREATE TABLE `v_pr003` (
`prnum` varchar(15)
,`typepr` varchar(10)
,`note` text
,`prdate` date
,`relgroup` varchar(10)
,`approvestat` varchar(10)
,`requestby` varchar(50)
,`warehouse` varchar(10)
,`idproject` int(11)
,`appby` varchar(50)
,`createdon` datetime
,`createdby` varchar(50)
,`info` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pr004`
-- (See below for the actual view)
--
CREATE TABLE `v_pr004` (
`prnum` varchar(15)
,`pritem` int(11)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(18,2)
,`unit` varchar(10)
,`warehouse` int(11)
,`pocreated` varchar(1)
,`approvestat` varchar(10)
,`approveby` varchar(50)
,`remark` varchar(100)
,`createdon` datetime
,`createdby` varchar(50)
,`mattype` varchar(20)
,`mattypedesc` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pr005`
-- (See below for the actual view)
--
CREATE TABLE `v_pr005` (
`prnum` varchar(15)
,`pritem` int(11)
,`warehouse` varchar(10)
,`whsname` varchar(40)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(18,2)
,`openqty` double
,`unit` varchar(10)
,`pocreated` varchar(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_quotation`
-- (See below for the actual view)
--
CREATE TABLE `v_quotation` (
`bomid` varchar(30)
,`component` varchar(70)
,`partnumber` varchar(70)
,`quantity` decimal(15,2)
,`unit` varchar(15)
,`color` varchar(50)
,`stdprice` decimal(15,2)
,`stdpriceusd` decimal(15,4)
,`kurs` varchar(20)
,`value` double
,`currency` varchar(3)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rdefect`
-- (See below for the actual view)
--
CREATE TABLE `v_rdefect` (
`isnpecdate` date
,`defect` varchar(250)
,`jmlng` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rdelivery`
-- (See below for the actual view)
--
CREATE TABLE `v_rdelivery` (
`partnumber` varchar(70)
,`deliverydate` date
,`bomid` varchar(30)
,`reqqty` decimal(32,0)
,`delqty` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_reportdelivery`
-- (See below for the actual view)
--
CREATE TABLE `v_reportdelivery` (
`partnumber` varchar(70)
,`deliverydate` date
,`bomid` varchar(30)
,`reqqty` decimal(32,0)
,`delqty` decimal(32,0)
,`totalreq` decimal(34,0)
,`balance` decimal(35,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_reservasi01`
-- (See below for the actual view)
--
CREATE TABLE `v_reservasi01` (
`resnum` varchar(15)
,`resitem` int(11)
,`resdate` date
,`note` varchar(100)
,`requestor` varchar(50)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(10,0)
,`unit` varchar(15)
,`fromwhs` varchar(15)
,`whsname` varchar(20)
,`towhs` varchar(15)
,`whsdest` varchar(20)
,`remark` varchar(100)
,`movementstat` varchar(1)
,`department` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_reservasi02`
-- (See below for the actual view)
--
CREATE TABLE `v_reservasi02` (
`resnum` varchar(15)
,`requestor` varchar(50)
,`note` varchar(100)
,`resdate` date
,`towhs` varchar(15)
,`whsname` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rinvoice01`
-- (See below for the actual view)
--
CREATE TABLE `v_rinvoice01` (
`ivnum` varchar(15)
,`ivyear` int(11)
,`vendor` varchar(15)
,`total_invoice` decimal(15,2)
,`note` varchar(200)
,`bankacc` varchar(20)
,`ivdate` date
,`createdby` varchar(50)
,`createdon` date
,`approvestat` varchar(1)
,`approvedate` date
,`namavendor` varchar(60)
,`ivstat` varchar(8)
,`alamat` text
,`npwp` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rinvoice02`
-- (See below for the actual view)
--
CREATE TABLE `v_rinvoice02` (
`ivnum` varchar(15)
,`ivyear` int(11)
,`ivitem` int(11)
,`ponum` varchar(15)
,`poitem` int(11)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`price` decimal(15,2)
,`discount` decimal(15,2)
,`ppn` int(11)
,`totalprice` decimal(15,2)
,`netprice` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_role_activity`
-- (See below for the actual view)
--
CREATE TABLE `v_role_activity` (
`roleid` int(11)
,`menuid` int(11)
,`activity` varchar(10)
,`status` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_saldo_akhir`
-- (See below for the actual view)
--
CREATE TABLE `v_saldo_akhir` (
`id` int(11)
,`bankid` varchar(4)
,`bankno` varchar(30)
,`bankacc` varchar(100)
,`status` varchar(1)
,`deskripsi` varchar(50)
,`balance` decimal(15,2)
,`user` varchar(50)
,`saldo_akhir` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_service01`
-- (See below for the actual view)
--
CREATE TABLE `v_service01` (
`servicenum` varchar(20)
,`servicedate` date
,`note` text
,`mekanik` varchar(50)
,`nopol` varchar(15)
,`refnum` varchar(30)
,`servicestatus` varchar(2)
,`warehouse` varchar(10)
,`createdon` datetime
,`createdby` varchar(50)
,`whsname` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_service02`
-- (See below for the actual view)
--
CREATE TABLE `v_service02` (
`servicenum` varchar(20)
,`resitem` int(11)
,`servicedate` date
,`note` text
,`mekanik` varchar(50)
,`nopol` varchar(15)
,`material` varchar(70)
,`matdesc` varchar(100)
,`batchnumber` varchar(30)
,`quantity` decimal(15,2)
,`unit` varchar(10)
,`price` decimal(15,2)
,`subtotal` decimal(15,2)
,`warehouse` varchar(10)
,`whsname` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_service03`
-- (See below for the actual view)
--
CREATE TABLE `v_service03` (
`servicenum` varchar(20)
,`servicedate` date
,`note` text
,`mekanik` varchar(50)
,`nopol` varchar(15)
,`whsname` varchar(40)
,`servicestatus` varchar(2)
,`serviceitem` int(11)
,`material` varchar(70)
,`matdesc` varchar(100)
,`quantity` decimal(15,2)
,`unit` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stock`
-- (See below for the actual view)
--
CREATE TABLE `v_stock` (
`material` varchar(70)
,`matdesc` varchar(100)
,`warehouse` varchar(15)
,`deskripsi` varchar(40)
,`quantity` decimal(15,2)
,`matunit` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stockbatch`
-- (See below for the actual view)
--
CREATE TABLE `v_stockbatch` (
`material` varchar(15)
,`matdesc` varchar(100)
,`warehouse` varchar(20)
,`whsname` varchar(40)
,`batch` varchar(20)
,`quantity` decimal(15,2)
,`matunit` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stockwip`
-- (See below for the actual view)
--
CREATE TABLE `v_stockwip` (
`area` int(11)
,`deskripsi` varchar(255)
,`bomid` varchar(30)
,`partnumber` varchar(70)
,`partname` varchar(70)
,`customer` varchar(100)
,`period` date
,`quantity` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_totalstock`
-- (See below for the actual view)
--
CREATE TABLE `v_totalstock` (
`material` varchar(70)
,`matdesc` varchar(100)
,`qty` decimal(37,2)
,`matunit` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user`
-- (See below for the actual view)
--
CREATE TABLE `v_user` (
`username` varchar(100)
,`password` varchar(255)
,`nama` varchar(50)
,`userlevel` varchar(20)
,`department` int(11)
,`jabatan` int(11)
,`createdby` varchar(50)
,`createdon` date
,`deptname` varchar(50)
,`jbtn` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_menu`
-- (See below for the actual view)
--
CREATE TABLE `v_user_menu` (
`username` varchar(100)
,`roleid` int(11)
,`rolename` varchar(50)
,`menuid` int(11)
,`id` int(11)
,`menu` varchar(50)
,`route` varchar(50)
,`type` varchar(20)
,`grouping` varchar(30)
,`icon` varchar(50)
,`createdon` datetime
,`createdby` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_role_avtivity`
-- (See below for the actual view)
--
CREATE TABLE `v_user_role_avtivity` (
`roleid` int(11)
,`menuid` int(11)
,`activity` varchar(10)
,`status` tinyint(1)
,`createdon` date
,`route` varchar(50)
,`menu` varchar(50)
,`username` varchar(100)
,`rolename` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_wip01`
-- (See below for the actual view)
--
CREATE TABLE `v_wip01` (
`wipid` varchar(30)
,`wiptype` varchar(5)
,`from_area` int(11)
,`area1` varchar(20)
,`dest_area` int(11)
,`area2` varchar(20)
,`bomid` varchar(30)
,`partnumber` varchar(70)
,`customer` varchar(100)
,`quantity` int(11)
,`periode` date
,`createdby` varchar(50)
,`createdon` date
,`qty` bigint(12)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_wos01`
-- (See below for the actual view)
--
CREATE TABLE `v_wos01` (
`id` int(11)
,`reffid` varchar(25)
,`partnumber` varchar(70)
,`quantity` int(11)
,`wpnumber` int(11)
,`circuitno` int(11)
,`stardate` date
,`enddate` date
,`wos_status` int(11)
,`createdby` varchar(50)
,`createdon` date
,`imagelink` text
,`wosstat` varchar(11)
);

-- --------------------------------------------------------

--
-- Structure for view `t_totalcycletime`
--
DROP TABLE IF EXISTS `t_totalcycletime`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `t_totalcycletime`  AS  select `a`.`bomid` AS `bomid`,`a`.`activity` AS `activity`,`a`.`partnumber` AS `partnumber`,`a`.`quantity` AS `quantity`,`b`.`cycletime` AS `cycletime`,(`a`.`quantity` * `b`.`cycletime`) AS `totaltime` from (`t_cost02` `a` join `t_activity` `b` on((`a`.`activity` = `b`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_bank_master`
--
DROP TABLE IF EXISTS `v_bank_master`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_bank_master`  AS  select `a`.`id` AS `id`,`a`.`bankid` AS `bankid`,`a`.`bankno` AS `bankno`,`a`.`bankacc` AS `bankacc`,`a`.`status` AS `status`,`b`.`deskripsi` AS `deskripsi`,`a`.`balance` AS `balance`,`a`.`user` AS `user` from (`t_bank` `a` join `t_bank_list` `b` on((`a`.`bankid` = `b`.`bankey`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_cost01`
--
DROP TABLE IF EXISTS `v_cost01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cost01`  AS  select `a`.`bomid` AS `bomid`,`a`.`partnumber` AS `partnumber`,`b`.`partname` AS `partname`,`b`.`customer` AS `customer`,`b`.`qtycct` AS `qtycct` from (`t_cost01` `a` join `t_bom01` `b` on((`a`.`bomid` = `b`.`bomid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_detailcost`
--
DROP TABLE IF EXISTS `v_detailcost`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detailcost`  AS  select `a`.`bomid` AS `bomid`,`b`.`id` AS `id`,`b`.`activity` AS `activity`,`b`.`cycletime` AS `cycletime`,`a`.`quantity` AS `quantity`,format((`a`.`quantity` * `b`.`cycletime`),2) AS `totaltime`,`b`.`cycvleunit` AS `cycvleunit`,`a`.`partnumber` AS `partnumber` from (`t_cost02` `a` join `t_activity` `b` on((`a`.`activity` = `b`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_inventory01`
--
DROP TABLE IF EXISTS `v_inventory01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_inventory01`  AS  select `a`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`partname` AS `partname`,`b`.`partnumber` AS `partnumber`,`a`.`warehouse` AS `warehouse`,`c`.`deskripsi` AS `deskripsi`,`a`.`quantity` AS `quantity`,`b`.`matunit` AS `matunit` from ((`t_stock` `a` join `t_material` `b` on((`a`.`material` = `b`.`material`))) join `t_gudang` `c` on((`a`.`warehouse` = `c`.`gudang`))) order by `a`.`material`,`a`.`warehouse` ;

-- --------------------------------------------------------

--
-- Structure for view `v_inventory02`
--
DROP TABLE IF EXISTS `v_inventory02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_inventory02`  AS  select `a`.`grnum` AS `grnum`,`a`.`year` AS `year`,`a`.`gritem` AS `gritem`,`b`.`movement` AS `movement`,`b`.`movementdate` AS `movementdate`,`b`.`note` AS `note`,`a`.`material` AS `material`,`a`.`matdesc` AS `matdesc`,`a`.`quantity` AS `quantity`,`a`.`unit` AS `unit`,`a`.`ponum` AS `ponum`,`a`.`poitem` AS `poitem`,`a`.`remark` AS `remark`,`a`.`warehouse` AS `warehouse`,`c`.`price` AS `price`,`d`.`vendor` AS `vendor`,`f`.`namavendor` AS `namavendor` from ((((`t_inv_i` `a` join `t_inv_h` `b` on(((`a`.`grnum` = `b`.`grnum`) and (`a`.`year` = `b`.`year`)))) join `t_po02` `c` on(((`a`.`ponum` = `c`.`ponum`) and (`a`.`poitem` = `c`.`poitem`)))) join `t_po01` `d` on((`c`.`ponum` = `d`.`ponum`))) join `t_vendor` `f` on((`d`.`vendor` = `f`.`vendor`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_inventory03`
--
DROP TABLE IF EXISTS `v_inventory03`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_inventory03`  AS  select `b`.`grnum` AS `grnum`,`b`.`year` AS `year`,`a`.`gritem` AS `gritem`,`b`.`movement` AS `movement`,`b`.`movementdate` AS `movementdate`,(case when (`a`.`movement` = '101') then 'Penerimaan PO' when (`a`.`movement` = '201') then 'Transfer reservation' when (`a`.`movement` = '211') then 'Transfer other' when (`a`.`movement` = '261') then 'Pemakain Material' when (`a`.`movement` = '561') then 'Penerimaan Lain-lain' end) AS `movemventtext`,`b`.`note` AS `note`,`a`.`batchnumber` AS `batchnumber`,`a`.`material` AS `material`,`a`.`matdesc` AS `matdesc`,`a`.`quantity` AS `quantity`,`a`.`unit` AS `unit`,`a`.`ponum` AS `ponum`,`a`.`poitem` AS `poitem`,`a`.`resnum` AS `resnum`,`a`.`resitem` AS `resitem`,`a`.`remark` AS `remark`,`a`.`warehouse` AS `warehouse`,`fGetWarehouseName`(`a`.`warehouse`) AS `whsname`,`a`.`warehouseto` AS `warehouseto`,`fGetWarehouseName`(`a`.`warehouseto`) AS `whsdest`,`a`.`shkzg` AS `shkzg`,`a`.`createdby` AS `createdby`,`fGetUserDepartment`(`a`.`createdby`) AS `department` from (`t_inv_i` `a` join `t_inv_h` `b` on(((`a`.`grnum` = `b`.`grnum`) and (`a`.`year` = `b`.`year`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_payment01`
--
DROP TABLE IF EXISTS `v_payment01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_payment01`  AS  select distinct `a`.`ponum` AS `ponum`,`a`.`podat` AS `podat`,`a`.`note` AS `note`,`a`.`vendor` AS `vendor`,`b`.`namavendor` AS `namavendor`,cast(`fGetTotalValuePO`(`a`.`ponum`) as decimal(15,2)) AS `povalue` from ((`t_po01` `a` join `t_vendor` `b` on((`a`.`vendor` = `b`.`vendor`))) join `t_po02` `c` on((`a`.`ponum` = `c`.`ponum`))) where ((`c`.`final_approve` = 'X') and isnull(`c`.`paymentstat`) and (`c`.`approvestat` <> 5)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_payment02`
--
DROP TABLE IF EXISTS `v_payment02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_payment02`  AS  select `a`.`ivnum` AS `ivnum`,`a`.`ivyear` AS `ivyear`,`a`.`ivitem` AS `ivitem`,`a`.`ponum` AS `ponum`,`a`.`poitem` AS `poitem`,`a`.`ivdate` AS `ivdate`,`b`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`mattypedesc` AS `mattypedesc`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit`,`b`.`price` AS `price`,`b`.`ppn` AS `ppn`,`b`.`discount` AS `discount`,cast(`b`.`subtotal` as decimal(15,2)) AS `subtotal`,`b`.`prnum` AS `prnum`,`b`.`pritem` AS `pritem`,`b`.`final_approve` AS `final_approve`,`b`.`paymentstat` AS `paymentstat` from (`t_invoice02` `a` join `v_po004` `b` on(((`a`.`ponum` = `b`.`ponum`) and (`a`.`poitem` = `b`.`poitem`)))) order by `a`.`ivnum`,`a`.`ivitem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_po001`
--
DROP TABLE IF EXISTS `v_po001`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_po001`  AS  select distinct `a`.`ponum` AS `ponum`,`a`.`ext_ponum` AS `ext_ponum`,`a`.`potype` AS `potype`,`a`.`podat` AS `podat`,`a`.`vendor` AS `vendor`,`a`.`note` AS `note`,`a`.`currency` AS `currency`,`c`.`approvestat` AS `approvestat`,`a`.`appby` AS `appby`,`a`.`completed` AS `completed`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`namavendor` AS `namavendor`,`b`.`alamat` AS `alamat`,`b`.`notelp` AS `notelp`,`b`.`email` AS `email`,`fGetUserDepartment`(`a`.`createdby`) AS `department`,(case when (`c`.`approvestat` = '1') then 'Open' when (`c`.`approvestat` = '2') then 'Approved' when (`c`.`approvestat` = '3') then 'Rejected' when (`c`.`approvestat` = '4') then 'Closed' end) AS `postat`,`a`.`warehouse` AS `warehouse` from ((`t_po01` `a` join `t_vendor` `b` on((`a`.`vendor` = `b`.`vendor`))) join `t_po02` `c` on((`a`.`ponum` = `c`.`ponum`))) where isnull(`c`.`final_approve`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_po002`
--
DROP TABLE IF EXISTS `v_po002`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_po002`  AS  select distinct `a`.`ponum` AS `ponum`,`a`.`vendor` AS `vendor`,`c`.`namavendor` AS `namavendor`,`a`.`podat` AS `podat`,`a`.`note` AS `note`,`a`.`warehouse` AS `warehouse` from ((`t_po01` `a` join `t_po02` `b` on((`a`.`ponum` = `b`.`ponum`))) join `t_vendor` `c` on((`a`.`vendor` = `c`.`vendor`))) where ((`b`.`final_approve` = 'X') and isnull(`b`.`grstatus`) and isnull(`b`.`pocomplete`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_po003`
--
DROP TABLE IF EXISTS `v_po003`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_po003`  AS  select `t_po01`.`ponum` AS `ponum`,`t_po01`.`potype` AS `potype`,`t_po01`.`podat` AS `podat`,`t_po01`.`vendor` AS `vendor`,`b`.`namavendor` AS `namavendor`,`t_po01`.`note` AS `note`,`t_po01`.`currency` AS `currency`,`t_po01`.`approvestat` AS `approvestat`,`t_po01`.`appby` AS `appby`,`t_po01`.`completed` AS `completed`,`t_po01`.`createdon` AS `createdon`,`t_po01`.`createdby` AS `createdby`,`fCheckPOIsGR`(`t_po01`.`ponum`) AS `isgr` from (`t_po01` left join `t_vendor` `b` on((`t_po01`.`vendor` = `b`.`vendor`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_po004`
--
DROP TABLE IF EXISTS `v_po004`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_po004`  AS  select `a`.`ponum` AS `ponum`,`a`.`poitem` AS `poitem`,`a`.`material` AS `material`,`a`.`matdesc` AS `matdesc`,`a`.`quantity` AS `quantity`,`a`.`unit` AS `unit`,`a`.`price` AS `price`,`a`.`ppn` AS `ppn`,`a`.`discount` AS `discount`,`a`.`grqty` AS `grqty`,`a`.`prnum` AS `prnum`,`a`.`pritem` AS `pritem`,`a`.`grstatus` AS `grstatus`,`a`.`pocomplete` AS `pocomplete`,`a`.`approvestat` AS `approvestat`,`a`.`approvedby` AS `approvedby`,`a`.`final_approve` AS `final_approve`,`a`.`approvedate` AS `approvedate`,`a`.`paymentstat` AS `paymentstat`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`c`.`mattypedesc` AS `mattypedesc`,cast((((`a`.`quantity` * `a`.`price`) - `a`.`discount`) + (((`a`.`quantity` * `a`.`price`) - `a`.`discount`) * (`a`.`ppn` / 100))) as decimal(15,2)) AS `subtotal`,cast(((((`a`.`quantity` * `a`.`price`) - `a`.`discount`) + (((`a`.`quantity` * `a`.`price`) - `a`.`discount`) * (`a`.`ppn` / 100))) / `a`.`quantity`) as decimal(15,2)) AS `unitprice` from ((`t_po02` `a` join `t_material` `b` on((`a`.`material` = `b`.`material`))) join `t_materialtype` `c` on((`b`.`mattype` = `c`.`mattype`))) order by `a`.`ponum`,`a`.`poitem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_pr001`
--
DROP TABLE IF EXISTS `v_pr001`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pr001`  AS  select `a`.`prnum` AS `prnum`,`a`.`typepr` AS `typepr`,`a`.`note` AS `note`,`a`.`prdate` AS `prdate`,`a`.`relgroup` AS `relgroup`,`a`.`approvestat` AS `approvestat`,`a`.`requestby` AS `requestby`,`a`.`warehouse` AS `warehouse`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`pritem` AS `pritem`,`b`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit`,`b`.`pocreated` AS `pocreated`,`c`.`deskripsi` AS `whsname`,`fGetUserDepartment`(`a`.`createdby`) AS `department` from ((`t_pr01` `a` join `t_pr02` `b` on((`a`.`prnum` = `b`.`prnum`))) join `t_gudang` `c` on((`a`.`warehouse` = `c`.`gudang`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pr002`
--
DROP TABLE IF EXISTS `v_pr002`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pr002`  AS  select `a`.`prnum` AS `prnum`,`a`.`typepr` AS `typepr`,`a`.`note` AS `note`,`a`.`prdate` AS `prdate`,`a`.`relgroup` AS `relgroup`,`a`.`approvestat` AS `approvestat`,`a`.`requestby` AS `requestby`,`a`.`warehouse` AS `warehouse`,`a`.`idproject` AS `idproject`,`a`.`appby` AS `appby`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`deskripsi` AS `deskripsi`,(case when (`a`.`approvestat` = '1') then 'Open' when (`a`.`approvestat` = '2') then 'Approved' when (`a`.`approvestat` = '3') then 'Rejected' end) AS `status`,`fGetUserDepartment`(`a`.`createdby`) AS `department` from (`t_pr01` `a` left join `t_gudang` `b` on((`a`.`warehouse` = `b`.`gudang`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pr003`
--
DROP TABLE IF EXISTS `v_pr003`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pr003`  AS  select `t_pr01`.`prnum` AS `prnum`,`t_pr01`.`typepr` AS `typepr`,`t_pr01`.`note` AS `note`,`t_pr01`.`prdate` AS `prdate`,`t_pr01`.`relgroup` AS `relgroup`,`t_pr01`.`approvestat` AS `approvestat`,`t_pr01`.`requestby` AS `requestby`,`t_pr01`.`warehouse` AS `warehouse`,`t_pr01`.`idproject` AS `idproject`,`t_pr01`.`appby` AS `appby`,`t_pr01`.`createdon` AS `createdon`,`t_pr01`.`createdby` AS `createdby`,`fCheckPRIsPoCreated`(`t_pr01`.`prnum`) AS `info` from `t_pr01` ;

-- --------------------------------------------------------

--
-- Structure for view `v_pr004`
--
DROP TABLE IF EXISTS `v_pr004`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pr004`  AS  select `a`.`prnum` AS `prnum`,`a`.`pritem` AS `pritem`,`a`.`material` AS `material`,`a`.`matdesc` AS `matdesc`,`a`.`quantity` AS `quantity`,`a`.`unit` AS `unit`,`a`.`warehouse` AS `warehouse`,`a`.`pocreated` AS `pocreated`,`a`.`approvestat` AS `approvestat`,`a`.`approveby` AS `approveby`,`a`.`remark` AS `remark`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`mattype` AS `mattype`,`c`.`mattypedesc` AS `mattypedesc` from ((`t_pr02` `a` left join `t_material` `b` on((`a`.`material` = `b`.`material`))) join `t_materialtype` `c` on((`b`.`mattype` = `c`.`mattype`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pr005`
--
DROP TABLE IF EXISTS `v_pr005`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pr005`  AS  select `a`.`prnum` AS `prnum`,`a`.`pritem` AS `pritem`,`b`.`warehouse` AS `warehouse`,`c`.`deskripsi` AS `whsname`,`a`.`material` AS `material`,`a`.`matdesc` AS `matdesc`,`a`.`quantity` AS `quantity`,(case when ((`a`.`quantity` - `fGetOpenPRQty`(`a`.`prnum`,`a`.`pritem`)) > 0) then (`a`.`quantity` - `fGetOpenPRQty`(`a`.`prnum`,`a`.`pritem`)) else `a`.`quantity` end) AS `openqty`,`a`.`unit` AS `unit`,`a`.`pocreated` AS `pocreated` from ((`t_pr02` `a` join `t_pr01` `b` on((`a`.`prnum` = `b`.`prnum`))) left join `t_gudang` `c` on((`b`.`warehouse` = `c`.`gudang`))) where ((`a`.`final_approve` = 'X') and (`a`.`approvestat` <> 5) and isnull(`a`.`pocreated`)) order by `a`.`prnum`,`a`.`pritem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_quotation`
--
DROP TABLE IF EXISTS `v_quotation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_quotation`  AS  select `a`.`bomid` AS `bomid`,`a`.`component` AS `component`,`a`.`partnumber` AS `partnumber`,`a`.`quantity` AS `quantity`,`a`.`unit` AS `unit`,`b`.`color` AS `color`,`b`.`stdprice` AS `stdprice`,`b`.`stdpriceusd` AS `stdpriceusd`,`fCurrencyConvertion`('USD','IDR') AS `kurs`,(case when (`b`.`stdpriceusd` > 0) then (`b`.`stdpriceusd` * `fCurrencyConvertion`('USD','IDR')) when (`b`.`stdpriceusd` = 0) then `b`.`stdprice` end) AS `value`,(case when (`b`.`stdpriceusd` > 0) then 'USD' when (`b`.`stdpriceusd` = 0) then 'IDR' end) AS `currency` from (`t_bom02` `a` join `t_material` `b` on((`a`.`component` = `b`.`material`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_rdefect`
--
DROP TABLE IF EXISTS `v_rdefect`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rdefect`  AS  select `a`.`isnpecdate` AS `isnpecdate`,`b`.`jenisdefect` AS `defect`,sum(`a`.`jumlahng`) AS `jmlng` from (`t_inspection` `a` join `t_defect_jenis` `b` on((`a`.`jenisdefect` = `b`.`idjenis`))) group by `a`.`isnpecdate`,`b`.`jenisdefect` order by `a`.`isnpecdate` ;

-- --------------------------------------------------------

--
-- Structure for view `v_rdelivery`
--
DROP TABLE IF EXISTS `v_rdelivery`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rdelivery`  AS  select `t_delivery`.`partnumber` AS `partnumber`,`t_delivery`.`deliverydate` AS `deliverydate`,`t_delivery`.`bomid` AS `bomid`,sum(`t_delivery`.`reqqty`) AS `reqqty`,sum(`t_delivery`.`delqty`) AS `delqty` from `t_delivery` group by `t_delivery`.`partnumber`,`t_delivery`.`deliverydate`,`t_delivery`.`bomid` order by `t_delivery`.`deliverydate`,`t_delivery`.`partnumber` ;

-- --------------------------------------------------------

--
-- Structure for view `v_reportdelivery`
--
DROP TABLE IF EXISTS `v_reportdelivery`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reportdelivery`  AS  select `v_rdelivery`.`partnumber` AS `partnumber`,`v_rdelivery`.`deliverydate` AS `deliverydate`,`v_rdelivery`.`bomid` AS `bomid`,`v_rdelivery`.`reqqty` AS `reqqty`,`v_rdelivery`.`delqty` AS `delqty`,((`fGetTotalQtyReq`(`v_rdelivery`.`bomid`,`v_rdelivery`.`deliverydate`) + `v_rdelivery`.`reqqty`) - `fGetTotalQtyDel`(`v_rdelivery`.`bomid`,`v_rdelivery`.`deliverydate`)) AS `totalreq`,(`v_rdelivery`.`delqty` - ((`fGetTotalQtyReq`(`v_rdelivery`.`bomid`,`v_rdelivery`.`deliverydate`) + `v_rdelivery`.`reqqty`) - `fGetTotalQtyDel`(`v_rdelivery`.`bomid`,`v_rdelivery`.`deliverydate`))) AS `balance` from `v_rdelivery` ;

-- --------------------------------------------------------

--
-- Structure for view `v_reservasi01`
--
DROP TABLE IF EXISTS `v_reservasi01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reservasi01`  AS  select `a`.`resnum` AS `resnum`,`b`.`resitem` AS `resitem`,`a`.`resdate` AS `resdate`,`a`.`note` AS `note`,`a`.`requestor` AS `requestor`,`b`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit`,`b`.`fromwhs` AS `fromwhs`,`fGetWarehouseName`(`b`.`fromwhs`) AS `whsname`,`b`.`towhs` AS `towhs`,`fGetWarehouseName`(`b`.`fromwhs`) AS `whsdest`,`b`.`remark` AS `remark`,`b`.`movementstat` AS `movementstat`,`fGetUserDepartment`(`a`.`createdby`) AS `department` from (`t_reserv01` `a` join `t_reserv02` `b` on((`a`.`resnum` = `b`.`resnum`))) order by `a`.`resnum`,`b`.`resitem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_reservasi02`
--
DROP TABLE IF EXISTS `v_reservasi02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reservasi02`  AS  select distinct `a`.`resnum` AS `resnum`,`a`.`requestor` AS `requestor`,`a`.`note` AS `note`,`a`.`resdate` AS `resdate`,`a`.`towhs` AS `towhs`,`c`.`deskripsi` AS `whsname` from ((`t_reserv01` `a` join `t_reserv02` `b` on((`a`.`resnum` = `b`.`resnum`))) left join `t_gudang` `c` on((`a`.`towhs` = `c`.`gudang`))) where isnull(`b`.`movementstat`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_rinvoice01`
--
DROP TABLE IF EXISTS `v_rinvoice01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rinvoice01`  AS  select `a`.`ivnum` AS `ivnum`,`a`.`ivyear` AS `ivyear`,`a`.`vendor` AS `vendor`,`a`.`total_invoice` AS `total_invoice`,`a`.`note` AS `note`,`a`.`bankacc` AS `bankacc`,`a`.`ivdate` AS `ivdate`,`a`.`createdby` AS `createdby`,`a`.`createdon` AS `createdon`,`a`.`approvestat` AS `approvestat`,`a`.`approvedate` AS `approvedate`,`b`.`namavendor` AS `namavendor`,(case when isnull(`a`.`approvestat`) then 'Open' else 'Approved' end) AS `ivstat`,`b`.`alamat` AS `alamat`,`b`.`npwp` AS `npwp` from (`t_invoice01` `a` join `t_vendor` `b` on((`a`.`vendor` = `b`.`vendor`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_rinvoice02`
--
DROP TABLE IF EXISTS `v_rinvoice02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rinvoice02`  AS  select `a`.`ivnum` AS `ivnum`,`a`.`ivyear` AS `ivyear`,`a`.`ivitem` AS `ivitem`,`a`.`ponum` AS `ponum`,`a`.`poitem` AS `poitem`,`b`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit`,`b`.`price` AS `price`,`b`.`discount` AS `discount`,`b`.`ppn` AS `ppn`,cast((((`b`.`quantity` * `b`.`price`) - `b`.`discount`) + ((((`b`.`quantity` * `b`.`price`) - `b`.`discount`) * `b`.`ppn`) / 100)) as decimal(15,2)) AS `totalprice`,cast(((((`b`.`quantity` * `b`.`price`) - `b`.`discount`) + ((((`b`.`quantity` * `b`.`price`) - `b`.`discount`) * `b`.`ppn`) / 100)) / `b`.`quantity`) as decimal(15,2)) AS `netprice` from (`t_invoice02` `a` join `t_po02` `b` on(((`a`.`ponum` = `b`.`ponum`) and (`a`.`poitem` = `b`.`poitem`)))) order by `a`.`ivnum`,`a`.`ivyear`,`a`.`ivitem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_role_activity`
--
DROP TABLE IF EXISTS `v_role_activity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_role_activity`  AS  select `a`.`roleid` AS `roleid`,`a`.`menuid` AS `menuid`,`b`.`activity` AS `activity`,`b`.`status` AS `status` from (`t_rolemenu` `a` join `t_role_avtivity` `b` on(((`a`.`roleid` = `b`.`roleid`) and (`a`.`menuid` = `b`.`menuid`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_saldo_akhir`
--
DROP TABLE IF EXISTS `v_saldo_akhir`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_saldo_akhir`  AS  select `v_bank_master`.`id` AS `id`,`v_bank_master`.`bankid` AS `bankid`,`v_bank_master`.`bankno` AS `bankno`,`v_bank_master`.`bankacc` AS `bankacc`,`v_bank_master`.`status` AS `status`,`v_bank_master`.`deskripsi` AS `deskripsi`,`v_bank_master`.`balance` AS `balance`,`v_bank_master`.`user` AS `user`,`fGetSaldo`(`v_bank_master`.`bankno`) AS `saldo_akhir` from `v_bank_master` ;

-- --------------------------------------------------------

--
-- Structure for view `v_service01`
--
DROP TABLE IF EXISTS `v_service01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_service01`  AS  select `a`.`servicenum` AS `servicenum`,`a`.`servicedate` AS `servicedate`,`a`.`note` AS `note`,`a`.`mekanik` AS `mekanik`,`a`.`nopol` AS `nopol`,`a`.`refnum` AS `refnum`,`a`.`servicestatus` AS `servicestatus`,`a`.`warehouse` AS `warehouse`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`deskripsi` AS `whsname` from (`t_service01` `a` left join `t_gudang` `b` on((`a`.`warehouse` = `b`.`gudang`))) where (`a`.`servicestatus` = 'X') ;

-- --------------------------------------------------------

--
-- Structure for view `v_service02`
--
DROP TABLE IF EXISTS `v_service02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_service02`  AS  select `a`.`servicenum` AS `servicenum`,`b`.`resitem` AS `resitem`,`a`.`servicedate` AS `servicedate`,`a`.`note` AS `note`,`a`.`mekanik` AS `mekanik`,`a`.`nopol` AS `nopol`,`b`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`b`.`batchnumber` AS `batchnumber`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit`,`b`.`price` AS `price`,cast((`b`.`price` * `b`.`quantity`) as decimal(15,2)) AS `subtotal`,`b`.`warehouse` AS `warehouse`,`c`.`deskripsi` AS `whsname` from ((`t_service01` `a` join `t_inv_i` `b` on((`a`.`servicenum` = `b`.`resnum`))) left join `t_gudang` `c` on((`b`.`warehouse` = `c`.`gudang`))) where (`b`.`movement` = '261') ;

-- --------------------------------------------------------

--
-- Structure for view `v_service03`
--
DROP TABLE IF EXISTS `v_service03`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_service03`  AS  select `a`.`servicenum` AS `servicenum`,`a`.`servicedate` AS `servicedate`,`a`.`note` AS `note`,`a`.`mekanik` AS `mekanik`,`a`.`nopol` AS `nopol`,`c`.`deskripsi` AS `whsname`,`a`.`servicestatus` AS `servicestatus`,`b`.`serviceitem` AS `serviceitem`,`b`.`material` AS `material`,`d`.`matdesc` AS `matdesc`,`b`.`quantity` AS `quantity`,`b`.`unit` AS `unit` from (((`t_service01` `a` join `t_service02` `b` on((`a`.`servicenum` = `b`.`servicenum`))) left join `t_gudang` `c` on((`a`.`warehouse` = `c`.`gudang`))) left join `t_material` `d` on((`b`.`material` = `d`.`material`))) order by `a`.`servicenum`,`b`.`serviceitem` ;

-- --------------------------------------------------------

--
-- Structure for view `v_stock`
--
DROP TABLE IF EXISTS `v_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stock`  AS  select `a`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`a`.`warehouse` AS `warehouse`,`c`.`deskripsi` AS `deskripsi`,`a`.`quantity` AS `quantity`,`b`.`matunit` AS `matunit` from ((`t_stock` `a` left join `t_material` `b` on((`a`.`material` = `b`.`material`))) left join `t_gudang` `c` on((`a`.`warehouse` = `c`.`gudang`))) order by `a`.`material`,`a`.`warehouse` ;

-- --------------------------------------------------------

--
-- Structure for view `v_stockbatch`
--
DROP TABLE IF EXISTS `v_stockbatch`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stockbatch`  AS  select `a`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,`a`.`warehouse` AS `warehouse`,`c`.`deskripsi` AS `whsname`,`a`.`batch` AS `batch`,`a`.`quantity` AS `quantity`,`b`.`matunit` AS `matunit` from ((`t_batch_stock` `a` join `t_material` `b` on((`a`.`material` = `b`.`material`))) left join `t_gudang` `c` on((`a`.`warehouse` = `c`.`gudang`))) order by `a`.`material`,`a`.`warehouse`,`a`.`batch` ;

-- --------------------------------------------------------

--
-- Structure for view `v_stockwip`
--
DROP TABLE IF EXISTS `v_stockwip`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stockwip`  AS  select `a`.`area` AS `area`,`c`.`deskripsi` AS `deskripsi`,`a`.`bomid` AS `bomid`,`b`.`partnumber` AS `partnumber`,`b`.`partname` AS `partname`,`b`.`customer` AS `customer`,`a`.`period` AS `period`,`a`.`quantity` AS `quantity` from ((`t_wip_stock` `a` join `t_bom01` `b` on((`a`.`bomid` = `b`.`bomid`))) join `t_meja` `c` on((`a`.`area` = `c`.`nomeja`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_totalstock`
--
DROP TABLE IF EXISTS `v_totalstock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_totalstock`  AS  select `a`.`material` AS `material`,`b`.`matdesc` AS `matdesc`,sum(`a`.`quantity`) AS `qty`,`b`.`matunit` AS `matunit` from (`t_stock` `a` join `t_material` `b` on((`a`.`material` = `b`.`material`))) group by `a`.`material`,`b`.`matdesc`,`b`.`matunit` order by `a`.`material` ;

-- --------------------------------------------------------

--
-- Structure for view `v_user`
--
DROP TABLE IF EXISTS `v_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user`  AS  select `a`.`username` AS `username`,`a`.`password` AS `password`,`a`.`nama` AS `nama`,`a`.`userlevel` AS `userlevel`,`a`.`department` AS `department`,`a`.`jabatan` AS `jabatan`,`a`.`createdby` AS `createdby`,`a`.`createdon` AS `createdon`,`b`.`department` AS `deptname`,`c`.`jabatan` AS `jbtn` from ((`t_user` `a` left join `t_department` `b` on((`a`.`department` = `b`.`id`))) left join `t_jabatan` `c` on((`a`.`jabatan` = `c`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_menu`
--
DROP TABLE IF EXISTS `v_user_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_menu`  AS  select `a`.`username` AS `username`,`b`.`roleid` AS `roleid`,`f`.`rolename` AS `rolename`,`c`.`menuid` AS `menuid`,`d`.`id` AS `id`,`d`.`menu` AS `menu`,`d`.`route` AS `route`,`d`.`type` AS `type`,`d`.`grouping` AS `grouping`,`d`.`icon` AS `icon`,`d`.`createdon` AS `createdon`,`d`.`createdby` AS `createdby` from ((((`t_user` `a` join `t_user_role` `b` on((`a`.`username` = `b`.`username`))) join `t_rolemenu` `c` on((`c`.`roleid` = `b`.`roleid`))) join `t_menus` `d` on((`d`.`id` = `c`.`menuid`))) join `t_role` `f` on((`f`.`roleid` = `b`.`roleid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_role_avtivity`
--
DROP TABLE IF EXISTS `v_user_role_avtivity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_role_avtivity`  AS  select `a`.`roleid` AS `roleid`,`a`.`menuid` AS `menuid`,`a`.`activity` AS `activity`,`a`.`status` AS `status`,`a`.`createdon` AS `createdon`,`b`.`route` AS `route`,`b`.`menu` AS `menu`,`c`.`username` AS `username`,`d`.`rolename` AS `rolename` from (((`t_role_avtivity` `a` join `t_menus` `b` on((`a`.`menuid` = `b`.`id`))) join `t_user_role` `c` on((`a`.`roleid` = `c`.`roleid`))) join `t_role` `d` on((`a`.`roleid` = `d`.`roleid`))) order by `c`.`username`,`d`.`rolename` ;

-- --------------------------------------------------------

--
-- Structure for view `v_wip01`
--
DROP TABLE IF EXISTS `v_wip01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wip01`  AS  select `t_wip`.`wipid` AS `wipid`,`t_wip`.`wiptype` AS `wiptype`,`t_wip`.`from_area` AS `from_area`,`fGetAreaDesc`(`t_wip`.`from_area`) AS `area1`,`t_wip`.`dest_area` AS `dest_area`,`fGetAreaDesc`(`t_wip`.`dest_area`) AS `area2`,`t_wip`.`bomid` AS `bomid`,`t_wip`.`partnumber` AS `partnumber`,`t_wip`.`customer` AS `customer`,`t_wip`.`quantity` AS `quantity`,`t_wip`.`periode` AS `periode`,`t_wip`.`createdby` AS `createdby`,`t_wip`.`createdon` AS `createdon`,(case when (`t_wip`.`wiptype` = 'IN') then `t_wip`.`quantity` when (`t_wip`.`wiptype` = 'OUT') then (`t_wip`.`quantity` * -(1)) end) AS `qty` from `t_wip` ;

-- --------------------------------------------------------

--
-- Structure for view `v_wos01`
--
DROP TABLE IF EXISTS `v_wos01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wos01`  AS  select `a`.`id` AS `id`,`a`.`reffid` AS `reffid`,`a`.`partnumber` AS `partnumber`,`a`.`quantity` AS `quantity`,`a`.`wpnumber` AS `wpnumber`,`a`.`circuitno` AS `circuitno`,`a`.`stardate` AS `stardate`,`a`.`enddate` AS `enddate`,`a`.`wos_status` AS `wos_status`,`a`.`createdby` AS `createdby`,`a`.`createdon` AS `createdon`,`b`.`imagelink` AS `imagelink`,(case when (`a`.`wos_status` = '1') then 'On progress' when (`a`.`wos_status` = '2') then 'Closed' end) AS `wosstat` from (`t_wos01` `a` left join `t_wos_image` `b` on(((`a`.`circuitno` = `b`.`circuitno`) and (`a`.`partnumber` = `b`.`partnumber`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblproject`
--
ALTER TABLE `tblproject`
  ADD PRIMARY KEY (`idproject`);

--
-- Indexes for table `tblsetting`
--
ALTER TABLE `tblsetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_activity`
--
ALTER TABLE `t_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_approval`
--
ALTER TABLE `t_approval`
  ADD PRIMARY KEY (`object`,`level`,`creator`,`approval`);

--
-- Indexes for table `t_arus_kas`
--
ALTER TABLE `t_arus_kas`
  ADD PRIMARY KEY (`transnum`);

--
-- Indexes for table `t_auth_object`
--
ALTER TABLE `t_auth_object`
  ADD PRIMARY KEY (`ob_auth`);

--
-- Indexes for table `t_bank`
--
ALTER TABLE `t_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_bank_list`
--
ALTER TABLE `t_bank_list`
  ADD PRIMARY KEY (`bankey`);

--
-- Indexes for table `t_batch_stock`
--
ALTER TABLE `t_batch_stock`
  ADD PRIMARY KEY (`material`,`warehouse`,`batch`);

--
-- Indexes for table `t_bom01`
--
ALTER TABLE `t_bom01`
  ADD PRIMARY KEY (`bomid`),
  ADD KEY `partnumber` (`partnumber`);

--
-- Indexes for table `t_bom02`
--
ALTER TABLE `t_bom02`
  ADD PRIMARY KEY (`bomid`,`partnumber`,`component`),
  ADD KEY `component` (`component`),
  ADD KEY `partnumber` (`partnumber`);

--
-- Indexes for table `t_config01`
--
ALTER TABLE `t_config01`
  ADD PRIMARY KEY (`object`);

--
-- Indexes for table `t_cost01`
--
ALTER TABLE `t_cost01`
  ADD PRIMARY KEY (`bomid`);

--
-- Indexes for table `t_cost02`
--
ALTER TABLE `t_cost02`
  ADD PRIMARY KEY (`bomid`,`activity`);

--
-- Indexes for table `t_currency`
--
ALTER TABLE `t_currency`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `t_defect_jenis`
--
ALTER TABLE `t_defect_jenis`
  ADD PRIMARY KEY (`idjenis`,`idsection`);

--
-- Indexes for table `t_defect_process`
--
ALTER TABLE `t_defect_process`
  ADD PRIMARY KEY (`idprocess`,`idsection`);

--
-- Indexes for table `t_defect_section`
--
ALTER TABLE `t_defect_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_delivery`
--
ALTER TABLE `t_delivery`
  ADD PRIMARY KEY (`deliveryid`);

--
-- Indexes for table `t_department`
--
ALTER TABLE `t_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_dept_section`
--
ALTER TABLE `t_dept_section`
  ADD PRIMARY KEY (`deptid`,`sectionid`);

--
-- Indexes for table `t_files`
--
ALTER TABLE `t_files`
  ADD PRIMARY KEY (`object`,`refdoc`,`item`);

--
-- Indexes for table `t_gudang`
--
ALTER TABLE `t_gudang`
  ADD PRIMARY KEY (`plant`,`gudang`);

--
-- Indexes for table `t_ikpf`
--
ALTER TABLE `t_ikpf`
  ADD PRIMARY KEY (`docnum`),
  ADD KEY `createdon` (`createdon`);

--
-- Indexes for table `t_inspection`
--
ALTER TABLE `t_inspection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_invmvt`
--
ALTER TABLE `t_invmvt`
  ADD PRIMARY KEY (`movement`);

--
-- Indexes for table `t_invoice01`
--
ALTER TABLE `t_invoice01`
  ADD PRIMARY KEY (`ivnum`,`ivyear`);

--
-- Indexes for table `t_invoice02`
--
ALTER TABLE `t_invoice02`
  ADD PRIMARY KEY (`ivnum`,`ivyear`,`ivitem`);

--
-- Indexes for table `t_inv_h`
--
ALTER TABLE `t_inv_h`
  ADD PRIMARY KEY (`grnum`,`year`),
  ADD KEY `movement` (`movement`,`movementdate`);

--
-- Indexes for table `t_inv_i`
--
ALTER TABLE `t_inv_i`
  ADD PRIMARY KEY (`grnum`,`year`,`gritem`),
  ADD KEY `grnum` (`grnum`,`year`,`gritem`,`material`,`ponum`),
  ADD KEY `movement` (`movement`,`resnum`),
  ADD KEY `batchnumber` (`batchnumber`);

--
-- Indexes for table `t_iseg`
--
ALTER TABLE `t_iseg`
  ADD PRIMARY KEY (`docnum`,`docitem`),
  ADD KEY `material` (`material`);

--
-- Indexes for table `t_jabatan`
--
ALTER TABLE `t_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_jenis_defect`
--
ALTER TABLE `t_jenis_defect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kurs`
--
ALTER TABLE `t_kurs`
  ADD PRIMARY KEY (`currency1`);

--
-- Indexes for table `t_lockdata`
--
ALTER TABLE `t_lockdata`
  ADD PRIMARY KEY (`object`,`docnum`);

--
-- Indexes for table `t_mapp_user_reffid`
--
ALTER TABLE `t_mapp_user_reffid`
  ADD PRIMARY KEY (`reffid`,`username`);

--
-- Indexes for table `t_material`
--
ALTER TABLE `t_material`
  ADD PRIMARY KEY (`material`);

--
-- Indexes for table `t_material2`
--
ALTER TABLE `t_material2`
  ADD PRIMARY KEY (`material`,`altuom`);

--
-- Indexes for table `t_materialtype`
--
ALTER TABLE `t_materialtype`
  ADD PRIMARY KEY (`mattype`);

--
-- Indexes for table `t_meja`
--
ALTER TABLE `t_meja`
  ADD PRIMARY KEY (`nomeja`);

--
-- Indexes for table `t_menus`
--
ALTER TABLE `t_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_nriv`
--
ALTER TABLE `t_nriv`
  ADD PRIMARY KEY (`object`);

--
-- Indexes for table `t_part_image`
--
ALTER TABLE `t_part_image`
  ADD PRIMARY KEY (`bomid`);

--
-- Indexes for table `t_plant`
--
ALTER TABLE `t_plant`
  ADD PRIMARY KEY (`plant`);

--
-- Indexes for table `t_po01`
--
ALTER TABLE `t_po01`
  ADD PRIMARY KEY (`ponum`),
  ADD KEY `podat` (`podat`,`vendor`);

--
-- Indexes for table `t_po02`
--
ALTER TABLE `t_po02`
  ADD PRIMARY KEY (`ponum`,`poitem`),
  ADD KEY `material` (`material`,`prnum`,`pritem`);

--
-- Indexes for table `t_pr01`
--
ALTER TABLE `t_pr01`
  ADD PRIMARY KEY (`prnum`),
  ADD KEY `prnum` (`prnum`),
  ADD KEY `typepr` (`typepr`),
  ADD KEY `prdate` (`prdate`),
  ADD KEY `warehouse` (`warehouse`);

--
-- Indexes for table `t_pr02`
--
ALTER TABLE `t_pr02`
  ADD PRIMARY KEY (`prnum`,`pritem`),
  ADD KEY `material` (`material`),
  ADD KEY `prnum` (`prnum`);

--
-- Indexes for table `t_quotation01`
--
ALTER TABLE `t_quotation01`
  ADD PRIMARY KEY (`quotation`);

--
-- Indexes for table `t_reserv01`
--
ALTER TABLE `t_reserv01`
  ADD PRIMARY KEY (`resnum`),
  ADD KEY `resdate` (`resdate`);

--
-- Indexes for table `t_reserv02`
--
ALTER TABLE `t_reserv02`
  ADD PRIMARY KEY (`resnum`,`resitem`),
  ADD KEY `material` (`material`,`fromwhs`,`towhs`);

--
-- Indexes for table `t_role`
--
ALTER TABLE `t_role`
  ADD PRIMARY KEY (`roleid`),
  ADD KEY `idxrolename` (`rolename`),
  ADD KEY `roleid` (`roleid`);

--
-- Indexes for table `t_rolemenu`
--
ALTER TABLE `t_rolemenu`
  ADD PRIMARY KEY (`roleid`,`menuid`),
  ADD KEY `roleid` (`roleid`),
  ADD KEY `menuid` (`menuid`);

--
-- Indexes for table `t_role_avtivity`
--
ALTER TABLE `t_role_avtivity`
  ADD PRIMARY KEY (`roleid`,`menuid`,`activity`);

--
-- Indexes for table `t_service01`
--
ALTER TABLE `t_service01`
  ADD PRIMARY KEY (`servicenum`);

--
-- Indexes for table `t_service02`
--
ALTER TABLE `t_service02`
  ADD PRIMARY KEY (`servicenum`,`serviceitem`);

--
-- Indexes for table `t_stock`
--
ALTER TABLE `t_stock`
  ADD PRIMARY KEY (`material`,`warehouse`);

--
-- Indexes for table `t_uom`
--
ALTER TABLE `t_uom`
  ADD PRIMARY KEY (`uom`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `t_user_object_auth`
--
ALTER TABLE `t_user_object_auth`
  ADD PRIMARY KEY (`username`,`ob_auth`,`ob_value`);

--
-- Indexes for table `t_user_role`
--
ALTER TABLE `t_user_role`
  ADD PRIMARY KEY (`username`,`roleid`),
  ADD KEY `roleid` (`roleid`);

--
-- Indexes for table `t_vendor`
--
ALTER TABLE `t_vendor`
  ADD PRIMARY KEY (`vendor`);

--
-- Indexes for table `t_wip`
--
ALTER TABLE `t_wip`
  ADD PRIMARY KEY (`wipid`,`wiptype`);

--
-- Indexes for table `t_wip_stock`
--
ALTER TABLE `t_wip_stock`
  ADD PRIMARY KEY (`area`,`bomid`);

--
-- Indexes for table `t_wos01`
--
ALTER TABLE `t_wos01`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_wos_image`
--
ALTER TABLE `t_wos_image`
  ADD PRIMARY KEY (`bomid`,`partnumber`,`circuitno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproject`
--
ALTER TABLE `tblproject`
  MODIFY `idproject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_activity`
--
ALTER TABLE `t_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `t_bank`
--
ALTER TABLE `t_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_defect_jenis`
--
ALTER TABLE `t_defect_jenis`
  MODIFY `idjenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `t_defect_process`
--
ALTER TABLE `t_defect_process`
  MODIFY `idprocess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `t_defect_section`
--
ALTER TABLE `t_defect_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_department`
--
ALTER TABLE `t_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_inspection`
--
ALTER TABLE `t_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_jabatan`
--
ALTER TABLE `t_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_jenis_defect`
--
ALTER TABLE `t_jenis_defect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_meja`
--
ALTER TABLE `t_meja`
  MODIFY `nomeja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_menus`
--
ALTER TABLE `t_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `t_quotation01`
--
ALTER TABLE `t_quotation01`
  MODIFY `quotation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `t_wos01`
--
ALTER TABLE `t_wos01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_rolemenu`
--
ALTER TABLE `t_rolemenu`
  ADD CONSTRAINT `t_rolemenu_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `t_role` (`roleid`),
  ADD CONSTRAINT `t_rolemenu_ibfk_2` FOREIGN KEY (`menuid`) REFERENCES `t_menus` (`id`);

--
-- Constraints for table `t_user_role`
--
ALTER TABLE `t_user_role`
  ADD CONSTRAINT `t_user_role_ibfk_1` FOREIGN KEY (`username`) REFERENCES `t_user` (`username`),
  ADD CONSTRAINT `t_user_role_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `t_role` (`roleid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
