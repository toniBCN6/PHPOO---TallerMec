<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <style>
    .invoice-box {
        margin: auto;
        padding: 30px;
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <?php
    require_once '../Conn.php';
    require_once '../class/Factura.php';
    
    ?>
            <div class="justify-content-center text-center bg-light"><button id="boton" class="btn btn-white border border-danger" onclick="myFunction()"><i class="far fa-file-pdf bg-light"></i> <b class="text-primary">Descargar PDF</b></button>
            </div>

        <div class="invoice-box bg-white">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="https://i.ibb.co/h9F6Zm6/Sin-t-tulo-3.png" style="width:100%; max-width:250px;">
                                </td>
                                
                                <td>
                                    <?php
                                    if (isset($_POST['verFacturaExt'])) {
                                        $id = $_POST['verFacturaExt'];
                                    
                                        echo ' Factura : #'.$id.'<br>';
                                        echo date('d/m/Y');
                                                
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    Taller MFCF S.L.<br>
                                    Atarfe, Granada<br>
                                    Granada, CP 18110
                                </td>
                                <?php
                                if (isset($_POST['verFacturaExt'])) {
                                $id = $_POST['verFacturaExt'];
                                $factura = new Factura();
                                $factura->FacturaExtendida($id);                                        
                                }
                                ?>
                            </tr>    
                        </table>
                    </td>
                </tr>
            </table>
        </div>        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="../vendor/jquery-3.3.1.slim.min.js"></script>
        <script src="../vendor/popper.min.js"></script>
        <script src="../vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
         
        <script>
            function myFunction() {
                document.getElementById("boton").style.display = "none";
                document.getElementById("boton").style.visibility = "hidden";
                window.print();
            }
        </script>
</body>
</html>