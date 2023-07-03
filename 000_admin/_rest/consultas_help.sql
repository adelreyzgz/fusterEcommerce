-- Listado de Marcas con la cantidad de productos que tiene segun una categoria (idCategoria)
SELECT unionT.id, unionT.marca, count(unionT.id) as cantidad FROM (SELECT DISTINCT marcas.id, marcas.marca, rel_repuestos_refoem.idRepuesto FROM marcas 
JOIN rel_refoem_marcas_series_modelo as rel ON rel.idMarca = marcas.id 
JOIN rel_repuestos_refoem ON rel.idRefOem = rel_repuestos_refoem.idRefOem 
JOIN rel_repuestos_categorias ON rel_repuestos_categorias.idRepuesto = rel_repuestos_refoem.idRepuesto WHERE marcas.id != 222 AND rel_repuestos_categorias.idCategoria=52 ORDER BY marcas.id ASC) as unionT GROUP BY unionT.marca; 


-- Listado de Marcas con la cantidad de productos que tiene
SELECT unionT.id, unionT.marca, count(unionT.id) as cantidad FROM (SELECT DISTINCT marcas.id, marcas.marca, rel_repuestos_refoem.idRepuesto FROM marcas JOIN rel_refoem_marcas_series_modelo as rel ON rel.idMarca = marcas.id JOIN rel_repuestos_refoem ON rel.idRefOem = rel_repuestos_refoem.idRefOem WHERE marcas.id != 222 ORDER BY marcas.id ASC) as unionT GROUP BY unionT.marca


SELECT DISTINCT re.id, re.nombre, re.noRefFuster, carac.alias, rel4.valor FROM es_repuestos as re 

JOIN rel_repuestos_refoem as rel1 ON re.id = rel1.idRepuesto 
JOIN rel_repuestos_categorias as rel3 ON re.id = rel3.idRepuesto 
JOIN rel_refoem_marcas_series_modelo as rel2 ON rel2.idRefOem = rel1.idRefOem 
JOIN rel_repuestos_caracteristicas as rel4 ON rel4.idRepuesto = re.id
JOIN es_caracteristicas as carac ON rel4.idCaracteristica = carac.id
WHERE rel2.idMarca = 211 AND rel3.idCategoria = 23 AND re.tipo = 1

ORDER BY re.nombre asc;  /* 90 REPUESTOS */

/*
SELECT caract.alias, rel1.valor FROM es_caracteristicas as caract JOIN rel_repuestos_caracteristicas as rel1 ON caract.id = rel1.idCaracteristica JOIN es_repuestos as rep on rel1.idRepuesto = rep.id WHERE rep.id = $idProd AND rep.tipo = 1;*/


-- Cantidad de productos por marca , por categoria dentro de una categoria padre
SELECT count(unionT.idRepuesto) as cantidadRepuestos, unionT.categoriasId, unionT.categorias FROM (
    SELECT rep.id as idRepuesto, categorias.id as categoriasId, categorias.nombre as categorias FROM es_repuestos AS rep
    JOIN rel_repuestos_categorias AS rel1 ON rel1.idRepuesto = rep.id
    JOIN es_categorias AS categorias ON categorias.id = rel1.idCategoria
    JOIN rel_repuestos_refoem AS rel2 ON rep.id = rel2.idRepuesto
    JOIN rel_refoem_marcas_series_modelo AS rel3 ON rel2.idRefOem = rel3.idRefOem
    JOIN marcas ON marcas.id = rel3.idMarca
    WHERE categorias.idPadre = 12 AND rel3.idMarca = 200
    GROUP BY rep.id
) as unionT GROUP BY unionT.categoriasId



d2d2d2#