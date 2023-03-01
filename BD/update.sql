select * from  caja ca , (
SELECT c.`id`, c.`idPlaca`, c.`observacion`, max(c.registro) as maxRegistro, c.fActualizacion as fechaRecienteCaja, c.horometro as horometroRecienteCaja, subQuery.fActualizacion, subQuery.horometro, rango2, fActualizacionLatam, placSerie from caja c, 
( SELECT a.`fActualizacion`, a.`horometro`,p.rango2, p.porcentajeAviso2, movilidad, placSerie, case a.tipo when 1 then 'km' when 2 then 'horas' end as queTipo, date_format(a.fActualizacion, '%d/%m/%Y') as fActualizacionLatam, a.`tipo` FROM placas p join aceite a on a.idPlaca = p.idPlaca where a.idPlaca in (211,209) group by a.idPlaca ) as subQuery
) query2
where ca.registro = query2.maxRegistro and ca.idPlaca = query2.idPlaca


SELECT ca.* FROM `caja` ca ,
(select idPlaca, max(registro) as maxRegistro from caja group by idPlaca) q
where ca.idPlaca = q.idPlaca and ca.registro = q.maxRegistro


