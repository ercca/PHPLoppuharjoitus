<?php
//Luodaan Tuote -luokka tuote -olioita varten
class Tuote {
	public $id;
	public $nimi;
	public $kategoria;
	public $hinta;
	public $paino;
	public $tuotekuva;

	function __construct($id, $nimi, $kategoria, $hinta, $paino, $tuotekuva) {
		$this->id = $id;
		$this->nimi = $nimi;
		$this->kategoria = $kategoria;
		$this->hinta = round($hinta, 3);
		$this->paino = $paino;
		$this->tuotekuva = $tuotekuva;
	}

}

//Luodaan lista Tuote -objekteja varten
$tuotelista = array();

//Luodaan tuotteet
//Lentokone -kategoria
$lentokone1 = new Tuote(1, "Lentokone XL", "lentokone", 129.90, 30000, "https://upload.wikimedia.org/wikipedia/commons/4/4e/Boeing_787_N1015B_ANA_Airlines_%2827611880663%29_%28cropped%29.jpg");
$lentokone2 = new Tuote(2, "Lentokone L", "lentokone", 119.90, 25000, "https://upload.wikimedia.org/wikipedia/commons/4/4e/Boeing_787_N1015B_ANA_Airlines_%2827611880663%29_%28cropped%29.jpg");
$lentokone3 = new Tuote(3, "Lentokone M", "lentokone", 109.90, 20000,"https://upload.wikimedia.org/wikipedia/commons/4/4e/Boeing_787_N1015B_ANA_Airlines_%2827611880663%29_%28cropped%29.jpg");
$lentokone4 = new Tuote(4, "Lentokone S", "lentokone", 99.90, 15000,"https://upload.wikimedia.org/wikipedia/commons/4/4e/Boeing_787_N1015B_ANA_Airlines_%2827611880663%29_%28cropped%29.jpg");
//Lisätään tuotteet listalle
array_push($tuotelista, $lentokone1, $lentokone2, $lentokone3, $lentokone4);

//Auto -kategoria
$auto1 = new Tuote(5, "Auto L", "auto", 60.90, 2000, "https://www-asia.nissan-cdn.net/content/dam/Nissan/in/vehicles/GTR/R35/2_Monor_Changes/Overview/eurhd/17TDIeurhd_GTRHelios014.jpg.ximg.m_12_m.smart.jpg");
$auto2 = new Tuote(6, "Auto M", "auto", 50.90, 1500, "https://www-asia.nissan-cdn.net/content/dam/Nissan/in/vehicles/GTR/R35/2_Monor_Changes/Overview/eurhd/17TDIeurhd_GTRHelios014.jpg.ximg.m_12_m.smart.jpg");
$auto3 = new Tuote(7, "Auto S", "auto", 40.90, 1000, "https://www-asia.nissan-cdn.net/content/dam/Nissan/in/vehicles/GTR/R35/2_Monor_Changes/Overview/eurhd/17TDIeurhd_GTRHelios014.jpg.ximg.m_12_m.smart.jpg");
array_push($tuotelista, $auto1, $auto2, $auto3);

//Vene -kategoria
$vene1 = new Tuote(8, "Vene L", "vene", 38.90, 400, "https://yamarin.com/sites/default/files/styles/article_main_image/public/2019-10/Uusi%20Yamarin%2063%20DC%202020.jpg?itok=WczFP7hD");
$vene2 = new Tuote(9, "Vene M", "vene", 28.90, 350, "https://yamarin.com/sites/default/files/styles/article_main_image/public/2019-10/Uusi%20Yamarin%2063%20DC%202020.jpg?itok=WczFP7hD");
$vene3 = new Tuote(10, "Vene S", "vene", 18.90, 300, "https://yamarin.com/sites/default/files/styles/article_main_image/public/2019-10/Uusi%20Yamarin%2063%20DC%202020.jpg?itok=WczFP7hD");
array_push($tuotelista, $vene1, $vene2, $vene3);

$tuotelistatemp = $tuotelista;
$nollattu = false;

//Haku kategorioittain
if (!empty(($_GET["kat"])))
{
	if ($nollattu == false)
	{
		$tuotelistatemp = [];
		$nollattu = true;
	}

	if (htmlspecialchars($_GET["kat"]) == "lentokone")
	{
		foreach ($tuotelista as $key => $value)
		{
			if (($value->kategoria) === "lentokone")
			{
				array_push($tuotelistatemp, $value);
			}

		}
	}
	if (htmlspecialchars($_GET["kat"]) == "auto")
	{
		foreach ($tuotelista as $key => $value)
		{
			if (($value->kategoria) === "auto")
			{
				array_push($tuotelistatemp, $value);
			}

		}

	}
	if (htmlspecialchars($_GET["kat"]) == "vene")
	{
		foreach ($tuotelista as $key => $value)
		{
			if (($value->kategoria) === "vene")
			{
				array_push($tuotelistatemp, $value);
			}

		}
	}
}



//Haku maksimihinnan mukaan
if (!empty($_GET["maxh"]))
{
	if ($nollattu == false)
	{
		$tuotelistatemp = [];
		$nollattu = true;

		foreach($tuotelista as $key => $value)
		{
			if (($value->hinta) <= $_GET["maxh"])
			{
				array_push($tuotelistatemp, $value);
			}

		}
	}
	else
	{
		foreach ($tuotelistatemp as $key => $value)
		{
			if(($value->hinta) > $_GET["maxh"])
			{
				unset($tuotelistatemp[array_search($value, $tuotelistatemp)]);
			}
		}
		$tuotelistatemp = array_values($tuotelistatemp);
	}

}

//Haku Id:llä
if (!empty($_GET["tunniste"]))
{
    $tuotelistatemp = [];

    if (htmlspecialchars($_GET["tunniste"]) > 0 && htmlspecialchars($_GET["tunniste"]) <= 10)
    {
        foreach($tuotelista as $key => $value)
        {
            if(($value->id) == $_GET["tunniste"])
            {
                array_push($tuotelistatemp, $value);
            }
        }
    }
}

//JSONin muodostaminen
if (!empty($tuotelistatemp))
{
	echo json_encode($tuotelistatemp);
}
?>