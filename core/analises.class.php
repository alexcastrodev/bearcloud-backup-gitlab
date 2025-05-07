<?php

namespace Bear\Analytics;

use PDO;

class Analises {
    public static function posts_visitados($db,$dado) {
        $contagem  = $db->query("
        select post_id, post_nome, COUNT(contagem_post_id) as TOTAL from posts_visitas as X
        INNER JOIN posts as Y
        INNER JOIN tags as Z
        on X.contagem_post_id = Y.post_id
        AND Y.post_tag = Z.tag_id
        GROUP BY post_nome ORDER BY TOTAL DESC limit 1;
    ");
    $result = $contagem->fetch(PDO::FETCH_ASSOC);
    return $result[$dado];
    }

    public static function posts_ativos($db) {
        $contagem  = $db->query("
        SELECT post_id
        FROM posts
        WHERE post_active = '1';
    ");
    $result = $contagem->rowCount();
    return $result;
    }

}


?>