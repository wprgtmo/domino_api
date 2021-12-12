-- Consulta para determinar los parámetros de la pareja

SELECT
  pareja.nombre as pareja,
  COUNT(boleta_pareja.id) as JJ,
  SUM(boleta_pareja.ganador) as JG,
  COUNT(boleta_pareja.id) - SUM(boleta_pareja.ganador) as JP,
  SUM(boleta_pareja.tantos) as TG,
  SUM(
    CASE
      WHEN boleta_pareja.ganador = 1 THEN boleta_pareja.tantos
      ELSE 0
    END
  ) as TantosFavor,
  SUM(
    CASE
      WHEN boleta_pareja.ganador = 0 THEN boleta_pareja.tantos
      ELSE 0
    END
  ) as TantosContra,
 SUM(
    CASE
      WHEN boleta_pareja.ganador = 1 THEN boleta_pareja.tantos
      ELSE 0
    END
  )-SUM(
    CASE
      WHEN boleta_pareja.ganador = 0 THEN boleta_pareja.tantos
      ELSE 0
    END
  ) AS DT,
  SUM(mesa.bonificacion) as Bon


FROM
  `evento`
  INNER JOIN boleta on boleta.evento_id = evento.id
  INNER JOIN boleta_pareja on boleta_pareja.boleta_id = boleta.id
  INNER JOIN pareja on pareja.id = boleta_pareja.pareja_id
  INNER JOIN mesa on boleta.mesa_id = mesa.id
WHERE
  evento.id = 1
GROUP BY
  pareja.nombre
ORDER BY
  pareja.nombre

  -- Consulta para determinar los parámetros de la pareja y la ronda

SELECT
  pareja.nombre as pareja, data.numero, SUM(data.puntos)

FROM
  `evento`
  INNER JOIN boleta on boleta.evento_id = evento.id
  INNER JOIN boleta_pareja on boleta_pareja.boleta_id = boleta.id
  INNER JOIN pareja on pareja.id = boleta_pareja.pareja_id
  INNER JOIN data on data.boleta_id = boleta.id 
WHERE
  evento.id = 1
GROUP BY
  pareja.nombre
ORDER BY
  pareja.nombre