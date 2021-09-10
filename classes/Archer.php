<?php

class Archer extends Character
{
    private $arrow = 10;
    private $specialAttack = false;
    private $doubleAttack = false;
    private $dagger;

    public function __construct($name) {
        parent::__construct($name);
        $this->dagger = $this->damage / 3;
    }

    public function turn($target) {
        $rand = rand(1, 10);
        // Sur 1-2 : utilise la double attaque
        // Sur 3-4 : utilise l'attaque spécial (point faible)
        // Sur 5+ : tire une fléche
        if ($this->doubleAttack) {
            $status = $this->doubleAttack($target);
        } else if ($this->specialAttack) {
            $status = $this->specialAttack($target);
        } else if ($this->arrow == 0) {
            $status = $this->attack($target);
        } else if (($rand == 1 || $rand == 2) && $this->arrow >= 2) {
            $status = $this->doubleAttack($target);
        } else if ($rand == 3 || $rand == 4) {
            $status = $this->specialAttack($target);
        } else {
            $status = $this->arrow($target);
        }
        return $status;
    }

    public function doubleAttack($target) {
        if ($this->doubleAttack) {
            $target->setHealthPoints($this->damage);
            $target->setHealthPoints($this->damage);
            $this->arrow -= 2;
            $this->doubleAttack = false;
            $status = "$this->name tire deux flèches sur $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        } else {
            $this->doubleAttack = true;
            $status = "$this->name prépare deux flèches à tirer !";
        }
        return $status;
    }

    public function specialAttack($target) {
        if ($this->specialAttack) {
            $damage = rand(1.5, 3) / 10;
            $target->setHealthPoints($this->damage * $damage);
            $this->arrow -= 1;
            $this->specialAttack = false;
            $status = "$this->name tire une flèche sur $target->name et touche un point critique ! Il reste $target->healthPoints points de vie à $target->name !";
        } else {
            $this->specialAttack = true;
            $status = "$this->name vise attentivement $target->name !";
        }
        return $status;
    }
    
    public function attack($target) {
        $target->setHealthPoints($this->dagger);
        $status = "$this->name donne un coup de dague à $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        return $status;
    }

    public function arrow($target) {
        $target->setHealthPoints($this->damage);
        $this->arrow -= 1;
        $status = "$this->name tire une flèche sur $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        return $status;
    }
}