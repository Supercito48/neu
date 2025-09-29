<?php

require_once "conexion.php";

class ModeloActas
{
    public static function mdlListarProvincias()
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT id_provincia, provincia FROM provincias ORDER BY provincia"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function mdlListarDistritos($idProvincia)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT ubigeo_reniec, nom_distrito FROM distritos WHERE id_provincia = :idProvincia ORDER BY nom_distrito"
        );
        $stmt->bindValue(":idProvincia", $idProvincia, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function mdlListarCandidatos($ubigeo)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT c.id_candidato, c.codigo_agrupacion, c.nombre_candidato, gp.agrupacion_politica FROM candidatos c INNER JOIN grupos_politicos gp ON c.codigo_agrupacion = gp.codigo_agrupacion WHERE c.ubigeo = :ubigeo ORDER BY c.id_candidato"
        );
        $stmt->bindValue(":ubigeo", $ubigeo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function mdlRegistrarActa($datosActa, $detalleCandidatos)
    {
        $pdo = Conexion::conectar();

        try {
            $pdo->beginTransaction();

            $consulta = $pdo->prepare(
                "SELECT id FROM tab_vt_distrital_acta WHERE ubigeo = :ubigeo AND mesa_sufragio = :mesa"
            );
            $consulta->execute([
                ":ubigeo" => $datosActa["ubigeo"],
                ":mesa" => $datosActa["mesa_sufragio"],
            ]);

            if ($consulta->fetchColumn()) {
                $pdo->rollBack();
                return "duplicado";
            }

            $detalle = [];
            foreach ($detalleCandidatos as $candidato) {
                $detalle[] = $candidato["votos"];
            }
            $detalleStr = implode(",", $detalle);
            if ($detalleStr !== "") {
                $detalleStr .= ",";
            }

            $stmtActa = $pdo->prepare(
                "INSERT INTO tab_vt_distrital_acta (ubigeo, mesa_sufragio, total_reniec_habiles, detalle_vt_dist, ruta_acta, vt_blanco_dist, vt_nulo_dist, vt_impugnado_dist, total_vt_emitidos_dist) VALUES (:ubigeo, :mesa, :total_habiles, :detalle, :ruta_acta, :blanco, :nulo, :impugnado, :emitidos)"
            );
            $stmtActa->execute([
                ":ubigeo" => $datosActa["ubigeo"],
                ":mesa" => $datosActa["mesa_sufragio"],
                ":total_habiles" => $datosActa["total_reniec_habiles"],
                ":detalle" => $detalleStr,
                ":ruta_acta" => $datosActa["ruta_acta"],
                ":blanco" => $datosActa["vt_blanco_dist"],
                ":nulo" => $datosActa["vt_nulo_dist"],
                ":impugnado" => $datosActa["vt_impugnado_dist"],
                ":emitidos" => $datosActa["total_vt_emitidos_dist"],
            ]);

            $stmtDetalle = $pdo->prepare(
                "INSERT INTO tab_vt_distritales (ubigeo, mesa_sufragio, codigo_agrupacion, vt_dist) VALUES (:ubigeo, :mesa, :codigo, :votos)"
            );

            foreach ($detalleCandidatos as $candidato) {
                $stmtDetalle->execute([
                    ":ubigeo" => $datosActa["ubigeo"],
                    ":mesa" => $datosActa["mesa_sufragio"],
                    ":codigo" => $candidato["codigo_agrupacion"],
                    ":votos" => $candidato["votos"],
                ]);
            }

            $pdo->commit();
            return "ok";
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return "error";
        }
    }

    public static function mdlListarActas()
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT a.id, a.ubigeo, a.mesa_sufragio, a.total_reniec_habiles, a.vt_blanco_dist, a.vt_nulo_dist, a.vt_impugnado_dist, a.total_vt_emitidos_dist, a.ruta_acta, d.nom_distrito, p.provincia FROM tab_vt_distrital_acta a LEFT JOIN distritos d ON d.ubigeo_reniec = a.ubigeo LEFT JOIN provincias p ON p.id_provincia = d.id_provincia ORDER BY a.id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
