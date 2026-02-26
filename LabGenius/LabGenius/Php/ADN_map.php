<?php
session_start();
header('Content-Type: application/json');

// Récupération des données envoyées par le JavaScript
$action = $_POST['action'] ?? '';
$seq = strtoupper(trim($_POST['sequence'] ?? ''));

$response = ['status' => 'success'];

/* Calcule les statistiques de la séquence (GC% et AT%)*/
function getDnaStats($dna) {
    $len = strlen($dna);
    if ($len === 0) return ['gc' => 0, 'at' => 0];
    $gc = substr_count($dna, 'G') + substr_count($dna, 'C');
    $at = substr_count($dna, 'A') + substr_count($dna, 'T');
    return [
        'gc' => round(($gc / $len) * 100, 1),
        'at' => round(($at / $len) * 100, 1)
    ];
}

// Routage des actions
switch ($action) {
    case 'save':
        $_SESSION['dna'] = $seq;
        $response['stats'] = getDnaStats($seq);
        break;

    case 'mutate':
        $bases = ['A','T','C','G'];
        $arr = str_split($seq);
        if(count($arr) > 0) {
            $i = array_rand($arr);
            $old = $arr[$i];
            $filtered = array_values(array_filter($bases, fn($b) => $b !== $old));
            $arr[$i] = $filtered[rand(0, 2)];
            $response['result'] = implode('', $arr);
            $response['label'] = "Mutation (Index $i : $old ➔ {$arr[$i]})";
        }
        break;

    case 'transcribe':
        $response['result'] = str_replace('T', 'U', $seq);
        $response['label'] = "Transcription (ARNm)";
        break;

    case 'complement':
        $map = ['A'=>'T','T'=>'A','C'=>'G','G'=>'C','U'=>'A'];
        $res = "";
        foreach(str_split($seq) as $b) { $res .= $map[$b] ?? $b; }
        $response['result'] = $res;
        $response['label'] = "Brin Complémentaire";
        break;

    case 'run_synthesis':
        $stats = getDnaStats($seq);
        $rand = rand(0, 100);
        // Seuil de réussite (Plus dur si GC est instable)
        $threshold = ($stats['gc'] < 30 || $stats['gc'] > 70) ? 40 : 15;
        if ($rand > $threshold) {
            $response['data'] = ['status' => 'SUCCESS', 'purity' => rand(85, 100), 'msg' => "Liaisons moléculaires stables."];
        } else {
            $response['data'] = ['status' => 'FAILURE', 'purity' => rand(10, 45), 'msg' => "Instabilité thermique détectée."];
        }
        break;

    case 'get_session':
        $response['sequence'] = $_SESSION['dna'] ?? '';
        break;

    default:
        $response = ['status' => 'error', 'message' => 'Action inconnue : ' . $action];
}

echo json_encode($response);