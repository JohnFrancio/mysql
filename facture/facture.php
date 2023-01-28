<?php
    use Dompdf\Dompdf;

    ob_start();
    require_once 'fact_info.php';
    $html = ob_get_contents();
    $var = boolval($_SESSION['facture']);
    ob_end_clean();

    if($var == 1){
        $fichier = $_SESSION['email']."_facture.pdf";
        require_once '../dompdf/autoload.inc.php';
        $dom = new Dompdf();
        $dom->loadHtml($html);
        $dom->render();
        $dom->stream($fichier);
    }else{
        header('location:../geek.php');
    }
    unset($_SESSION['facture']);
    unset($_SESSION['panier']);
?>