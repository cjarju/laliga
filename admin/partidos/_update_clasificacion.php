<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if (!($goles_equipo_local == '') && !($goles_equipo_away == '')) {

//update classification

 $equipos_ids = array($equipo_local_id, $equipo_away_id);

foreach ($equipos_ids as $equipo_id) {
// for each equipo
    $sql_get = <<<STR
    select pg*3 + pe pt , pj, gf, gc, pg, pp, pe from

(Select 0 id, count(*) pj
from partidos where equipo_local_id = $equipo_local_id or equipo_away_id = $equipo_local_id
and (goles_equipo_local is not null)
) jugados

inner join
(
select 0 id, sum(gf_home) gf, sum(gc_home) gc from
(
Select sum(goles_equipo_local) gf_home, sum(goles_equipo_away) gc_home
from partidos where equipo_local_id = $equipo_local_id
and (goles_equipo_local is not null)
union all
Select sum(goles_equipo_away) gf_away, sum(goles_equipo_local) gc_away
from partidos where equipo_away_id = $equipo_local_id
and (goles_equipo_away is not null)
) go
) goles
on jugados.id = goles.id
inner join
(
select 0 id, sum(pg_home) pg from
(
Select count(*) pg_home
from partidos where equipo_local_id = $equipo_local_id
and goles_equipo_local is not null and (goles_equipo_local > goles_equipo_away)
union all
Select count(*) pg_away
from partidos where equipo_away_id = $equipo_local_id
and goles_equipo_away is not null and (goles_equipo_away > goles_equipo_local)
) ga
) ganados
on jugados.id = ganados.id
inner join
(
select 0 id, sum(pp_home) pp
from (
Select count(*) pp_home
from partidos where equipo_local_id = $equipo_local_id
and goles_equipo_local is not null and (goles_equipo_away > goles_equipo_local)
union all
Select count(*) pp_away
from partidos where equipo_away_id = $equipo_local_id
and goles_equipo_away is not null and (goles_equipo_local > goles_equipo_away)
) pe
) perdidos
on jugados.id = perdidos.id
inner join
(
Select 0 id, count(*) pe
from partidos where (equipo_local_id = $equipo_local_id or equipo_away_id = $equipo_local_id)
and goles_equipo_local is not null and (goles_equipo_local = goles_equipo_away)
) empatados
on jugados.id = empatados.id
STR;

    $result = $conn->query($sql_get);
    if ($result) {
        $row = $result->fetch_assoc();
        $pt = $row['pt']; $pj = $row['pj']; $pg = $row['pg']; $pe = $row['pe']; $pp = $row['pp']; $gf = $row['gf']; $gc = $row['gc'];
        var_dump($row);
        $sql_update = "update clasificacion set puntos = $pt, jugados = $pj, ganados = $pg, empatados = $pe, perdidos = $pp, goles_a_favor = $gf, goles_en_contra = $gc where equipo_id = $equipo_local_id";
        $conn->query($sql_update);
        $result->free_result();
    }
    else {
        echo 'classification update for equipo not successful';
    }
}

}

?>