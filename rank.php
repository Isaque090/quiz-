<?php

include_once('config.php');
$stmt = $conexao->prepare("SELECT * FROM melhores ORDER BY pontuacao DESC LIMIT 10;");

$stmt->execute();
$result = $stmt->get_result();



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {

            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;




            text-align: center;


        }

        .todo {
            width: 100% !important;
            max-width: 800px !important;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .botao {
            display: block;
            width: 50%;
            margin: 12px 0;
            padding: 16px;
            font-size: 19px;
            background-color: #3437db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
            color:#fff;
            color:white !important;
        }
a{
    text-decoration: none !important;
}
        .botao:hover {
            background-color: #294fb9;
        }

        .botao:active {
            background-color: #1f6391;
        }


        th {
            background-color: #4d34db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #a7aff044;

        }

        tr {
            background-color: #8e93c177;
            padding: 100px !important;
        }

        tr:hover {
            background-color: #ffffff77;
            cursor: default;
        }

        th,
        td {
            padding: 14px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            padding-right: 100px;
            text-align: center;
            overflow: hidden;
            width: 100% ;


        }

        table {

            margin-left: auto;
            margin-right: auto;
            width: 100% !important;
            table-layout: fixed !important;
        }

        .foto {
            width: 50px;
            height: 50px;

            border: 3px solid #000;
            border-radius: 50px;


        }

        .nome-coluna {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px 0px !important;
            width: 70%;
        }


        .ponto {
            width: 120px;
            font-weight: bold;
           
        }
         
           

@media (max-width: 768px) {
  body {
    padding: 0.8rem;
  }

  .todo {
    padding: 0.9rem 0.8rem;
    overflow-x: hidden;
  }

  table {
    font-size: 1rem;
  }

  th, td {
    padding: 0.9rem 0.6rem;
  }

  .foto {
    width: 32px;
    height: 32px;
  }

  .nome-coluna {
    gap: 7px;
    font-size: 0.80rem;
    width:100px !important;
  }

  .ponto {
    max-width: 0px !important;
    font-size: 0.9rem !important;
    width:0px !important;
  }

  td {
    max-width: 19 !important;               
  }
  .botao{
    
            width: 60%;
          
  }
  h1{
    font-size:1.6rem;
  }
}

    </style>
</head>

<body>
    <div class="card todo">
        <div class="card-heder">
            <h1> Ranking - Top 10 Melhores Pontuações</h1>
        </div>
        <div class="card-body">
            <table>
                <thed class="theder">
                    <tr>
                        <th class="posicao">Posição</th>
                        <th>Usuario</th>
                        <th>Pontuação</th>
                    </tr>
                </thed>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php


                        $posicao = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <?php
                            $medalha = $posicao;
 $css=" font-size: 18px;";
                            if ($posicao === 1) {
                                $medalha = '🥇';
                                $css=" font-size: 24px;";
                            } elseif ($posicao === 2) {
                                $medalha = '🥈';
                                 $css=" font-size: 24px;";
                            } elseif ($posicao === 3) {
                                $medalha = '🥉';
                                 $css=" font-size: 24px;";
                            }


                            ?>
                            <tr>

                                <td style="<?= $css; ?>"> <?= $medalha;
                                if ($posicao != 1 && $posicao != 2 && $posicao != 3) {
                                    $º = "º";
                                } else
                                    $º = "" ?><?= $º; ?> </td>
                                <td class="nome-coluna">
                                    <img class="foto" src="<?= htmlspecialchars($row['img_perfil']) ?>" alt="">
                                    <?= htmlspecialchars($row['nm_nome']) ?>
                                </td>
                                <td class="ponto"><strong><?= $row['pontuacao'] ?></strong></td>


                            </tr>

                            <?php $posicao++; ?>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
           <a class="botao" href="index.php"  >Voltar Para o Menu</a>
        </div>
    </div>
    <?php


    $stmt->close();
    ?>
</body>

</html>
