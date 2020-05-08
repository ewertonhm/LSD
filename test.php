<?php

require_once 'config.php';

$a1 = AlunoQuery::create()->findOneById(1);
echo $a1->getVersao();


echo "incremente";
$a = new \Controllers\Aluno();
$a->MudaVersao(1);


echo $a1->getVersao();
