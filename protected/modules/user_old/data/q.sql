DELIMITER $$

DROP PROCEDURE IF EXISTS `ikway`.`q` $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `q`()
BEGIN

-- create temporary table temp
-- (select * from tbl_profiles Limit 2);

-- insert into temp
-- (select * from tbl_profiles where user_id=3);

-- select @q

declare n integer;
declare q integer;

set n=2;

create temporary table temp
(select * from tbl_profiles where user_id=1);
select count(*) into q from temp;

if (q<n)
  then
      insert into temp
      (select * from tbl_profiles where user_id=2);
      select count(*) into q from temp;
  end if;

if (q<n)
  then
     insert into temp
     (select * from tbl_profiles where user_id=3);
     select count(*) into q from temp;
  end if;

 select * from temp;



END $$

DELIMITER ;