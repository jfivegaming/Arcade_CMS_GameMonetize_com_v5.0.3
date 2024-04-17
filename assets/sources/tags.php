<?php
	$themeData['ads_header'] = getADS('header');
	$themeData['ads_footer'] = getADS('footer');
	$themeData['ads_sidebar'] = getADS('column_one');
	# >>

	$themeData['new_game_page'] = "";

	$query_gm_Random = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY featured desc");


  if ($query_gm_Random->num_rows != 0) {
            while ($gRandom = $query_gm_Random->fetch_array()) {
                $results[] = $gRandom['game_name'];
            }
        }

     $websiteslist = "";
	$websites=$GameMonetizeConnect->query("select * from gm_websites order by `id` asc");
	$i=0;
	foreach($websites as $Tmp) {
		$url = $Tmp["name"];
		//$host  = stristr($url, '.',true);
		$host = $url;
		$host2 = str_replace('.', '-', $url); 
		if($host == "travian" || $host == "transfermarkt" || $host == "railnation"){
		}
			else{
			$hostname = ucfirst($host) . " Games";
			$hosturl = $host2 . "-games";
			$i=$i+1;
		$websiteslist .= '
		 <a href="' . siteUrl() . '/' . $hosturl . '" class="taglink">
                        <div class="tag">
                            <div class="taginfo fn-left" style="padding:0px;">
                                <p class="pl">' . $hostname . '</p>
                            </div>
                        </div>
                    </a> ';
		}
	}

 	$websiteslist2 = "";	
	$websites2=$GameMonetizeConnect->query("select * from gm_websites order by `id` asc");
	$i2=0;
	foreach($websites2 as $Tmp2) {
		$host2 = $url;
		$url2 = $Tmp2["name"];
		if($host2 == "travian" || $host2 == "transfermarkt" || $host2 == "railnation"){
		}
			else{
			$host2  = stristr($url2, '.',true);
			$hosturl2 = $host2 . "-games";
			$i2=$i2+1;
		$websiteslist2 .= '
		 <a href="' . siteUrl() . '/' . $hosturl2 . '" class="taglink">
                        <div class="tag">
                            <div class="taginfo fn-left" style="padding:0px;">
                                <p class="pl">' . $host2 . ' Games</p>
                            </div>
                        </div>
                    </a> ';
		}
	}
	
	$themeData['new_tags'] = $websiteslist;
	$themeData['new_tags2'] = $websiteslist2;

	$themeData['new_games'] = \GameMonetize\UI::view('game/tags');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');