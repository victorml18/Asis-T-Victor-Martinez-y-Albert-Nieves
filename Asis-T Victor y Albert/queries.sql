select * from alumnos_asistencia order by employee_id;
# Get employees with absence and presence count in date range 
select alumnos.name, 
sum(case when status = 'presence' then 1 else 0 end) as presence_count,
sum(case when status = 'absence' then 1 else 0 end) as absence_count 
 from alumnos_asistencia
 inner join alumnos on alumnos.id = alumnos_asistencia.employee_id
 where date >= '2020-11-01' and date <= '2020-11-16'
 group by employee_id;