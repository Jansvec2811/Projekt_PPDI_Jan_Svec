<?php
$xml = simplexml_load_file("igraci.xml");

$pretraga = isset($_GET["pretraga"]) ? trim($_GET["pretraga"]) : "";
$filter_klub = isset($_GET["klub"]) ? trim($_GET["klub"]) : "";

$klubovi = [
    "dinamo"        => "Dinamo Zagreb",
    "hajduk"        => "Hajduk Split",
    "rijeka"        => "Rijeka",
    "osijek"        => "Osijek",
    "varazdin"      => "Varaždin",
    "lokomotiva"    => "Lokomotiva",
    "slaven_belupo" => "Slaven Belupo",
    "gorica"        => "Gorica",
    "istra"         => "Istra 1961",
    "sibenik"       => "Šibenik",
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>HNL Igrači</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body class="p-4">

<h2>HNL Momčadi</h2>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="text" name="pretraga" class="form-control" placeholder="Pretraži po imenu..." value="<?= htmlspecialchars($pretraga) ?>">
    </div>
    <div class="col-auto">
        <select name="klub" class="form-select">
            <option value="">Svi klubovi</option>
            <?php foreach ($klubovi as $tag => $naziv): ?>
                <option value="<?= $tag ?>" <?= $filter_klub === $tag ? "selected" : "" ?>>
                    <?= htmlspecialchars($naziv) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filtriraj</button>
    </div>
</form>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Pozicija</th>
            <th>Klub</th>
            <th>Dres</th>
            <th>Godine</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($klubovi as $tag => $naziv):
            if ($filter_klub && $filter_klub !== $tag) continue;
            foreach ($xml->$tag->igrac as $igrac):
                $punoIme = strtolower((string)$igrac->ime . " " . (string)$igrac->prezime);
                if ($pretraga && strpos($punoIme, strtolower($pretraga)) === false) continue;
        ?>
        <tr>
            <td><a href="https://www.transfermarkt.com/schnellsuche/ergebnis/schnellsuche?query=<?= urlencode($igrac->ime . ' ' . $igrac->prezime) ?>"target="_blank"><?= htmlspecialchars((string)$igrac->ime) ?></a></td>
            <td><?= htmlspecialchars((string)$igrac->prezime) ?></td>
            <td><?= htmlspecialchars((string)$igrac->pozicija) ?></td>
            <td><?= htmlspecialchars($naziv) ?></td>
            <td><?= htmlspecialchars((string)$igrac->broj_dresa) ?></td>
            <td><?= htmlspecialchars((string)$igrac->godine) ?></td>
        </tr>
        <?php endforeach; endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>