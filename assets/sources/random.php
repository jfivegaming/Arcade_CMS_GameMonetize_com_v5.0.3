<?php

$query_gm_Random = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY featured desc");


  if ($query_gm_Random->num_rows != 0) {
            while ($gRandom = $query_gm_Random->fetch_array()) {
                $results[] = $gRandom['game_name'];
            }
        }

$randomgame = $results[array_rand($results)];

header('Location: '. $config['site_url']. "/game/" . $randomgame);