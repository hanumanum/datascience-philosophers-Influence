CREATE TEMPORARY TABLE IF NOT EXISTS `influences1` AS (SELECT `source` FROM `influences`);

UPDATE `influences`
SET `influences`.`countt` = (SELECT COUNT(`source`) 
							 FROM `influences1` 
							 WHERE `influences`.`source`=`influences1`.`source`)






INSERT INTO `philosopers`
 (`name`,`infForce`)
SELECT DISTINCT `source`, `countt` FROM `influences`

#474

INSERT INTO `philosopers`
(`name`,`infForce`)
SELECT DISTINCT `target`, 0 
FROM `influences` 
WHERE `target` NOT IN (SELECT `name` FROM `philosopers`)  


UPDATE `philosopers` p
SET `birthyear` = (SELECT `date_of_birth` FROM `new_philosopers_dates` pd WHERE pd.`name`=p.`name` LIMIT 0,1)