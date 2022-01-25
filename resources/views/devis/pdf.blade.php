<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Devis {{ $devis['client'] }} </title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .gray {
        background-color: lightgray
    }
    th {
    padding: 12px !important;
    }
    .table_info,.table_info th,.table_info td {
    border: 1px solid black;
    border-collapse: collapse;
    border-left: none;
    border-bottom: none;
    padding: 10px;
    }
    td.col_none {
    border: none;
    }
    thead {
    border-left: 1px solid;
    }
    .product ,.footer_border {
    border-left: 1px solid !important;
    border-bottom: 1px solid !important;
    }
    .under_line {
    text-decoration: underline;
    text-underline-position: under;
    }
    .control_footer {
    position: relative;
    left: 50%;
    text-align: center;
    transform: translateX(-50%);
    }

    .c_f {
    width: 100px;
     }
    .table_title tr,.table_title td {
    padding: 10px;
    }

</style>

</head>
<body>


  <table width="100%" style='padding-top: 120px;padding-right: 10px; '>
    
    <tr>

        <td align="right" >
            <h3 >Rabat, le {{ $devis['current_date'] }}</h3>

        </td>
    </tr>

  </table>

  <table width="100%"  >

    <tr>
 
        <td align="CENTER">
            <h3 class='under_line'>DEVIS N {{ $devis['id'] }}/{{ $devis['date'] }}</h3>

        </td>
    </tr>

  </table>

  <table class="table_title" width="100%" style='padding-top: 20px; '>
    <tr>
        <td><strong class='under_line'>Objet&nbsp;:</strong> {{ $devis['objet'] }}</td>

    </tr>
    <tr style='padding-top: 10px;'>

        <td><strong class='under_line'>Client :</strong> {{ $devis['client'] }} </td>
    </tr>

  </table>

  <br/>

  <table width="100%" class='table_info'>
    <thead style="background-color: #e9df85;">
      <tr>
        <th>N de Prix</th>
        <th>DESIGNATION DES PRESTATIONS </th>
        <th>UNITE DE MESURE</th>
        <th>QTE</th>
        <th>PRIX UNITAIRE DH HTVA EN CHIFFRES</th>
        <th>PRIX TOTAL EN CHIFFRES</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($devis['products'] as $key => $item)
      <tr>
      <td  class="product" align="CENTER" scope="row">{{ ++$key }}</td>
      <td  class="product" align="left">{{ $item->designation }}</td>
      <td  class="product" align="CENTER">{{ $item->unite }}</td>
      <td  class="product" align="CENTER"> {{ $item->quantite }}</td>
      <td class='col_price' align="CENTER" ><div class='c_f' width="50%" align="right">{{ number_format($item->prix,2,",",".")  }}</div></td>
      <td class='col_price' align="right" ><div class='c_f' width="50%" align="right" style='font-weight: bold;'>{{ number_format($item->prix_total,2,",",".")  }}</div></td>
      </tr>
      @endforeach

    </tbody>

    <tfoot>
        <tr class='col_footer' >
            <td class='col_none' colspan="4"></td>
            <td class='footer_border' align="center">Total HTVA</td>
            <td align="right"><div class='c_f' width="50%" align="right">{{ $devis['total_htva'] }}</div></td>
        </tr>
        <tr class='col_footer'>
            <td class='col_none' colspan="4"></td>
            <td class='footer_border' align="center">Taux TVA (20%)</td>
            <td align="right"><div class='c_f' width="50%" align="right">{{ $devis['tva'] }}</div> </td>
        </tr>
        <tr class='col_footer'>
            <td class='col_none' colspan="4"></td>
            <td class='footer_border' align="center">Total TTC</td>
            <td class='footer_border'  class="gray"  > <div class='c_f' width="50%" align="right">{{ $devis['ttc'] }}</div> </td>
        </tr>
    </tfoot>
  </table>

  <table width="100%" style='padding-top: 25px; margin-left: 13px;'>
    <tr>
      <td width="30%"> Arrêté le présent devis à la somme de : </td>   <td width="45%" align="LEFT">{{ $devis['amount_letter'] }}</td>   <td width="15%">DH TTC</td>
    </tr>
  </table>

</body>
</html>