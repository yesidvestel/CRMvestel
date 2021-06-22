create view datetable as
select 
 date_format(adddate(LAST_DAY(now()),-(a.a + (10 * b.a) + (100 * c.a) + (1000 * d.a))),'%Y-%m-%d') AS date
 from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4
 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
 cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4
 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
 cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4
 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
 cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4
 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as d
; 