<?php


namespace Controllers;


class Aluno
{
    protected $id, $nome, $login, $versao;

    public function MudaVersao($id){
        $a = \AlunoQuery::create()->findOneById($id);
        $this->versao = $a->getVersao();
        $this->versao++;
        $a->setVersao($this->versao);
        $a->save();
    }
}